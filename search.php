<?php
/**
 * OC CA Theme - Search Results Template
 *
 * @package OC_CA_Theme
 */

get_header();
?>

<section class="subpage-hero">
    <div class="container">
        <?php oc_ca_breadcrumbs(); ?>
        <div class="subpage-hero-title">
            <h1>Search Results for: <em><?php echo get_search_query(); ?></em></h1>
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<section class="subpage-main">
    <div class="container">
        <?php if ( have_posts() ) : ?>
        <div class="blog-posts-grid">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-card' ); ?>>
                <a href="<?php the_permalink(); ?>" class="blog-card-image-link">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'blog-card-image' ) ); ?>
                    <?php else : ?>
                        <div class="blog-card-image-placeholder"><i class="fa-solid fa-search"></i></div>
                    <?php endif; ?>
                </a>
                <div class="blog-card-body">
                    <div class="blog-card-meta">
                        <span><i class="fa-solid fa-calendar"></i> <?php the_date(); ?></span>
                    </div>
                    <h2 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
        <div class="blog-pagination">
            <?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
        </div>
        <?php else : ?>
        <div class="no-posts" style="text-align:center; padding: 80px 20px;">
            <i class="fa-solid fa-magnifying-glass" style="font-size:4rem; color:var(--neutral-light); margin-bottom:20px; display:block;"></i>
            <h2>No Results Found</h2>
            <p>Sorry, nothing matched your search. Please try again with different keywords.</p>
            <?php get_search_form(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
