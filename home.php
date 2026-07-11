<?php
/**
 * OC CA Theme - Blog Index Template (Posts Page)
 *
 * Used when WordPress blog index is set to a dedicated posts page.
 * Renders a blog hero, a grid of post cards, and pagination.
 *
 * @package OC_CA_Theme
 */

get_header();
?>

<!-- BLOG HERO BANNER -->
<section class="subpage-hero">
    <div class="container">
        <?php oc_ca_breadcrumbs(); ?>
        <div class="subpage-hero-title">
            <h1>Latest Insights &amp; Guides</h1>
            <p class="lead">Stay updated on taxation, company registration, GST compliance, and CA best practices.</p>
        </div>
    </div>
</section>

<!-- BLOG POSTS GRID -->
<section class="subpage-main">
    <div class="container">

        <?php if ( have_posts() ) : ?>

        <div class="blog-posts-grid">
            <?php
            while ( have_posts() ) :
                the_post();
                $cats = get_the_category();
                $cat_name = $cats ? $cats[0]->name : 'General';
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-card' ); ?>>

                    <!-- Featured Image -->
                    <a href="<?php the_permalink(); ?>" class="blog-card-image-link">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'blog-card-image' ) ); ?>
                        <?php else : ?>
                            <div class="blog-card-image-placeholder">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        <?php endif; ?>
                        <span class="blog-card-category"><?php echo esc_html( $cat_name ); ?></span>
                    </a>

                    <!-- Card Body -->
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span><i class="fa-solid fa-calendar"></i> <?php the_date(); ?></span>
                            <span><i class="fa-solid fa-user"></i> <?php the_author(); ?></span>
                        </div>
                        <h2 class="blog-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                </article>
            <?php endwhile; ?>
        </div><!-- .blog-posts-grid -->

        <!-- Pagination -->
        <div class="blog-pagination">
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '<i class="fa-solid fa-arrow-left"></i> Previous',
                'next_text' => 'Next <i class="fa-solid fa-arrow-right"></i>',
            ) );
            ?>
        </div>

        <?php else : ?>

        <div class="no-posts" style="text-align:center; padding: 80px 20px;">
            <i class="fa-solid fa-folder-open" style="font-size:4rem; color:var(--neutral-light); margin-bottom:20px; display:block;"></i>
            <h2>No Posts Found</h2>
            <p>It looks like there are no posts here yet. Check back soon!</p>
        </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
