<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Gumbo
 */
?>

	</div><!-- #main -->

	<?php
		// Before Footer theme hook callback
		thsp_hook_before_footer();
	?>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'gumbo_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'gumbo' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'gumbo' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'gumbo' ), 'Gumbo', '<a href="http://thematosoup.com" rel="designer">ThematoSoup</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php
		// Before Footer theme hook callback
		thsp_hook_after_footer();
	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>