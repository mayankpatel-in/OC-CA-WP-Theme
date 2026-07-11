<?php
/**
 * OC CA Theme - Fallback Index Template
 *
 * WordPress requires index.php as the ultimate fallback.
 * Redirects to the most relevant template.
 *
 * @package OC_CA_Theme
 */

get_header();
?>

<section class="subpage-main" style="padding: 60px 0;">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div class="blog-posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-card' ); ?>>
                    <div class="blog-card-body">
                        <h2 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="blog-card-meta">
                            <span><i class="fa-solid fa-calendar"></i> <?php the_date(); ?></span>
                        </div>
                        <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Read More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p style="text-align:center; padding: 60px;">Nothing found here. <a href="<?php echo home_url(); ?>">Go back home</a>.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
