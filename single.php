<?php
/**
 * OC CA Theme - Single Blog Post Template
 *
 * Renders an individual blog post with: subpage hero banner,
 * post breadcrumbs, post metadata, two-column layout (article +
 * sticky sidebar), featured image, post content, and prev/next
 * post navigation.
 *
 * @package OC_CA_Theme
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- SUBPAGE HERO BANNER -->
<section class="subpage-hero blog-hero">
    <div class="container">
        <?php oc_ca_breadcrumbs(); ?>
        <div class="subpage-hero-title">
            <h1><?php the_title(); ?></h1>
            <?php oc_ca_post_meta(); ?>
        </div>
    </div>
</section>

<!-- MAIN TWO-COLUMN LAYOUT -->
<main class="subpage-main">
    <div class="container main-grid">

        <!-- LEFT COLUMN: ARTICLE BODY -->
        <article class="content-column" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if ( has_post_thumbnail() ) : ?>
            <div class="blog-featured-image-wrapper">
                <?php the_post_thumbnail( 'large', array( 'class' => 'blog-featured-image' ) ); ?>
            </div>
            <?php endif; ?>

            <div class="blog-content">
                <?php
                the_content(
                    sprintf(
                        wp_kses(
                            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'oc-ca-theme' ),
                            array( 'span' => array( 'class' => array() ) )
                        ),
                        get_the_title()
                    )
                );

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oc-ca-theme' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div><!-- .blog-content -->

            <!-- Post Tags -->
            <?php
            $tags = get_the_tags();
            if ( $tags ) :
            ?>
            <div class="post-tags" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--neutral-light);">
                <strong><i class="fa-solid fa-tags"></i> Tags:</strong>
                <?php the_tags( '', ', ', '' ); ?>
            </div>
            <?php endif; ?>

            <!-- Post Navigation -->
            <div class="post-navigation" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--neutral-light); display: flex; gap: 20px; justify-content: space-between; flex-wrap: wrap;">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                if ( $prev_post ) :
                ?>
                <div class="nav-prev">
                    <span class="nav-label" style="font-size:0.8rem; color:var(--neutral-medium); text-transform:uppercase; letter-spacing:1px;">Previous Post</span>
                    <a href="<?php echo get_permalink( $prev_post ); ?>" style="font-weight:600; color:var(--primary); display:block; margin-top:4px;">
                        <i class="fa-solid fa-arrow-left"></i> <?php echo get_the_title( $prev_post ); ?>
                    </a>
                </div>
                <?php endif; ?>
                <?php if ( $next_post ) : ?>
                <div class="nav-next" style="text-align:right; margin-left:auto;">
                    <span class="nav-label" style="font-size:0.8rem; color:var(--neutral-medium); text-transform:uppercase; letter-spacing:1px;">Next Post</span>
                    <a href="<?php echo get_permalink( $next_post ); ?>" style="font-weight:600; color:var(--primary); display:block; margin-top:4px;">
                        <?php echo get_the_title( $next_post ); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>



        </article><!-- article.content-column -->

        <!-- RIGHT COLUMN: STICKY SIDEBAR -->
        <aside>
            <?php get_template_part( 'template-parts/sidebar-cards' ); ?>
        </aside>

    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
