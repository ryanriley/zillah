<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package zillah
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content-wrap' ); ?>>

	<header class="entry-header">
		<div class="content-inner-wrap">
			<?php
			zillah_posted_date();
			the_title( '<h1 class="entry-title">', '</h1>' );
			zillah_category();
			?>
		</div>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="post-thumbnail-wrap">';
		the_post_thumbnail();
		echo '</div>';
	}
	?>

	<div class="entry-content">
		<div class="content-inner-wrap">
			<?php

				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'zillah' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zillah' ),
					'after'  => '</div>',
				) );

			?>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="content-inner-wrap">
			<?php zillah_entry_footer(); ?>
		</div>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<div class="author-details-wrap">
	<div class="content-inner-wrap">
		<div class="author-details-img-wrap">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), '100' ); ?>
		</div>
		<?php
			$author_first_name =  get_the_author_meta( 'first_name' );
			$author_last_name = get_the_author_meta( 'last_name' );
			if( !empty( $author_first_name ) || !empty( $author_last_name ) ) {
				echo '<div class="author-details-title">';
					if( !empty($author_first_name) ) {
						echo sanitize_text_field($author_first_name) . ' ';
					}
					if( !empty($author_last_name) ) {
						echo sanitize_text_field($author_last_name);
					}
				echo '</div>';
			}
	
			$author_description = wp_kses_post( nl2br( get_the_author_meta('description') ) );
			if( !empty( $author_description ) ){
				echo '<div class="author-details-content">' . $author_description . '</div>';
			}
		?>
	</div>
</div>