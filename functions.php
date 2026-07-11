<?php
/**
 * OC CA Theme - Functions
 *
 * Theme setup, asset enqueuing, navigation menus, widget areas,
 * and custom theme supports.
 *
 * @package OC_CA_Theme
 */

// ============================================================
// 1. THEME SETUP
// ============================================================
function oc_ca_theme_setup() {
    // Enable title tags managed by WordPress
    add_theme_support( 'title-tag' );

    // Support for Post Thumbnails (featured images)
    add_theme_support( 'post-thumbnails' );

    // Add HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Wide & Full alignment support for Gutenberg blocks
    add_theme_support( 'align-wide' );

    // Editor styles
    add_theme_support( 'editor-styles' );

    // Register Navigation Menus
    register_nav_menus( array(
        'primary'      => esc_html__( 'Primary Navigation', 'oc-ca-theme' ),
        'footer-links' => esc_html__( 'Footer Quick Links', 'oc-ca-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'oc_ca_theme_setup' );


// ============================================================
// 2. ENQUEUE STYLES & SCRIPTS
// ============================================================
function oc_ca_theme_scripts() {
    // Google Fonts: Inter + Outfit
    wp_enqueue_style(
        'oc-ca-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap',
        array(),
        null
    );

    // FontAwesome Icons
    wp_enqueue_style(
        'oc-ca-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    // Main Theme CSS
    wp_enqueue_style(
        'oc-ca-theme-css',
        get_template_directory_uri() . '/assets/css/theme.css',
        array( 'oc-ca-google-fonts', 'oc-ca-fontawesome' ),
        '1.0.4'
    );

    // WordPress style.css (required)
    wp_enqueue_style(
        'oc-ca-style',
        get_stylesheet_uri(),
        array( 'oc-ca-theme-css' ),
        '1.0.0'
    );

    // Main Theme JS (deferred, in footer)
    wp_enqueue_script(
        'oc-ca-theme-js',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        '1.0.4',
        true // load in footer
    );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'oc_ca_theme_scripts' );


// ============================================================
// 3. WIDGET AREAS (SIDEBARS)
// ============================================================
function oc_ca_theme_widgets_init() {
    // Blog Sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', 'oc-ca-theme' ),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__( 'Widgets shown in the right sidebar on blog and single post pages.', 'oc-ca-theme' ),
        'before_widget' => '<div id="%1$s" class="sidebar-card widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar-widget-title">',
        'after_title'   => '</h4>',
    ) );

    $footer_cols = array(
        'footer-col-2' => 'Footer Column 2 (Quick Links)',
        'footer-col-3' => 'Footer Column 3 (Recent Posts)',
        'footer-col-4' => 'Footer Column 4 (Newsletter)',
    );
    foreach ( $footer_cols as $id => $name ) {
        register_sidebar( array(
            'name'          => esc_html__( $name, 'oc-ca-theme' ),
            'id'            => $id,
            'description'   => esc_html__( 'Override the default content in this footer column with widgets.', 'oc-ca-theme' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'oc_ca_theme_widgets_init' );


// ============================================================
// 4. CUSTOM EXCERPT LENGTH
// ============================================================
function oc_ca_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'oc_ca_excerpt_length' );

function oc_ca_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'oc_ca_excerpt_more' );


// ============================================================
// 5. CUSTOM TEMPLATE TAGS
// ============================================================

/**
 * Render post meta (date, author, categories)
 */
function oc_ca_post_meta() {
    echo '<div class="post-meta">';
    echo '<span><i class="fa-solid fa-calendar"></i> ' . get_the_date() . '</span>';
    echo '<span><i class="fa-solid fa-user"></i> By ' . get_the_author() . '</span>';
    $cats = get_the_category();
    if ( $cats ) {
        echo '<span><i class="fa-solid fa-folder"></i> ' . esc_html( $cats[0]->name ) . '</span>';
    }
    echo '</div>';
}

/**
 * Render breadcrumbs
 */
function oc_ca_breadcrumbs() {
    $sep = '<li class="sep"><i class="fa-solid fa-angle-right"></i></li>';
    echo '<ul class="breadcrumbs">';
    echo '<li><a href="' . home_url() . '">Home</a></li>';

    if ( is_single() ) {
        $cats = get_the_category();
        if ( $cats ) {
            echo $sep;
            echo '<li><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a></li>';
        }
        echo $sep;
        echo '<li class="active">' . get_the_title() . '</li>';
    } elseif ( is_page() ) {
        echo $sep;
        echo '<li class="active">' . get_the_title() . '</li>';
    } elseif ( is_archive() ) {
        echo $sep;
        echo '<li class="active">' . get_the_archive_title() . '</li>';
    } elseif ( is_search() ) {
        echo $sep;
        echo '<li class="active">Search Results for: ' . get_search_query() . '</li>';
    } elseif ( is_home() ) {
        echo $sep;
        echo '<li class="active">Blog</li>';
    }
    echo '</ul>';
}


// ============================================================
// 6. INCLUDE MEGA MENU WALKER
// ============================================================
require_once get_template_directory() . '/inc/class-mega-menu-walker.php';


// ============================================================
// 6b. PLUGIN MANAGER
// ============================================================
require_once get_template_directory() . '/inc/class-plugin-manager.php';
require_once get_template_directory() . '/inc/required-plugins.php';


// ============================================================
// 7. CONTENT WIDTH
// ============================================================
if ( ! isset( $content_width ) ) {
    $content_width = 1240;
}


// ============================================================
// 8. CUSTOMIZER — LOGO SIZE SETTINGS
// ============================================================

/**
 * Range slider control for the Customizer.
 * Renders an <input type="range"> with a live px readout.
 * Set $device to 'desktop' or 'mobile' so the JS device-tab
 * switcher can show/hide this control when the user clicks the
 * Desktop / Mobile preview buttons in the Customizer toolbar.
 */
// WP_Customize_Control is only loaded in Customizer context; guard before extending it.
if ( class_exists( 'WP_Customize_Control' ) ) :

class OC_CA_Range_Control extends WP_Customize_Control {
    public $type   = 'oc-ca-range';
    public $device = ''; // 'desktop' | 'mobile'

    public function render_content() {
        $id   = '_customize-input-' . $this->id;
        $min  = isset( $this->input_attrs['min'] )  ? (int) $this->input_attrs['min']  : 20;
        $max  = isset( $this->input_attrs['max'] )  ? (int) $this->input_attrs['max']  : 200;
        $step = isset( $this->input_attrs['step'] ) ? (int) $this->input_attrs['step'] : 1;

        if ( $this->device === 'mobile' ) {
            $icon = '<span class="dashicons dashicons-smartphone" style="vertical-align:middle;color:#2271b1;margin-right:4px;"></span>';
        } elseif ( $this->device === 'desktop' ) {
            $icon = '<span class="dashicons dashicons-desktop" style="vertical-align:middle;color:#2271b1;margin-right:4px;"></span>';
        } else {
            $icon = '';
        }
        ?>
        <label>
            <span class="customize-control-title">
                <?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <?php echo esc_html( $this->label ); ?>
            </span>
            <div class="oc-ca-range-wrap" data-device="<?php echo esc_attr( $this->device ); ?>">
                <input
                    id="<?php echo esc_attr( $id ); ?>"
                    type="range"
                    class="oc-ca-range-input"
                    min="<?php echo esc_attr( $min ); ?>"
                    max="<?php echo esc_attr( $max ); ?>"
                    step="<?php echo esc_attr( $step ); ?>"
                    value="<?php echo esc_attr( $this->value() ); ?>"
                    <?php $this->link(); ?>
                >
                <output class="oc-ca-range-value" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $this->value() ); ?></output>
                <span class="oc-ca-range-unit">px</span>
            </div>
        </label>
        <?php
    }
}

endif; // class_exists( 'WP_Customize_Control' )


function oc_ca_customize_register( $wp_customize ) {

    // ── Header logo heights → Site Identity (title_tagline) ──
    // Placed next to the logo upload so everything is in one place.
    $header_logo_controls = array(
        'header_logo_height_desktop' => array(
            'label'   => __( 'Header Logo Height — Desktop', 'oc-ca-theme' ),
            'default' => 42,
            'device'  => 'desktop',
        ),
        'header_logo_height_mobile' => array(
            'label'   => __( 'Header Logo Height — Mobile', 'oc-ca-theme' ),
            'default' => 32,
            'device'  => 'mobile',
        ),
    );

    foreach ( $header_logo_controls as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control(
            new OC_CA_Range_Control( $wp_customize, $id, array(
                'label'       => $args['label'],
                'section'     => 'title_tagline', // built-in Site Identity section
                'device'      => $args['device'],
                'input_attrs' => array( 'min' => 20, 'max' => 200, 'step' => 1 ),
            ) )
        );
    }

    // ── Footer Logo section ────────────────────────────────────
    $wp_customize->add_section( 'oc_ca_logo_sizes', array(
        'title'       => __( 'Footer Logo', 'oc-ca-theme' ),
        'description' => __( 'Upload a separate logo for the footer and set its height. Switch Desktop / Mobile tabs to control each size.', 'oc-ca-theme' ),
        'priority'    => 31,
    ) );

    // Footer logo image upload (separate from the header / site-identity logo)
    $wp_customize->add_setting( 'footer_logo', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control(
        new WP_Customize_Media_Control( $wp_customize, 'footer_logo', array(
            'label'     => __( 'Footer Logo Image', 'oc-ca-theme' ),
            'section'   => 'oc_ca_logo_sizes',
            'mime_type' => 'image',
            'priority'  => 1,
        ) )
    );

    // Footer logo heights
    $footer_logo_controls = array(
        'footer_logo_height_desktop' => array(
            'label'   => __( 'Footer Logo Height — Desktop', 'oc-ca-theme' ),
            'default' => 42,
            'device'  => 'desktop',
        ),
        'footer_logo_height_mobile' => array(
            'label'   => __( 'Footer Logo Height — Mobile', 'oc-ca-theme' ),
            'default' => 32,
            'device'  => 'mobile',
        ),
    );

    foreach ( $footer_logo_controls as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control(
            new OC_CA_Range_Control( $wp_customize, $id, array(
                'label'       => $args['label'],
                'section'     => 'oc_ca_logo_sizes',
                'device'      => $args['device'],
                'input_attrs' => array( 'min' => 20, 'max' => 200, 'step' => 1 ),
            ) )
        );
    }

    // ---- Footer Column 1 — Company Info ----
    $wp_customize->add_section( 'oc_ca_footer_col1', array(
        'title'    => __( 'Footer — Company Info', 'oc-ca-theme' ),
        'priority' => 36,
    ) );

    $footer_text_fields = array(
        'footer_company_desc' => array(
            'label'   => __( 'Company Description', 'oc-ca-theme' ),
            'default' => 'A trusted and versatile Chartered Accountant firm in Pune, India. Committed to rendering top professional services with independence, integrity, and efficiency.',
            'type'    => 'textarea',
        ),
        'footer_address' => array(
            'label'   => __( 'Address', 'oc-ca-theme' ),
            'default' => 'G 20 Ashoka Mall, Bund Garden Road, Pune - 411001',
            'type'    => 'text',
        ),
        'footer_phone' => array(
            'label'   => __( 'Phone', 'oc-ca-theme' ),
            'default' => '+91 80555 66789',
            'type'    => 'text',
        ),
        'footer_email' => array(
            'label'   => __( 'Email', 'oc-ca-theme' ),
            'default' => 'office@anbca.com',
            'type'    => 'text',
        ),
        'footer_fb_url' => array(
            'label'   => __( 'Facebook URL', 'oc-ca-theme' ),
            'default' => '#',
            'type'    => 'url',
        ),
        'footer_tw_url' => array(
            'label'   => __( 'Twitter URL', 'oc-ca-theme' ),
            'default' => '#',
            'type'    => 'url',
        ),
        'footer_li_url' => array(
            'label'   => __( 'LinkedIn URL', 'oc-ca-theme' ),
            'default' => '#',
            'type'    => 'url',
        ),
        'footer_wa_number' => array(
            'label'   => __( 'WhatsApp Number (with country code, no spaces or +)', 'oc-ca-theme' ),
            'default' => '918055566789',
            'type'    => 'text',
        ),
    );

    foreach ( $footer_text_fields as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => $args['label'],
            'section' => 'oc_ca_footer_col1',
            'type'    => $args['type'],
        ) );
    }

    // ---- Footer Bar ----
    $wp_customize->add_section( 'oc_ca_footer_bar', array(
        'title'    => __( 'Footer Bar', 'oc-ca-theme' ),
        'priority' => 37,
    ) );

    $wp_customize->add_setting( 'footer_credit_text', array(
        'default'           => 'Designed with ❤️ in India',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'footer_credit_text', array(
        'label'   => __( 'Credit Text', 'oc-ca-theme' ),
        'section' => 'oc_ca_footer_bar',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'oc_ca_customize_register' );


// Front-end: publish saved logo sizes as CSS custom properties.
// theme.css uses var(--logo-h-*) so there are no selector-specificity conflicts.
function oc_ca_logo_size_css() {
    $hd = absint( get_theme_mod( 'header_logo_height_desktop', 42 ) );
    $hm = absint( get_theme_mod( 'header_logo_height_mobile',  32 ) );
    $fd = absint( get_theme_mod( 'footer_logo_height_desktop', 42 ) );
    $fm = absint( get_theme_mod( 'footer_logo_height_mobile',  32 ) );

    $css = ":root{--logo-h-desktop:{$hd}px;--logo-h-mobile:{$hm}px;--footer-logo-h-desktop:{$fd}px;--footer-logo-h-mobile:{$fm}px;}";

    wp_add_inline_style( 'oc-ca-theme-css', $css );
}
add_action( 'wp_enqueue_scripts', 'oc_ca_logo_size_css', 20 );


// Customizer panel: range slider JS + device-tab switcher + control styles.
function oc_ca_customize_controls_enqueue() {
    wp_enqueue_script(
        'oc-ca-customize-controls',
        get_template_directory_uri() . '/assets/js/customize-controls.js',
        array( 'jquery', 'customize-controls' ),
        '1.0.2',
        true
    );

    wp_add_inline_style( 'customize-controls', '
        .oc-ca-range-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
        }
        .oc-ca-range-input {
            flex: 1;
            accent-color: #2271b1;
            cursor: pointer;
        }
        .oc-ca-range-value {
            min-width: 28px;
            text-align: right;
            font-weight: 600;
            color: #2271b1;
            font-size: 13px;
        }
        .oc-ca-range-unit {
            color: #666;
            font-size: 12px;
        }
    ' );
}
add_action( 'customize_controls_enqueue_scripts', 'oc_ca_customize_controls_enqueue' );


// Customizer preview iframe: live CSS injection on slider change (postMessage).
function oc_ca_customize_preview_enqueue() {
    wp_enqueue_script(
        'oc-ca-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview.js',
        array( 'customize-preview' ),
        '1.0.2',
        true
    );
}
add_action( 'customize_preview_init', 'oc_ca_customize_preview_enqueue' );


// ============================================================
// 9. GITHUB THEME UPDATER  (Plugin Update Checker v5)
// ============================================================
//
// One-time setup:
//   1. Download PUC from:
//        https://github.com/YahnisElsts/plugin-update-checker/releases/latest
//      Place the extracted folder inside the theme so this path exists:
//        oc-ca-theme/plugin-update-checker/plugin-update-checker.php
//
//   2. Publish a GitHub Release tagged v1.0.0 (or higher).
//      WordPress will surface "Update available" automatically on every site
//      running this theme — no per-site configuration needed.
//
// This is a PUBLIC repo so no access token is required.
// The repo URL is baked in here once and works for all installs.

( static function (): void {

    $puc_bootstrap = get_template_directory() . '/plugin-update-checker/plugin-update-checker.php';

    if ( ! file_exists( $puc_bootstrap ) ) {
        return;
    }

    require_once $puc_bootstrap;

    $updater = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/mayankpatel-in/OC-CA-WP-Theme/',  // public repo — no token needed
        get_template_directory() . '/style.css',           // themes use style.css, not __FILE__
        'oc-ca-theme'                                      // must match the theme folder name
    );

    // Pull update packages from tagged GitHub Releases (vX.Y.Z), not the branch zip.
    $updater->getVcsApi()->enableReleaseAssets();

} )();
