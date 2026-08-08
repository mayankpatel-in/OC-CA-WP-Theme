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
        '1.1.2'
    );

    // WordPress style.css (required)
    wp_enqueue_style(
        'oc-ca-style',
        get_stylesheet_uri(),
        array( 'oc-ca-theme-css' ),
        '1.1.2'
    );

    // Main Theme JS (deferred, in footer)
    wp_enqueue_script(
        'oc-ca-theme-js',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        '1.1.2',
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


/**
 * Default team member profiles. Shared by the Customizer controls
 * (as their defaults) and the homepage team section render, so the
 * team shows even before the Customizer has ever been saved.
 */
function oc_ca_home_team_defaults() {
    return array(
        1 => array(
            'name'   => 'CA Amit Bhutada',
            'role'   => 'Founder & Managing Partner',
            'img'    => 'ca-amit.png',
            'bio'    => 'CA Amit Bhutada is the founder of A N Bhutada & Co. With over 10 years of professional experience, he advises Indian and international businesses on company incorporation, taxation, regulatory compliance, and business growth. He specializes in helping startups, SMEs, and overseas investors establish and manage their operations in India.',
            'skills' => "Private Limited Company Incorporation\nInternational Business Setup In India\nCorporate Compliances\nGST Advisory\nBusiness Advisory for Startups & Growing Businesses",
        ),
        2 => array(
            'name'   => 'CA Ravish Maniyar',
            'role'   => 'Associate – Audit & Advisory',
            'img'    => 'ca-ravish.jpeg',
            'bio'    => 'CA Ravish Maniyar brings over 15 years of experience in audit, assurance, and financial advisory services. He has extensive expertise in conducting statutory, tax, bank, and internal audits across diverse industries while helping organizations strengthen governance and internal controls.',
            'skills' => "Statutory Audits & Tax Audits\nBank Audits & Government Audits\nInternal Control & Compliance Systems\nRisk Management & Financial Advisory",
        ),
        3 => array(
            'name'   => 'CS, Adv. Priyanka Bajaj',
            'role'   => 'Company Secretary & Advocate',
            'img'    => 'cs-priyanka.jpeg',
            'bio'    => 'CS Priyanka Bajaj has more than 10 years of experience in corporate laws and secretarial compliance. She advises companies on corporate governance, FEMA regulations, business structuring, and legal compliance under the Companies Act.',
            'skills' => "Corporate Compliances\nFEMA Compliances\nCompany Setup Advisory\nStartup Advisory Services",
        ),
        4 => array(
            'name'   => 'Avinash Sable',
            'role'   => 'Senior Associate – Compliance',
            'img'    => 'avinash-sable.jpg',
            'bio'    => 'Avinash Sable is a Commerce Graduate with over 5 years of experience in accounting, taxation, payroll, and statutory compliance. He serves as a dedicated point of contact for clients, ensuring timely completion of routine compliance requirements.',
            'skills' => "Accounting\nPayroll Processing\nGST, TDS & Tax Filings\nStartup Advisory Services",
        ),
        5 => array(
            'name'   => 'Yukta Shah',
            'role'   => 'Associate – Taxation & Audit',
            'img'    => 'yukta-shah.jpeg',
            'bio'    => 'Yukta Shah is a Commerce Graduate and CA Final student with over 5 years of practical experience in accounting, audit, and taxation. She supports businesses in maintaining statutory compliance and provides assistance in audit and indirect tax matters.',
            'skills' => "GST Compliances\nStatutory Auditing\nTax Planning\nIndirect Tax Advisory",
        ),
        6 => array(
            'name'   => 'Prabhanjan Patil',
            'role'   => 'Associate – Corporate & FEMA',
            'img'    => 'prabhanjan-patil.jpg',
            'bio'    => 'Prabhanjan Patil has extensive experience in corporate compliance, company law, and FEMA regulations. He advises Indian companies and foreign investors on regulatory compliance, FDI transactions, and corporate structuring, helping businesses remain compliant with the Companies Act and FEMA regulations.',
            'skills' => "ESOP Structuring & Compliance\nForeign Direct Investment Compliances\nCorporate Advisory & Secretarial Support\nFEMA Compliances",
        ),
        7 => array( 'name' => '', 'role' => '', 'img' => '', 'bio' => '', 'skills' => '' ),
        8 => array( 'name' => '', 'role' => '', 'img' => '', 'bio' => '', 'skills' => '' ),
    );
}

/**
 * Sanitize a team member photo value: attachment ID from the media
 * picker, or a legacy filename / URL string from older saves.
 */
function oc_ca_sanitize_team_img( $value ) {
    if ( is_numeric( $value ) ) {
        return absint( $value );
    }
    return sanitize_text_field( $value );
}

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
            'default' => 'Office No. 404 to 407, 5th Floor, Lotus Court, Above Kaka Halwai, Pune Satara Road (near Panchami Hotel), Swargate, Pune - 411009',
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
    // ── Home: Services Grid ──────────────────────────────────────────────
    $wp_customize->add_section( 'oc_ca_home_services', array(
        'title'       => __( 'Home – Services Grid', 'oc-ca-theme' ),
        'description' => __( 'Edit the 8 service cards shown on the homepage. Set Price to 0 to hide it. Choose a page for the "More" button.', 'oc-ca-theme' ),
        'priority'    => 36,
    ) );

    $home_service_defaults = array(
        1 => array( 'icon' => 'fa-file-invoice',           'title' => 'GST Registration',    'desc' => 'Get your GST number in 3 days with complete ARN registration and 1-month comprehensive filing support.', 'price' => 2800 ),
        2 => array( 'icon' => 'fa-building-shield',        'title' => 'Company Registration', 'desc' => 'Incorporate your Private Limited or LLP with AOA, MOA, COI, DSC, PAN & TAN secured in just 15 days.',   'price' => 9800 ),
        3 => array( 'icon' => 'fa-users-gear',             'title' => 'Payroll Processing',   'desc' => 'Accurate monthly payroll processing with full compliance management for PF, ESIC, PT, and TDS deductions.', 'price' => 1499 ),
        4 => array( 'icon' => 'fa-user-tie',               'title' => 'Proprietorship',       'desc' => 'Start a sole proprietorship business managed, owned, and controlled by a single individual securely.',    'price' => 1499 ),
        5 => array( 'icon' => 'fa-receipt',                'title' => 'GST Filing',           'desc' => 'Accurate monthly or quarterly GST return files prepared by certified experts to keep your compliance clean.', 'price' => 999 ),
        6 => array( 'icon' => 'fa-magnifying-glass-chart', 'title' => 'Tax Audit',            'desc' => 'Deep review and evaluation of your business books and returns by Chartered Accountants to ensure accuracy.', 'price' => 15000 ),
        7 => array( 'icon' => 'fa-hand-holding-dollar',    'title' => 'Income Tax Filing',    'desc' => 'File online returns with customized advisory inputs from tax specialists to guarantee maximum tax savings.', 'price' => 1499 ),
        8 => array( 'icon' => 'fa-cloud-arrow-up',         'title' => 'Cloud Accounting',     'desc' => 'Modern books setup using Zoho, QuickBooks, and Wave. Ideal for small, medium, and fast-growing companies.', 'price' => 3800 ),
    );

    foreach ( $home_service_defaults as $n => $d ) {
        $pfx = 'home_service_' . $n . '_';
        $lbl = "Service {$n}";

        $wp_customize->add_setting( $pfx . 'icon',  array( 'default' => $d['icon'],  'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'icon',  array( 'label' => "{$lbl}: Icon class (e.g. fa-receipt)", 'section' => 'oc_ca_home_services', 'type' => 'text' ) );

        $wp_customize->add_setting( $pfx . 'title', array( 'default' => $d['title'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'title', array( 'label' => "{$lbl}: Title", 'section' => 'oc_ca_home_services', 'type' => 'text' ) );

        $wp_customize->add_setting( $pfx . 'desc',  array( 'default' => $d['desc'],  'sanitize_callback' => 'wp_strip_all_tags', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'desc',  array( 'label' => "{$lbl}: Description", 'section' => 'oc_ca_home_services', 'type' => 'textarea' ) );

        $wp_customize->add_setting( $pfx . 'price', array( 'default' => $d['price'], 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'price', array( 'label' => "{$lbl}: Starting price \u{20B9} (0 = hide)", 'section' => 'oc_ca_home_services', 'type' => 'number', 'input_attrs' => array( 'min' => 0, 'step' => 1 ) ) );

        $wp_customize->add_setting( $pfx . 'page',  array( 'default' => 0, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'page',  array( 'label' => "{$lbl}: \"More\" button page", 'section' => 'oc_ca_home_services', 'type' => 'dropdown-pages' ) );
    }

    // ── Home – Team Section ─────────────────────────────────────────────────
    $wp_customize->add_section( 'oc_ca_home_team', array(
        'title'    => __( 'Home – Team Section', 'oc-ca-theme' ),
        'priority' => 37,
    ) );

    $team_defaults = oc_ca_home_team_defaults();

    foreach ( $team_defaults as $n => $d ) {
        $pfx = 'home_team_' . $n . '_';
        $lbl = 'Member ' . $n;

        $wp_customize->add_setting( $pfx . 'name',   array( 'default' => $d['name'],   'sanitize_callback' => 'sanitize_text_field',    'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'name',   array( 'label' => "{$lbl}: Name",                               'section' => 'oc_ca_home_team', 'type' => 'text' ) );

        $wp_customize->add_setting( $pfx . 'role',   array( 'default' => $d['role'],   'sanitize_callback' => 'sanitize_text_field',    'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'role',   array( 'label' => "{$lbl}: Role / Designation",                 'section' => 'oc_ca_home_team', 'type' => 'text' ) );

        // Photo: media library picker. Stores an attachment ID; legacy saved
        // values (filename or URL string) are still accepted and rendered.
        $wp_customize->add_setting( $pfx . 'img',    array( 'default' => $d['img'],    'sanitize_callback' => 'oc_ca_sanitize_team_img',   'transport' => 'refresh' ) );
        $wp_customize->add_control(
            new WP_Customize_Media_Control( $wp_customize, $pfx . 'img', array(
                'label'     => "{$lbl}: Photo",
                'section'   => 'oc_ca_home_team',
                'mime_type' => 'image',
            ) )
        );

        $wp_customize->add_setting( $pfx . 'bio',    array( 'default' => $d['bio'],    'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'bio',    array( 'label' => "{$lbl}: Bio paragraph",                      'section' => 'oc_ca_home_team', 'type' => 'textarea' ) );

        $wp_customize->add_setting( $pfx . 'skills', array( 'default' => $d['skills'], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $pfx . 'skills', array( 'label' => "{$lbl}: Skills — one per line",              'section' => 'oc_ca_home_team', 'type' => 'textarea' ) );
    }

    $wp_customize->add_section( 'oc_ca_footer_bar', array(
        'title'    => __( 'Footer Bar', 'oc-ca-theme' ),
        'priority' => 38,
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


// ============================================================
// 10. SERVICE PAGE META BOX  (Hero section fields)
// ============================================================
//
// Adds a "Service Hero Settings" panel inside the Page editor for any page
// using the "Service Page" template (page-service.php). Editors fill in:
//   • Hero Style           → _service_hero_style  ('hero1' | 'hero2')
//   • Price Tag text       → _service_price               (Hero 1)
//   • Hero Subtitle        → _service_subtitle             (Hero 1)
//   • Free Bundle Heading  → _service_free_title           (Hero 1)
//   • Free Item 1–4        → _service_free_{n}_icon + _service_free_{n}_label (Hero 1)
//   • Hero 2 Description   → _service_hero2_desc           (Hero 2)
//   • Hero 2 Checklist     → _service_hero2_points         (Hero 2, one point per line)
//
// The main article content (intro, features, tables, FAQs, etc.) is
// written directly in the page editor content area via the_content().

function oc_ca_register_service_meta_box() {
    add_meta_box(
        'oc_ca_service_hero',
        __( 'Service Hero Settings', 'oc-ca-theme' ),
        'oc_ca_service_meta_box_html',
        'page',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes_page', 'oc_ca_register_service_meta_box' );

function oc_ca_service_meta_box_html( $post ) {
    wp_nonce_field( 'oc_ca_service_hero_save', 'oc_ca_service_hero_nonce' );

    $hero_style   = get_post_meta( $post->ID, '_service_hero_style',   true ) ?: 'hero1';
    $price        = get_post_meta( $post->ID, '_service_price',        true );
    $subtitle     = get_post_meta( $post->ID, '_service_subtitle',     true );
    $free_ttl     = get_post_meta( $post->ID, '_service_free_title',   true );
    $hero2_desc   = get_post_meta( $post->ID, '_service_hero2_desc',   true );
    $hero2_points = get_post_meta( $post->ID, '_service_hero2_points', true );

    $default_icons  = array( 'fa-address-card', 'fa-file-invoice-dollar', 'fa-user-tie', 'fa-cloud' );
    $default_labels = array( 'Shop Act', 'Invoice Format', 'Consulting', 'Accounting Software' );

    $style_label = 'display:block;font-weight:600;font-size:11px;text-transform:uppercase;color:#646970;margin-bottom:3px;';
    $style_input = 'width:100%;margin-bottom:10px;';
    $style_hint  = 'font-size:11px;color:#8c8f94;margin-bottom:14px;display:block;';
    ?>
    <p style="font-size:12px;color:#646970;margin-top:0;">Only active when template is <strong>Service Page</strong>.</p>

    <label style="<?php echo $style_label; ?>">Hero Style</label>
    <select name="service_hero_style" id="oc_service_hero_style" style="<?php echo $style_input; ?>">
        <option value="hero1" <?php selected( $hero_style, 'hero1' ); ?>>Hero 1 — Price + Free Bundle</option>
        <option value="hero2" <?php selected( $hero_style, 'hero2' ); ?>>Hero 2 — Title + Description + Checklist</option>
    </select>
    <hr style="margin:10px 0;">

    <div id="oc_hero1_fields">
        <label style="<?php echo $style_label; ?>">Price Tag</label>
        <input type="text" name="service_price" value="<?php echo esc_attr( $price ); ?>" style="<?php echo $style_input; ?>" placeholder="@ Rs. 990 All Inclusive">

        <label style="<?php echo $style_label; ?>">Hero Subtitle</label>
        <input type="text" name="service_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" style="<?php echo $style_input; ?>" placeholder="100% Online Process & CA Services">

        <label style="<?php echo $style_label; ?>">Free Bundle Heading</label>
        <input type="text" name="service_free_title" value="<?php echo esc_attr( $free_ttl ); ?>" style="<?php echo $style_input; ?>" placeholder="Also Get Absolutely Free">

        <hr style="margin:10px 0;">
        <p style="font-size:11px;color:#8c8f94;margin:0 0 8px;">Free items — icon class (e.g. <code>fa-star</code>) + label text:</p>
        <?php for ( $i = 1; $i <= 4; $i++ ) :
            $icon  = get_post_meta( $post->ID, "_service_free_{$i}_icon",  true ) ?: $default_icons[ $i - 1 ];
            $label = get_post_meta( $post->ID, "_service_free_{$i}_label", true ) ?: $default_labels[ $i - 1 ];
        ?>
        <div style="display:flex;gap:6px;margin-bottom:6px;align-items:center;">
            <span style="font-size:11px;color:#646970;min-width:40px;">Item <?php echo $i; ?></span>
            <input type="text" name="service_free_<?php echo $i; ?>_icon"  value="<?php echo esc_attr( $icon ); ?>"  style="flex:1;" placeholder="fa-star">
            <input type="text" name="service_free_<?php echo $i; ?>_label" value="<?php echo esc_attr( $label ); ?>" style="flex:1.5;" placeholder="Label">
        </div>
        <?php endfor; ?>
    </div>

    <div id="oc_hero2_fields">
        <label style="<?php echo $style_label; ?>">Hero 2 Description</label>
        <textarea name="service_hero2_desc" rows="3" style="<?php echo $style_input; ?>" placeholder="Short description shown under the title"><?php echo esc_textarea( $hero2_desc ); ?></textarea>

        <label style="<?php echo $style_label; ?>">Hero 2 Checklist Points</label>
        <textarea name="service_hero2_points" rows="6" style="<?php echo $style_input; ?>" placeholder="One point per line&#10;e.g. Free Digital Signature&#10;Same Day Filing"><?php echo esc_textarea( $hero2_points ); ?></textarea>
        <span style="<?php echo $style_hint; ?>">One point per line — each becomes a checklist item with a tick mark.</span>
    </div>

    <script>
    ( function () {
        var sel = document.getElementById( 'oc_service_hero_style' );
        var h1  = document.getElementById( 'oc_hero1_fields' );
        var h2  = document.getElementById( 'oc_hero2_fields' );
        if ( ! sel || ! h1 || ! h2 ) {
            return;
        }
        function toggle() {
            var isHero2 = sel.value === 'hero2';
            h1.style.display = isHero2 ? 'none' : 'block';
            h2.style.display = isHero2 ? 'block' : 'none';
        }
        sel.addEventListener( 'change', toggle );
        toggle();
    } )();
    </script>
    <?php
}

function oc_ca_save_service_meta( $post_id ) {
    if ( ! isset( $_POST['oc_ca_service_hero_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oc_ca_service_hero_nonce'] ) ), 'oc_ca_service_hero_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['service_hero_style'] ) ) {
        $hero_style = sanitize_text_field( wp_unslash( $_POST['service_hero_style'] ) );
        update_post_meta( $post_id, '_service_hero_style', in_array( $hero_style, array( 'hero1', 'hero2' ), true ) ? $hero_style : 'hero1' );
    }

    $text_fields = array(
        'service_price'      => '_service_price',
        'service_subtitle'   => '_service_subtitle',
        'service_free_title' => '_service_free_title',
    );
    foreach ( $text_fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) ) );
        }
    }

    if ( isset( $_POST['service_hero2_desc'] ) ) {
        update_post_meta( $post_id, '_service_hero2_desc', sanitize_textarea_field( wp_unslash( $_POST['service_hero2_desc'] ) ) );
    }
    if ( isset( $_POST['service_hero2_points'] ) ) {
        update_post_meta( $post_id, '_service_hero2_points', sanitize_textarea_field( wp_unslash( $_POST['service_hero2_points'] ) ) );
    }

    for ( $i = 1; $i <= 4; $i++ ) {
        $icon_key  = "service_free_{$i}_icon";
        $label_key = "service_free_{$i}_label";
        if ( isset( $_POST[ $icon_key ] ) ) {
            // Strip the leading "fa-" if user typed the full class; allow any fa-* class string
            update_post_meta( $post_id, "_service_free_{$i}_icon",  sanitize_text_field( wp_unslash( $_POST[ $icon_key ] ) ) );
        }
        if ( isset( $_POST[ $label_key ] ) ) {
            update_post_meta( $post_id, "_service_free_{$i}_label", sanitize_text_field( wp_unslash( $_POST[ $label_key ] ) ) );
        }
    }
}
add_action( 'save_post_page', 'oc_ca_save_service_meta' );


// ============================================================
// 11. LEAD FORMS — CENTRAL ROUTING + EMAIL DELIVERY
// ============================================================
//
// Every quote/consultation/contact form on the site (home hero, home
// callback banner, "Get a Quote" popup, service page hero, sidebar
// consult card, and the Contact Us page) posts to the same AJAX
// endpoint. Which inbox each one lands in is configured from a single
// admin page: Settings → Lead Forms.

// Registry of every lead form on the site: key => label shown in admin + emails.
function oc_ca_lead_form_registry() {
    return array(
        'hero_quote'         => 'Home Page — Hero "Book Free Consultation"',
        'callback'           => 'Home Page — "Request a Callback" Banner',
        'modal_quote'        => 'Site-wide — "Get a Quote" Popup',
        'service_hero_quote' => 'Service Pages — Hero "Book Free Consultation"',
        'sidebar_consult'    => 'Sidebar — "Get Free Consultation"',
        'contact_page'       => 'Contact Us Page',
    );
}

function oc_ca_lead_form_default_email() {
    return get_theme_mod( 'footer_email', get_bloginfo( 'admin_email' ) );
}

// ---- AJAX handler: receives the form POST and emails it via wp_mail() ----
// (Delivery goes through whatever SMTP plugin is active — this only builds
// the message and calls wp_mail(), it never talks to a mail server directly.)
function oc_ca_handle_lead_submission() {
    check_ajax_referer( 'oc_ca_lead_form', 'nonce' );

    $registry = oc_ca_lead_form_registry();
    $form_key = isset( $_POST['form_key'] ) ? sanitize_key( wp_unslash( $_POST['form_key'] ) ) : '';

    if ( ! isset( $registry[ $form_key ] ) ) {
        wp_send_json_error( array( 'message' => 'Invalid form.' ) );
    }

    $name    = isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )       : '';
    $phone   = isset( $_POST['phone'] )   ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )      : '';
    $email   = isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )            : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
    $page_url = isset( $_POST['page_url'] ) ? esc_url_raw( wp_unslash( $_POST['page_url'] ) )          : '';

    if ( '' === $name || ( '' === $phone && '' === $email ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in your name and at least a phone number or email.' ) );
    }

    $routing = get_option( 'oc_ca_lead_form_routing', array() );
    $to      = ! empty( $routing[ $form_key ] ) ? $routing[ $form_key ] : oc_ca_lead_form_default_email();

    $subject = 'New Website Lead — ' . $registry[ $form_key ];

    $body   = "You have a new lead from the website.\n\n";
    $body  .= 'Form: ' . $registry[ $form_key ] . "\n";
    $body  .= 'Name: ' . $name . "\n";
    if ( $phone ) {
        $body .= 'Phone: ' . $phone . "\n";
    }
    if ( $email ) {
        $body .= 'Email: ' . $email . "\n";
    }
    if ( $message ) {
        $body .= "Message:\n" . $message . "\n";
    }
    if ( $page_url ) {
        $body .= 'Submitted from: ' . $page_url . "\n";
    }
    $body .= 'Submitted: ' . current_time( 'mysql' ) . "\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $email ) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
    }

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Thank you! Our team will contact you shortly.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Something went wrong sending your request. Please call or WhatsApp us instead.' ) );
    }
}
add_action( 'wp_ajax_oc_ca_submit_lead', 'oc_ca_handle_lead_submission' );
add_action( 'wp_ajax_nopriv_oc_ca_submit_lead', 'oc_ca_handle_lead_submission' );

// ---- Pass the AJAX URL + nonce to theme.js ----
function oc_ca_localize_lead_form_script() {
    wp_localize_script( 'oc-ca-theme-js', 'ocCaLeadForms', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'oc_ca_lead_form' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'oc_ca_localize_lead_form_script', 20 );

// ---- Admin page: Settings → Lead Forms ----
function oc_ca_register_lead_forms_admin_page() {
    add_options_page(
        __( 'Lead Forms', 'oc-ca-theme' ),
        __( 'Lead Forms', 'oc-ca-theme' ),
        'manage_options',
        'oc-ca-lead-forms',
        'oc_ca_render_lead_forms_admin_page'
    );
}
add_action( 'admin_menu', 'oc_ca_register_lead_forms_admin_page' );

function oc_ca_render_lead_forms_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $registry = oc_ca_lead_form_registry();
    $saved    = false;

    if ( isset( $_POST['oc_ca_lead_forms_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oc_ca_lead_forms_nonce'] ) ), 'oc_ca_lead_forms_save' ) ) {
        $routing = array();
        foreach ( $registry as $key => $label ) {
            $field = 'lead_email_' . $key;
            if ( isset( $_POST[ $field ] ) ) {
                $val = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
                if ( '' !== $val ) {
                    $routing[ $key ] = $val;
                }
            }
        }
        update_option( 'oc_ca_lead_form_routing', $routing );
        $saved = true;
    }

    $routing = get_option( 'oc_ca_lead_form_routing', array() );
    $default_email = oc_ca_lead_form_default_email();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Lead Forms', 'oc-ca-theme' ); ?></h1>
        <p><?php esc_html_e( 'Every enquiry form on the site (home page, service pages, popups, sidebar, and Contact Us) sends here. Choose which inbox each one should email — leave a field blank to fall back to the default address.', 'oc-ca-theme' ); ?></p>

        <?php if ( $saved ) : ?>
            <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Lead form routing saved.', 'oc-ca-theme' ); ?></p></div>
        <?php endif; ?>

        <p>
            <strong><?php esc_html_e( 'Default address (used for any form left blank below):', 'oc-ca-theme' ); ?></strong>
            <code><?php echo esc_html( $default_email ); ?></code>
            — <?php esc_html_e( 'set under Appearance → Customize → Footer — Company Info → Email.', 'oc-ca-theme' ); ?>
        </p>

        <form method="post">
            <?php wp_nonce_field( 'oc_ca_lead_forms_save', 'oc_ca_lead_forms_nonce' ); ?>
            <table class="widefat striped" style="max-width:900px;">
                <thead>
                    <tr>
                        <th style="width:45%;"><?php esc_html_e( 'Form', 'oc-ca-theme' ); ?></th>
                        <th><?php esc_html_e( 'Send leads to (email address)', 'oc-ca-theme' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $registry as $key => $label ) :
                        $current = isset( $routing[ $key ] ) ? $routing[ $key ] : '';
                    ?>
                    <tr>
                        <td><?php echo esc_html( $label ); ?></td>
                        <td>
                            <input type="text" name="lead_email_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $default_email ); ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="description"><?php esc_html_e( 'Multiple recipients: separate addresses with a comma.', 'oc-ca-theme' ); ?></p>
            <?php submit_button( __( 'Save Routing', 'oc-ca-theme' ) ); ?>
        </form>
    </div>
    <?php
}
