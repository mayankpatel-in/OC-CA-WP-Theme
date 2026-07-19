<?php
/**
 * OC CA Theme - Homepage (Front Page) Template
 *
 * Used automatically for the site front page (whether "Latest posts"
 * or a static page is selected in Settings → Reading / Customizer →
 * Homepage Settings). All sections live in
 * template-parts/home-content.php, shared with the "Home Page"
 * page template so a real Page can hold the homepage SEO settings.
 *
 * @package OC_CA_Theme
 */

get_header();

get_template_part( 'template-parts/home-content' );

get_footer();
