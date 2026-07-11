<?php
/**
 * OC CA Theme - Footer Template
 *
 * Structure:
 *  FOOTER       — 4-column grid (company info, quick links, recent posts, newsletter)
 *  FOOTER BAR   — bottom strip with copyright + credit text
 *
 * Col 1 values come from Appearance → Customize → Footer — Company Info.
 * Cols 2, 3, 4 fall back to dynamic content when no widget is assigned
 * (Appearance → Widgets → Footer Column 2 / 3 / 4).
 *
 * @package OC_CA_Theme
 */

// Customizer values — Footer Col 1
$footer_desc    = get_theme_mod( 'footer_company_desc', 'A trusted and versatile Chartered Accountant firm in Pune, India. Committed to rendering top professional services with independence, integrity, and efficiency.' );
$footer_address = get_theme_mod( 'footer_address', 'G 20 Ashoka Mall, Bund Garden Road, Pune - 411001' );
$footer_phone   = get_theme_mod( 'footer_phone', '+91 80555 66789' );
$footer_email   = get_theme_mod( 'footer_email', 'office@anbca.com' );
$footer_fb      = get_theme_mod( 'footer_fb_url', '#' );
$footer_tw      = get_theme_mod( 'footer_tw_url', '#' );
$footer_li      = get_theme_mod( 'footer_li_url', '#' );
$footer_wa      = get_theme_mod( 'footer_wa_number', '918055566789' );

// Customizer values — Footer Bar
$footer_credit  = get_theme_mod( 'footer_credit_text', 'Designed with ❤️ in India' );
?>

<!-- =====================================================
     FOOTER
     ===================================================== -->
<footer class="main-footer">
    <div class="container footer-grid">

        <!-- Footer Col 1: Company Info (Customizer) -->
        <div class="footer-col col-info">
            <?php
            $footer_logo_id = absint( get_theme_mod( 'footer_logo', 0 ) );

            if ( $footer_logo_id ) {
                // Dedicated footer logo uploaded via Customize → Footer Logo
                $logo_url = wp_get_attachment_image_url( $footer_logo_id, 'full' );
                $logo_alt = get_post_meta( $footer_logo_id, '_wp_attachment_image_alt', true );
                if ( ! $logo_alt ) {
                    $logo_alt = get_bloginfo( 'name' );
                }
                echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_alt ) . '" class="footer-logo">';
            } elseif ( has_custom_logo() ) {
                // Fall back to the Site Identity logo
                the_custom_logo();
            } else {
                // Last resort: theme default image
                echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/img/logo-light.png" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="footer-logo" onerror="this.style.display=\'none\'">';
            }
            ?>
            <?php if ( $footer_desc ) : ?>
                <p><?php echo esc_html( $footer_desc ); ?></p>
            <?php endif; ?>
            <div class="footer-contact">
                <?php if ( $footer_address ) : ?>
                    <p><i class="fa-solid fa-location-dot"></i> <?php echo esc_html( $footer_address ); ?></p>
                <?php endif; ?>
                <?php if ( $footer_phone ) : ?>
                    <p><i class="fa-solid fa-phone"></i>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $footer_phone ) ); ?>">
                            <?php echo esc_html( $footer_phone ); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <?php if ( $footer_email ) : ?>
                    <p><i class="fa-solid fa-envelope"></i>
                        <a href="mailto:<?php echo esc_attr( $footer_email ); ?>">
                            <?php echo esc_html( $footer_email ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="footer-socials">
                <?php if ( $footer_fb && $footer_fb !== '#' ) : ?>
                    <a href="<?php echo esc_url( $footer_fb ); ?>" aria-label="Facebook" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if ( $footer_tw && $footer_tw !== '#' ) : ?>
                    <a href="<?php echo esc_url( $footer_tw ); ?>" aria-label="Twitter" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-twitter"></i></a>
                <?php endif; ?>
                <?php if ( $footer_li && $footer_li !== '#' ) : ?>
                    <a href="<?php echo esc_url( $footer_li ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin-in"></i></a>
                <?php endif; ?>
                <?php if ( $footer_wa ) : ?>
                    <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', $footer_wa ) ); ?>" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer Col 2: Quick Links (Widget → fallback: footer-links nav menu) -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-col-2' ) ) : ?>
                <?php dynamic_sidebar( 'footer-col-2' ); ?>
            <?php else : ?>
                <h4>Quick Links</h4>
                <?php
                if ( has_nav_menu( 'footer-links' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-links',
                        'menu_class'     => 'footer-links',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                } else {
                    ?>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> Online GST Registration</a></li>
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> Private Limited Company</a></li>
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> Proprietorship Registration</a></li>
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> GST Return Filing</a></li>
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> Tax Audit Services</a></li>
                        <li><a href="#"><i class="fa-solid fa-angle-right"></i> Income Tax Return</a></li>
                    </ul>
                    <?php
                }
                ?>
            <?php endif; ?>
        </div>

        <!-- Footer Col 3: Recent Posts (Widget → fallback: wp_get_recent_posts) -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-col-3' ) ) : ?>
                <?php dynamic_sidebar( 'footer-col-3' ); ?>
            <?php else : ?>
                <h4>Recent Posts</h4>
                <ul class="footer-posts">
                    <?php
                    $recent_posts = wp_get_recent_posts( array(
                        'numberposts' => 3,
                        'post_status' => 'publish',
                    ) );
                    if ( $recent_posts ) {
                        foreach ( $recent_posts as $post ) {
                            printf(
                                '<li><a href="%s">%s</a><span class="post-date">%s</span></li>',
                                esc_url( get_permalink( $post['ID'] ) ),
                                esc_html( $post['post_title'] ),
                                esc_html( get_the_date( '', $post['ID'] ) )
                            );
                        }
                    } else {
                        ?>
                        <li>
                            <a href="#">Depreciation Rates for FY 2023-24 as per Income Tax Act</a>
                            <span class="post-date">April 7, 2024</span>
                        </li>
                        <li>
                            <a href="#">Comparing Private Limited Company and LLP</a>
                            <span class="post-date">April 7, 2024</span>
                        </li>
                        <li>
                            <a href="#">Establishing a Current Account for a Private Limited Company</a>
                            <span class="post-date">April 7, 2024</span>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Footer Col 4: Newsletter (Widget → fallback: newsletter form) -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-col-4' ) ) : ?>
                <?php dynamic_sidebar( 'footer-col-4' ); ?>
            <?php else : ?>
                <h4>Newsletter</h4>
                <p>Subscribe to our newsletter to receive the latest updates on tax compliance and financial laws.</p>
                <form id="newsletterForm" class="newsletter-form">
                    <input type="email" placeholder="Your Email Address" required>
                    <button type="submit" class="btn btn-accent btn-sm">Subscribe <i class="fa-solid fa-paper-plane"></i></button>
                </form>
                <div class="newsletter-success" id="newsletterSuccess" style="display:none;">
                    <p><i class="fa-solid fa-circle-check"></i> Subscribed successfully!</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</footer>

<!-- =====================================================
     FOOTER BAR
     ===================================================== -->
<div class="footer-bottom">
    <div class="container footer-bottom-content">
        <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
        <?php if ( $footer_credit ) : ?>
            <p><?php echo esc_html( $footer_credit ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
// Floating Contact Buttons
get_template_part( 'template-parts/floating-buttons' );

// Quote Modal
get_template_part( 'template-parts/modal' );
?>

<?php wp_footer(); ?>
</body>
</html>
