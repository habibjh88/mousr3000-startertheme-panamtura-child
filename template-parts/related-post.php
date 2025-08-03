<?php
$post_id      = get_the_id();
$current_post = [ $post_id ];
$query_type   = 'category';

$args = [
	'post_type'              => 'post',
	'post__not_in'           => $current_post,
	'posts_per_page'         => 3,
	'no_found_rows'          => true,
	'post_status'            => 'publish',
	'ignore_sticky_posts'    => true,
	'update_post_term_cache' => false,
];

$args['orderby'] = '';
$args['order']   = '';

if ( $query_type == 'author' ) {
	$args['author'] = get_the_author_meta( 'ID' );
} elseif ( $query_type == 'tag' ) {
	$tags_ids  = [];
	$post_tags = get_the_terms( $post_id, 'post_tag' );

	if ( ! empty( $post_tags ) ) {
		foreach ( $post_tags as $individual_tag ) {
			$tags_ids[] = $individual_tag->term_id;
		}

		$args['tag__in'] = $tags_ids;
	}
} else {
	$category_ids = [];
	$categories   = get_the_category( $post_id );

	foreach ( $categories as $individual_category ) {
		$category_ids[] = $individual_category->term_id;
	}

	$args['category__in'] = $category_ids;
}

// Get the posts
$related_query = new \WP_Query( $args );
if ( $related_query->have_posts() ) { ?>
    <div class="is-layout-constrained">

        <div class="related-post-container">
            <h2 class="related-title">Verwandte Beiträge</h2>
            <div class="msr-blog-wrapper">
                <div class="msr-blog-lists u-list-unstyled u-links-unstyled">
					<?php while ( $related_query->have_posts() ) {
						$related_query->the_post(); ?>
                        <div class="blog-list__card">
                            <div class="blog-list__card__image">
                                <a href="<?php echo get_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'thumb', array(
											'loading' => 'lazy',
											'class'   => 'u-fit',
										) );
									}
									?>
                                </a>
                            </div>
                            <div class="blog-list__card__content p-1 u-v-space-0_5">
                                <div class="msr-post-categories">
									<?php the_category(); ?>
                                </div>
                                <h2 class="h3 u-color-secondary post-title">
                                    <a href="<?php echo get_permalink(); ?>">
										<?php echo get_the_title(); ?>
                                    </a>
                                </h2>
                                <div class="blog-excerpt">
									<?php the_excerpt(); ?>
                                </div>
                                <a href="<?php echo get_permalink(); ?>" class="read-more-btn">
                                    <span><?php echo esc_html__( 'Weiterlesen ', 'msr-child' ); ?></span>
                                    <span>&#8594;</span>
                                </a>
                            </div>
                        </div>
					<?php } ?>
                </div> <!-- .msr-blog-lists -->
            </div> <!-- .msr-blog-wrapper -->
        </div> <!-- .container -->

    </div> <!-- .is-layout-constrained -->
<?php }
wp_reset_postdata();