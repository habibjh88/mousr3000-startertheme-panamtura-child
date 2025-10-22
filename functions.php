<?php
require_once get_stylesheet_directory() . '/inc/post-meta.php';
// Enqueue parent theme styles
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'mousr3000-parent-style', get_template_directory_uri() . '/style.css' );
} );

// Load parent theme style in Gutenberg editor
add_action('enqueue_block_editor_assets', function () {
	wp_enqueue_style(
		'mousr3000-parent-style-editor',
		get_stylesheet_directory_uri() . '/style.css'
	);
});
add_action( 'init', 'set_random_featured_images_for_posts' );

add_filter( 'excerpt_more', function() {
	return '';
} );


function msr_custom_sidebars() {
	// Sidebar for blog/archive page
	register_sidebar( [
		'name'          => __( 'Blog Sidebar', 'msr-child' ),
		'id'            => 'blog-sidebar',
		'description'   => __( 'Widgets in this area will be shown on the blog listing page.', 'msr-child' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );

	// Sidebar for blog single/details page
	register_sidebar( [
		'name'          => __( 'Blog Details Sidebar', 'msr-child' ),
		'id'            => 'blog-details-sidebar',
		'description'   => __( 'Widgets in this area will be shown on single blog posts.', 'msr-child' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
}
add_action( 'widgets_init', 'msr_custom_sidebars' );

function set_random_featured_images_for_posts() {
	if ( isset( $_GET['thumbnail_upload'] ) && $_GET['thumbnail_upload'] == 'ok') {

		// Get all posts without a featured image (limit to 20 per load to avoid overload)
		$args = [
			'post_type'      => 'post',
			'posts_per_page' => 20,
			'meta_query'     => [
				[
					'key'     => '_thumbnail_id',
					'compare' => 'NOT EXISTS',
				]
			],
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		];

		$posts = get_posts( $args );

		if ( ! $posts ) {
			return;
		}

		// Get all image attachments (limit to large images)
		$images = get_posts( [
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => - 1,
			'post_status'    => 'inherit',
			'orderby'        => 'rand',
		] );

		if ( empty( $images ) ) {
			return;
		}

		foreach ( $posts as $post ) {
			// Pick one random image
			$random_image = $images[ array_rand( $images ) ];

			// Optional: skip small images (e.g., less than 800px wide)
			$image_meta = wp_get_attachment_metadata( $random_image->ID );
			if ( isset( $image_meta['width'] ) && $image_meta['width'] < 800 ) {
				continue; // skip small images
			}

			// Set as featured image
			set_post_thumbnail( $post->ID, $random_image->ID );
		}
	}
}