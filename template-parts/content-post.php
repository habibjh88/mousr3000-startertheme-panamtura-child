<?php
$has_sidebar          = is_active_sidebar( 'blog-details-sidebar' );
$post_container_class = $has_sidebar ? 'is-layout-constrained' : 'l-container--post';
?>
    <header class="tour__hero">
        <div class="tour__hero-image">
			<?php if ( has_post_thumbnail() ) :
				the_post_thumbnail(
					'large',
					array(
						'class' => 'u-fit',
					)
				);
			endif;
			?>
        </div>
    </header>


    <main <?php post_class( "mt-2 mb-2 msr-single-blog $post_container_class" ); ?>>

        <div class="blog-content-wrapper">
            <header>
                <div class="post-meta-info">

                    <span class="msr-post-categories"><?php the_category(); ?></span>

                    <span class="separator">—</span>
                    <span class="author">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.7137 8.34627C12.8655 7.50628 13.6155 6.14686 13.6155 4.61538C13.6155 2.07046 11.5451 0 9.00014 0C6.45521 0 4.38475 2.07046 4.38475 4.61538C4.38475 6.14686 5.13474 7.50628 6.28653 8.34627C3.42341 9.44191 1.38477 12.2179 1.38477 15.4615C1.38477 16.8613 2.52351 18 3.92322 18H14.0771C15.4768 18 16.6155 16.8613 16.6155 15.4615C16.6155 12.2179 14.5769 9.44191 11.7137 8.34627ZM5.76938 4.61538C5.76938 2.83395 7.2187 1.38463 9.00014 1.38463C10.7816 1.38463 12.2309 2.83395 12.2309 4.61538C12.2309 6.39682 10.7816 7.84617 9.00014 7.84617C7.2187 7.84617 5.76938 6.39682 5.76938 4.61538ZM14.0771 16.6154H3.92322C3.287 16.6154 2.76939 16.0978 2.76939 15.4615C2.76939 12.0258 5.56446 9.23073 9.00017 9.23073C12.4359 9.23073 15.2309 12.0258 15.2309 15.4615C15.2309 16.0978 14.7133 16.6154 14.0771 16.6154Z" fill="black"/></svg>
                    <?php
                    $prefix = "By";
                    printf(
                    // Translators: %1$s is the prefix, %2$s is the author's byline.
	                    esc_html__( '%1$s %2$s', 'neuzin' ),
	                    $prefix ? '<span class="prefix">' . $prefix . '</span>' : '',
	                    '<span class="byline"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a></span>'
                    )
                    ?>
                </span>
                    <span class="separator">—</span>
                    <span class="date">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_139_6)"><path d="M14.25 1.5H13.5V0.75C13.5 0.551088 13.421 0.360322 13.2803 0.21967C13.1397 0.0790176 12.9489 0 12.75 0C12.5511 0 12.3603 0.0790176 12.2197 0.21967C12.079 0.360322 12 0.551088 12 0.75V1.5H6V0.75C6 0.551088 5.92098 0.360322 5.78033 0.21967C5.63968 0.0790176 5.44891 0 5.25 0C5.05109 0 4.86032 0.0790176 4.71967 0.21967C4.57902 0.360322 4.5 0.551088 4.5 0.75V1.5H3.75C2.7558 1.50119 1.80267 1.89666 1.09966 2.59966C0.396661 3.30267 0.00119089 4.2558 0 5.25L0 14.25C0.00119089 15.2442 0.396661 16.1973 1.09966 16.9003C1.80267 17.6033 2.7558 17.9988 3.75 18H14.25C15.2442 17.9988 16.1973 17.6033 16.9003 16.9003C17.6033 16.1973 17.9988 15.2442 18 14.25V5.25C17.9988 4.2558 17.6033 3.30267 16.9003 2.59966C16.1973 1.89666 15.2442 1.50119 14.25 1.5ZM1.5 5.25C1.5 4.65326 1.73705 4.08097 2.15901 3.65901C2.58097 3.23705 3.15326 3 3.75 3H14.25C14.8467 3 15.419 3.23705 15.841 3.65901C16.2629 4.08097 16.5 4.65326 16.5 5.25V6H1.5V5.25ZM14.25 16.5H3.75C3.15326 16.5 2.58097 16.2629 2.15901 15.841C1.73705 15.419 1.5 14.8467 1.5 14.25V7.5H16.5V14.25C16.5 14.8467 16.2629 15.419 15.841 15.841C15.419 16.2629 14.8467 16.5 14.25 16.5Z" fill="black"/><path d="M9 12.375C9.62132 12.375 10.125 11.8713 10.125 11.25C10.125 10.6287 9.62132 10.125 9 10.125C8.37868 10.125 7.875 10.6287 7.875 11.25C7.875 11.8713 8.37868 12.375 9 12.375Z" fill="black"/><path d="M5.25 12.375C5.87132 12.375 6.375 11.8713 6.375 11.25C6.375 10.6287 5.87132 10.125 5.25 10.125C4.62868 10.125 4.125 10.6287 4.125 11.25C4.125 11.8713 4.62868 12.375 5.25 12.375Z" fill="black"/><path d="M12.75 12.375C13.3713 12.375 13.875 11.8713 13.875 11.25C13.875 10.6287 13.3713 10.125 12.75 10.125C12.1287 10.125 11.625 10.6287 11.625 11.25C11.625 11.8713 12.1287 12.375 12.75 12.375Z" fill="black"/></g><defs><clipPath id="clip0_139_6"><rect width="18" height="18" fill="white"/></clipPath></defs></svg>
                    <?php the_date(); ?>
                </span>
                </div>
                <h1 class="post-title"><?php the_title(); ?></h1>
            </header>
            <div class="msr-blog-wrapper">
                <div class="msr-blog-lists">
					<?php the_content(); ?>
                </div>

				<?php if ( is_active_sidebar( 'blog-details-sidebar' ) ) : ?>
                    <div class="sidebar-wrapper">
                        <div class="sidebar-inner">
							<?php dynamic_sidebar( 'blog-details-sidebar' ); ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </main>

<?php get_template_part( 'template-parts/related', 'post' ); ?>
<?php get_template_part( 'template-parts/partial', 'interlinking' ); ?>