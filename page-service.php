<?php
/**
 * Template Name: Service Page
 *
 * Mirrors the structure of proprietorship-registration.html:
 *  — Subpage hero: breadcrumb, H1, price tag, subtitle, free bundle grid, quote form
 *  — Two-column main: the_content() on left + sticky CTA sidebar on right
 *
 * Hero fields are edited from the "Service Hero Settings" panel in the Page editor sidebar.
 * Main article content (intro, features, tables, FAQs, etc.) is written in the editor body.
 *
 * @package OC_CA_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();

    $pid = get_the_ID();

    // ── Hero meta fields ──────────────────────────────────────────────
    $price    = get_post_meta( $pid, '_service_price',      true );
    $subtitle = get_post_meta( $pid, '_service_subtitle',   true );
    $free_ttl = get_post_meta( $pid, '_service_free_title', true ) ?: 'Also Get Absolutely Free';

    $free_items = array();
    $default_icons  = array( 'fa-address-card', 'fa-file-invoice-dollar', 'fa-user-tie', 'fa-cloud' );
    $default_labels = array( 'Shop Act', 'Invoice Format', 'Consulting', 'Accounting Software' );
    for ( $i = 1; $i <= 4; $i++ ) {
        $icon  = get_post_meta( $pid, "_service_free_{$i}_icon",  true ) ?: $default_icons[ $i - 1 ];
        $label = get_post_meta( $pid, "_service_free_{$i}_label", true ) ?: $default_labels[ $i - 1 ];
        $free_items[] = array( 'icon' => $icon, 'label' => $label );
    }

    // ── Contact info (from Customizer, same as footer) ────────────────
    $phone     = get_theme_mod( 'footer_phone',     '+91 80555 66789' );
    $wa_num    = get_theme_mod( 'footer_wa_number', '918055566789' );
    $phone_raw = preg_replace( '/\D/', '', $phone );
    $wa_raw    = preg_replace( '/\D/', '', $wa_num );
?>

<!-- =====================================================
     SUBPAGE HERO
     ===================================================== -->
<section class="subpage-hero">
    <div class="container hero-subpage-grid">

        <!-- Left: breadcrumb + H1 + price + subtitle + free bundle -->
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

            <div class="free-bundle-container">
                <span class="free-badge">FREE</span>
                <h3 class="free-title"><?php echo esc_html( $free_ttl ); ?></h3>
                <div class="free-items-grid">
                    <?php foreach ( $free_items as $item ) :
                        $icon  = sanitize_html_class( $item['icon'] );
                        $label = esc_html( $item['label'] );
                    ?>
                    <div class="free-item">
                        <div class="free-icon"><i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i></div>
                        <span class="free-label"><?php echo $label; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Right: instant quote form -->
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

        <!-- LEFT: article content from the WordPress page editor -->
        <article class="content-column">
            <div class="blog-content page-content">
                <?php the_content(); ?>
                <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oc-ca-theme' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </article>

        <!-- RIGHT: sticky sidebar -->
        <aside class="sidebar-column">
            <div class="sticky-sidebar-container">

                <!-- CTA: call + WhatsApp -->
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

                <!-- Why ANBCA trust card -->
                <div class="sidebar-card why-side-card">
                    <h4>Why A N Bhutada &amp; Co?</h4>
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
