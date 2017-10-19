<?php
/**
 * The template for displaying BuddyPress pages.
 *
 * @package    Glocal
 * @subpackage Glocal\Functions
 * @since      1.0.1
 * @license    GPL-2.0+
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
				<?php comments_template( '', true ); ?>
			<?php endif; ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer(); ?>
