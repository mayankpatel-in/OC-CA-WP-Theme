<?php
/**
 * Template Name: Service Page
 *
 * Full-featured service landing page: hero with price tag + free bundle + quote form,
 * two-column main layout with page content on the left and a sticky CTA sidebar on the right.
 *
 * Custom Fields (set via WP editor → Custom Fields panel):
 *   _service_price       — e.g. "@ Rs. 990 All Inclusive"
 *   _service_subtitle    — e.g. "100% Online Process & CA, CS Services At One Place"
 *   _service_free_title  — heading above the free bundle grid
 *   _service_free_items  — JSON: [{"icon":"fa-address-card","label":"Shop Act"},…]
 *
 * @package OC_CA_Theme
 */

get_header();

$pid      = get_the_ID();
$price    = get_post_meta( $pid, '_service_price',      true );
$subtitle = get_post_meta( $pid, '_service_subtitle',   true );
$free_ttl = get_post_meta( $pid, '_service_free_title', true ) ?: 'Also Get Absolutely Free';
$free_raw = get_post_meta( $pid, '_service_free_items', true );
$free_items = $free_raw ? json_decode( $free_raw, true ) : array(
    array( 'icon' => 'fa-address-card',       'label' => 'Shop Act' ),
    array( 'icon' => 'fa-file-invoice-dollar', 'label' => 'Invoice Format' ),
    array( 'icon' => 'fa-user-tie',           'label' => 'Consulting' ),
    array( 'icon' => 'fa-cloud',              'label' => 'Accounting Software' ),
);

$phone     = get_theme_mod( 'footer_phone',     '+91 80555 66789' );
$wa_num    = get_theme_mod( 'footer_wa_number', '918055566789' );
$phone_raw = preg_replace( '/\D/', '', $phone );
$wa_raw    = preg_replace( '/\D/', '', $wa_num );

while ( have_posts() ) :
    the_post();
?>

<!-- =====================================================
     SUBPAGE HERO
     ===================================================== -->
<section class="subpage-hero">
    <div class="container hero-subpage-grid">

        <!-- Left: Text + Price + Free Bundle -->
        <div class="subpage-hero-text">
            <?php oc_ca_breadcrumbs(); ?>
            <h1><?php the_title(); ?></h1>

            <?php if ( $price ) : ?>
                <div class="price-tag"><?php echo esc_html( $price ); ?></div>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
                <p class="subpage-hero-sub"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( $price || $subtitle ) : ?>
                <div class="hero-divider"></div>
            <?php endif; ?>

            <?php if ( ! empty( $free_items ) ) : ?>
            <div class="free-bundle-container">
                <span class="free-badge">FREE</span>
                <h3 class="free-title"><?php echo esc_html( $free_ttl ); ?></h3>
                <div class="free-items-grid">
                    <?php foreach ( $free_items as $item ) :
                        $icon  = isset( $item['icon'] )  ? sanitize_html_class( $item['icon'] )  : 'fa-star';
                        $label = isset( $item['label'] ) ? esc_html( $item['label'] ) : '';
                    ?>
                    <div class="free-item">
                        <div class="free-icon"><i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i></div>
                        <span class="free-label"><?php echo $label; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: Quick Quote Form -->
        <div class="subpage-hero-form">
            <div class="form-wrapper">
                <h3>Get Quote Instantly In A Minute</h3>
                <form id="serviceHeroQuoteForm" class="interactive-form">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Contact Number" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <button type="submit" class="btn btn-accent btn-full btn-get-started">GET STARTED</button>
                </form>
                <div class="form-success" id="serviceHeroSuccess" style="display:none; text-align:center; padding:20px 0;">
                    <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--success);margin-bottom:0.7rem;display:block;"></i>
                    <h4>Thank You!</h4>
                    <p>Our expert team will contact you within 15 minutes.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- =====================================================
     MAIN TWO-COLUMN LAYOUT
     ===================================================== -->
<main class="subpage-main">
    <div class="container main-grid">

        <!-- LEFT COLUMN: Page Content (Gutenberg blocks / Classic Editor) -->
        <article class="content-column">
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>

        <!-- RIGHT COLUMN: Sticky Sidebar -->
        <aside class="sidebar-column">
            <div class="sticky-sidebar-container">

                <!-- CTA Card: Call + WhatsApp -->
                <div class="sidebar-card cta-side-card">
                    <h4>Get Free Consultation</h4>
                    <p>Speak directly with our senior CA partner to clear your compliance doubts and setup your business.</p>
                    <a href="tel:<?php echo esc_attr( $phone_raw ); ?>" class="btn btn-primary btn-full">
                        <i class="fa-solid fa-phone"></i> Call <?php echo esc_html( $phone ); ?>
                    </a>
                    <a href="https://wa.me/<?php echo esc_attr( $wa_raw ); ?>" class="btn btn-outline btn-full wa-btn" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
                    </a>
                </div>

                <!-- Why ANBCA Trust Card -->
                <div class="sidebar-card why-side-card">
                    <h4><i class="fa-solid fa-shield-halved" style="color:var(--primary);margin-right:8px;"></i> Why A N Bhutada &amp; Co?</h4>
                    <ul>
                        <li><i class="fa-solid fa-shield-halved"></i> 100% Confidentiality</li>
                        <li><i class="fa-solid fa-clock"></i> Timely Filing Guarantee</li>
                        <li><i class="fa-solid fa-award"></i> Senior CA Advisor Support</li>
                        <li><i class="fa-solid fa-tags"></i> Transparent Pricing</li>
                        <li><i class="fa-solid fa-users"></i> 1000+ Satisfied Clients</li>
                        <li><i class="fa-solid fa-star"></i> 15+ Years of Expertise</li>
                    </ul>
                </div>

            </div>
        </aside>

    </div>
</main>

<?php
endwhile;

get_footer();
