<?php
/**
 * OC CA Theme - Related Posts Slider
 *
 * Shows up to 4 posts from the current post's primary category
 * as a horizontal slider at the end of single post content.
 *
 * @package OC_CA_Theme
 */

$oc_ca_related_cats = get_the_category();

if ( empty( $oc_ca_related_cats ) ) {
    return;
}

$oc_ca_related_query = new WP_Query( array(
    'category__in'        => array( $oc_ca_related_cats[0]->term_id ),
    'post__not_in'        => array( get_the_ID() ),
    'posts_per_page'      => 4,
    'ignore_sticky_posts'  => true,
    'no_found_rows'       => true,
    'orderby'             => 'date',
    'order'               => 'DESC',
) );

if ( ! $oc_ca_related_query->have_posts() ) {
    wp_reset_postdata();
    return;
}
?>
<div class="related-posts-section">
    <h3 class="related-posts-heading"><?php esc_html_e( 'You Might Also Like', 'oc-ca-theme' ); ?></h3>
    <div class="related-posts-wrapper">
        <button class="carousel-nav prev related-posts-prev" aria-label="<?php esc_attr_e( 'Previous related post', 'oc-ca-theme' ); ?>">
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <div class="related-posts-track-container">
            <div class="related-posts-track">
                <?php
                while ( $oc_ca_related_query->have_posts() ) :
                    $oc_ca_related_query->the_post();
                    $rp_cats     = get_the_category();
                    $rp_cat_name = $rp_cats ? $rp_cats[0]->name : 'General';
                    ?>
                    <article id="related-post-<?php the_ID(); ?>" class="blog-post-card related-post-card">
                        <a href="<?php the_permalink(); ?>" class="blog-card-image-link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'blog-card-image' ) ); ?>
                            <?php else : ?>
                                <div class="blog-card-image-placeholder">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                            <?php endif; ?>
                            <span class="blog-card-category"><?php echo esc_html( $rp_cat_name ); ?></span>
                        </a>
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <span><i class="fa-solid fa-calendar"></i> <?php the_date(); ?></span>
                            </div>
                            <h3 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e( 'Read More', 'oc-ca-theme' ); ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>

        <button class="carousel-nav next related-posts-next" aria-label="<?php esc_attr_e( 'Next related post', 'oc-ca-theme' ); ?>">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
</div>
<?php
wp_reset_postdata();
