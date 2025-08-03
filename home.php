<?php get_header();

//$editorial = get_page_by_path( 'blog-content' );
//$blog_title = get_the_title( $editorial );

$post_page_id       = get_option( 'page_for_posts' );
$author_image       = get_post_meta( $post_page_id, 'author_image', true );
$author_title       = get_post_meta( $post_page_id, 'author_title', true );
$author_description = get_post_meta( $post_page_id, 'author_description', true );

?>

    <header class="tour__hero msr-blog-hero">
        <div class="tour__hero-image">
			<?php echo wp_get_attachment_image( get_post_thumbnail_id( get_option( 'page_for_posts' ) ), 'large', false, array( "class" => "u-fit" ) ); ?>
        </div>
        <h1 class="tour__hero__title"
            style="font-size: clamp(21px, 10vw, 94px);"><?php echo get_the_title( $post_page_id ); ?></h1>
    </header>

<?php if ( $author_image || $author_title || $author_description ) : ?>
    <div class="blog__editorial-wrapper">
        <div class="is-layout-constrained">
            <div class="blog__editorial">

				<?php //echo $editorial->post_content; ?>

                <div class="wp-block-columns">
                    <div class="wp-block-column" style="flex-basis:33.33%">
                        <figure class="wp-block-image size-full has-custom-border is-style-rounded">
							<?php echo wp_get_attachment_image( $author_image, 'full' ) ?>
                        </figure>
                    </div>
                    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:75%">
                        <h2 class="wp-block-heading">
							<?php echo esc_html( $author_title ) ?>
                        </h2>
                        <p><?php echo esc_html( $author_description ) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

    <main <?php post_class( "mt-2 mb-2 is-layout-constrained" ); ?>>

        <div class="wp-block-group alignfull has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">

			<?php if ( have_posts() ) : ?>

                <div class="msr-blog-wrapper">
                    <div class="msr-blog-lists u-list-unstyled u-links-unstyled">

						<?php while ( have_posts() ) : the_post(); ?>

                            <div class="blog-list__card">
                                <div class="blog-list__card__image">
                                    <a href="<?php echo get_permalink(); ?>">
										<?php if ( has_post_thumbnail() ) :
											the_post_thumbnail(
												'thumb',
												array(
													'loading' => 'lazy',
													'class'   => 'u-fit',
												)
											);
										endif; ?>
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
                                        <span>&#8594</span>
                                    </a>
                                </div>
                            </div>

						<?php endwhile; ?>

                        <div class="blog-pagination msr-blog-navigation">
							<?php
							//This old code I just keep it as backup. It should be removed later.
							if ( false ) : ?>
								<?php if ( get_previous_posts_link() ) : ?>
                                    <div class="post_navigation_previous">
										<?php echo get_previous_posts_link( '&#8592 ' . __( 'Frühere Einträge', 'pnmtr' ) ); ?>
                                    </div>
								<?php endif; ?>
								<?php if ( get_next_posts_link() ) : ?>
                                    <div class="post_navigation_next">
										<?php echo get_next_posts_link( __( 'Spätere Einträge', 'pnmtr' ) . ' &#8594' ); ?>
                                    </div>
								<?php endif; ?>
							<?php endif; ?>


							<?php
							global $wp_query;
							$big = 999999999;
							echo paginate_links( [
								'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'    => '?paged=%#%',
								'current'   => max( 1, get_query_var( 'paged' ) ),
								'total'     => $wp_query->max_num_pages,
								'prev_text' => __( '&#8592 Prev' ),
								'next_text' => __( 'Next &#8594' ),
							] );
							?>
                        </div>
                    </div>

					<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
                        <div class="sidebar-wrapper">
                            <div class="sidebar-inner">
								<?php dynamic_sidebar( 'blog-sidebar' ); ?>
                            </div>
                        </div>
					<?php endif; ?>
                </div>

			<?php endif; ?>

			<?php
			if ( $post_page_id ) {
				$blog_page = get_post( $post_page_id );
				if ( $blog_page->post_content ) {
					echo apply_filters( 'the_content', $blog_page->post_content );
				}
			}
			?>

        </div>
    </main>


<?php get_footer();
