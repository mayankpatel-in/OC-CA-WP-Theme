<?php
/**
 * OC CA Theme — Plugin Manager
 *
 * Native WordPress plugin checker. No third-party dependencies.
 * Requires PHP 8.0+ / WordPress 6.0+.
 *
 * Features:
 *  - Admin notice for required (error) and recommended (warning, dismissible) plugins
 *  - Appearance → Required Plugins page with Install / Activate one-click links
 *  - Per-user dismissal for recommended-plugin notice (stored in user meta)
 *
 * Usage: call OC_CA_Plugin_Manager::register( $plugins ) once after the
 *        class is loaded (see inc/required-plugins.php).
 *
 * @package OC_CA_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class OC_CA_Plugin_Manager {

    private static array $plugins    = [];
    private const        DISMISS_KEY = 'oc_ca_dismissed_plugin_notice';
    private const        PAGE_SLUG   = 'oc-ca-required-plugins';

    // ── Bootstrap ─────────────────────────────────────────────

    /**
     * Register plugins and attach all WP hooks.
     *
     * @param array $plugins Array of plugin definition arrays.
     */
    public static function register( array $plugins ): void {
        self::$plugins = $plugins;

        add_action( 'admin_notices',                               [ __CLASS__, 'admin_notice' ] );
        add_action( 'admin_menu',                                  [ __CLASS__, 'add_page' ] );
        add_action( 'admin_post_oc_ca_dismiss_plugin_notice',      [ __CLASS__, 'handle_dismiss' ] );
        add_action( 'admin_enqueue_scripts',                       [ __CLASS__, 'enqueue_page_assets' ] );
    }

    // ── Internal helpers ──────────────────────────────────────

    private static function load_plugin_functions(): void {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
    }

    /**
     * Returns 'active' | 'inactive' | 'missing' for a given plugin file.
     */
    private static function status( string $file ): string {
        self::load_plugin_functions();

        if ( is_plugin_active( $file ) ) {
            return 'active';
        }

        if ( array_key_exists( $file, get_plugins() ) ) {
            return 'inactive';
        }

        return 'missing';
    }

    /**
     * Returns [ $required_pending[], $recommended_pending[] ] — plugins
     * that are not yet active.
     */
    private static function pending(): array {
        $required    = [];
        $recommended = [];

        foreach ( self::$plugins as $plugin ) {
            if ( self::status( $plugin['file'] ) === 'active' ) {
                continue;
            }
            if ( ! empty( $plugin['required'] ) ) {
                $required[] = $plugin;
            } else {
                $recommended[] = $plugin;
            }
        }

        return [ $required, $recommended ];
    }

    // ── Admin notice ──────────────────────────────────────────

    public static function admin_notice(): void {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        [ $required, $recommended ] = self::pending();
        $page_url = admin_url( 'themes.php?page=' . self::PAGE_SLUG );

        // Required — red error notice (non-dismissible)
        if ( $required ) {
            $list = implode( ', ', array_map(
                fn( array $p ): string => '<strong>' . esc_html( $p['name'] ) . '</strong>',
                $required
            ) );
            echo '<div class="notice notice-error"><p>';
            printf(
                /* translators: %1$s plugin names, %2$s fix-now URL */
                wp_kses(
                    __( '<strong>OC CA Theme</strong> requires the following plugin(s) to be active: %1$s. <a href="%2$s">Fix now &rarr;</a>', 'oc-ca-theme' ),
                    [ 'strong' => [], 'a' => [ 'href' => [] ] ]
                ),
                $list, // already escaped above
                esc_url( $page_url )
            );
            echo '</p></div>';
        }

        // Recommended — yellow warning notice (dismissible per-user)
        $dismissed = (bool) get_user_meta( get_current_user_id(), self::DISMISS_KEY, true );
        if ( $recommended && ! $dismissed ) {
            $list = implode( ', ', array_map(
                fn( array $p ): string => '<strong>' . esc_html( $p['name'] ) . '</strong>',
                $recommended
            ) );
            $dismiss_url = wp_nonce_url(
                admin_url( 'admin-post.php?action=oc_ca_dismiss_plugin_notice' ),
                'oc_ca_dismiss_plugin_notice'
            );
            echo '<div class="notice notice-warning"><p>';
            printf(
                /* translators: %1$s plugin names, %2$s view URL, %3$s dismiss URL */
                wp_kses(
                    __( '<strong>OC CA Theme</strong> recommends: %1$s. <a href="%2$s">View details &rarr;</a> &nbsp; <a href="%3$s" style="color:#888;font-size:12px;">Dismiss</a>', 'oc-ca-theme' ),
                    [ 'strong' => [], 'a' => [ 'href' => [], 'style' => [] ] ]
                ),
                $list,
                esc_url( $page_url ),
                esc_url( $dismiss_url )
            );
            echo '</p></div>';
        }
    }

    public static function handle_dismiss(): void {
        check_admin_referer( 'oc_ca_dismiss_plugin_notice' );

        if ( current_user_can( 'install_plugins' ) ) {
            update_user_meta( get_current_user_id(), self::DISMISS_KEY, 1 );
        }

        wp_safe_redirect( wp_get_referer() ?: admin_url() );
        exit;
    }

    // ── Admin page ────────────────────────────────────────────

    public static function add_page(): void {
        add_theme_page(
            __( 'Required Plugins', 'oc-ca-theme' ),
            __( 'Required Plugins', 'oc-ca-theme' ),
            'install_plugins',
            self::PAGE_SLUG,
            [ __CLASS__, 'render_page' ]
        );
    }

    public static function enqueue_page_assets( string $hook ): void {
        if ( $hook !== 'appearance_page_' . self::PAGE_SLUG ) {
            return;
        }
        // Inline styles scoped to our table only
        wp_add_inline_style( 'list-tables', '
            .oc-pm-status-active   { color: #46b450; font-weight: 600; }
            .oc-pm-status-inactive { color: #f0b849; font-weight: 600; }
            .oc-pm-status-missing  { color: #dc3232; font-weight: 600; }
            .oc-pm-badge-required  { color: #dc3232; font-weight: 700; }
            .oc-pm-badge-rec       { color: #555; }
            #oc-pm-table th        { white-space: nowrap; }
        ' );
    }

    public static function render_page(): void {
        self::load_plugin_functions();

        [ $required, $recommended ] = self::pending();
        $all_pending = count( $required ) + count( $recommended );
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Required &amp; Recommended Plugins', 'oc-ca-theme' ); ?></h1>

            <?php if ( $all_pending === 0 ) : ?>
                <div class="notice notice-success inline">
                    <p><?php esc_html_e( 'All plugins are installed and active.', 'oc-ca-theme' ); ?></p>
                </div>
            <?php else : ?>
                <p><?php
                    printf(
                        /* translators: %d number of pending plugins */
                        esc_html( _n(
                            '%d plugin needs attention.',
                            '%d plugins need attention.',
                            $all_pending,
                            'oc-ca-theme'
                        ) ),
                        (int) $all_pending
                    );
                ?></p>
            <?php endif; ?>

            <table id="oc-pm-table" class="wp-list-table widefat fixed striped plugins">
                <thead>
                    <tr>
                        <th style="width:20%"><?php esc_html_e( 'Plugin', 'oc-ca-theme' ); ?></th>
                        <th><?php esc_html_e( 'Purpose', 'oc-ca-theme' ); ?></th>
                        <th style="width:12%"><?php esc_html_e( 'Type', 'oc-ca-theme' ); ?></th>
                        <th style="width:18%"><?php esc_html_e( 'Status', 'oc-ca-theme' ); ?></th>
                        <th style="width:13%"><?php esc_html_e( 'Action', 'oc-ca-theme' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ( self::$plugins as $plugin ) :
                    $status = self::status( $plugin['file'] );

                    // Status badge
                    $badge = match ( $status ) {
                        'active'   => '<span class="oc-pm-status-active">&#10003; ' . esc_html__( 'Active', 'oc-ca-theme' ) . '</span>',
                        'inactive' => '<span class="oc-pm-status-inactive">&#9888; ' . esc_html__( 'Installed, inactive', 'oc-ca-theme' ) . '</span>',
                        default    => '<span class="oc-pm-status-missing">&#10007; ' . esc_html__( 'Not installed', 'oc-ca-theme' ) . '</span>',
                    };

                    // Action button
                    $action = match ( $status ) {
                        'active' => '&mdash;',

                        'inactive' => sprintf(
                            '<a href="%s" class="button button-secondary button-small">%s</a>',
                            esc_url( wp_nonce_url(
                                admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $plugin['file'] ) ),
                                'activate-plugin_' . $plugin['file']
                            ) ),
                            esc_html__( 'Activate', 'oc-ca-theme' )
                        ),

                        default => sprintf(
                            '<a href="%s" class="button button-primary button-small">%s</a>',
                            esc_url( wp_nonce_url(
                                admin_url( 'update.php?action=install-plugin&plugin=' . rawurlencode( $plugin['slug'] ) ),
                                'install-plugin_' . $plugin['slug']
                            ) ),
                            esc_html__( 'Install', 'oc-ca-theme' )
                        ),
                    };

                    $type_html = ! empty( $plugin['required'] )
                        ? '<span class="oc-pm-badge-required">' . esc_html__( 'Required', 'oc-ca-theme' ) . '</span>'
                        : '<span class="oc-pm-badge-rec">' . esc_html__( 'Recommended', 'oc-ca-theme' ) . '</span>';
                ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html( $plugin['name'] ); ?></strong>
                            <?php if ( ! empty( $plugin['slug'] ) ) : ?>
                                <br><a href="<?php echo esc_url( 'https://wordpress.org/plugins/' . $plugin['slug'] . '/' ); ?>" target="_blank" rel="noopener noreferrer" style="font-size:12px;">
                                    <?php esc_html_e( 'View on WordPress.org', 'oc-ca-theme' ); ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html( $plugin['description'] ?? '' ); ?></td>
                        <td><?php echo $type_html; // phpcs:ignore ?></td>
                        <td><?php echo $badge;     // phpcs:ignore ?></td>
                        <td><?php echo $action;    // phpcs:ignore ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
