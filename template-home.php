<?php
/**
 * Template Name: Home Page
 *
 * Assign this template to a Page (e.g. "Home"), fill in its SEO
 * details with Yoast, then set it as the homepage under
 * Customizer → Homepage Settings (or Settings → Reading →
 * "A static page"). Renders the exact same sections as the
 * front page via template-parts/home-content.php.
 *
 * @package OC_CA_Theme
 */

get_header();

get_template_part( 'template-parts/home-content' );

get_footer();
