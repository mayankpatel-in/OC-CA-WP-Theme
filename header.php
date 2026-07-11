<?php
/**
 * OC CA Theme - Header Template
 *
 * Renders the top contact bar, sticky main navbar with logo,
 * and mobile hamburger navigation.
 *
 * @package OC_CA_Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP CONTACT BAR -->
<div class="top-bar">
    <div class="container top-bar-content">
        <div class="contact-info">
            <span><i class="fa-solid fa-phone"></i> <a href="tel:+918055566789">+91 80555 66789</a></span>
            <span><i class="fa-solid fa-envelope"></i> <a href="mailto:office@anbca.com">office@anbca.com</a></span>
            <span><i class="fa-solid fa-clock"></i> Mon - Sat: 10 AM - 8 PM</span>
        </div>
        <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="https://wa.me/918055566789" class="wa-top" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i> Chat Now</a>
        </div>
    </div>
</div>

<!-- STICKY MAIN NAVBAR -->
<header class="main-header" id="mainHeader">
    <div class="container nav-container">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" id="logoLink" rel="home">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-light.png" alt="<?php bloginfo( 'name' ); ?>" class="logo-light" onerror="this.style.display='none'">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-dark.png" alt="<?php bloginfo( 'name' ); ?>" class="logo-dark" onerror="this.style.display='none'">
                <span class="logo-text" style="font-family: var(--font-display); font-weight: 800; font-size: 1.2rem; color: var(--primary);">
                    <?php bloginfo( 'name' ); ?>
                </span>
                <?php
            }
            ?>
        </a>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle Navigation" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Primary Navigation -->
        <nav class="nav-menu" id="navMenu" role="navigation" aria-label="Primary Navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav-list',
                'container'      => false,
                'walker'         => new OC_CA_Mega_Menu_Walker(),
                'fallback_cb'    => false,
            ) );
            ?>
            <div class="nav-cta">
                <button class="btn btn-primary btn-quote" id="openQuoteModalBtn">Get a Quote</button>
            </div>
        </nav>

    </div>
</header>
