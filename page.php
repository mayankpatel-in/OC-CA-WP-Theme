<?php
/**
 * OC CA Theme - Standard Page Template
 *
 * Used for all static WordPress pages (About, Contact, etc.).
 * Renders a subpage hero banner, two-column layout with content
 * on the left and a sticky consultation sidebar on the right.
 *
 * @package OC_CA_Theme
 */

get_header();
?>

<!-- SUBPAGE HERO BANNER -->
<section class="subpage-hero">
    <div class="container">
        <?php oc_ca_breadcrumbs(); ?>
        <div class="subpage-hero-title">
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<!-- MAIN TWO-COLUMN LAYOUT -->
<main class="subpage-main">
    <div class="container main-grid">

        <!-- LEFT COLUMN: PAGE CONTENT -->
        <article class="content-column">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <div class="blog-content page-content">
                    <?php
                    if ( has_post_thumbnail() ) {
                        echo '<div class="blog-featured-image-wrapper">';
                        the_post_thumbnail( 'large', array( 'class' => 'blog-featured-image' ) );
                        echo '</div>';
                    }
                    ?>
                    <?php the_content(); ?>
                    <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oc-ca-theme' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
                <?php
            endwhile;
            ?>
        </article>

        <!-- RIGHT COLUMN: STICKY SIDEBAR -->
        <aside>
            <?php get_template_part( 'template-parts/sidebar-cards' ); ?>
        </aside>

    </div>
</main>

<?php get_footer(); ?>
