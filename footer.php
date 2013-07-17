<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Gumbo
 */
?>

		</div><!-- .inner -->
	</div><!-- #main -->

	<?php tha_footer_before(); ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="inner clear">
			<?php tha_footer_top(); ?>
			<div class="site-info">
				<?php do_action( 'gumbo_credits' ); ?>
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'gumbo' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'gumbo' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'gumbo' ), 'Gumbo', '<a href="http://thematosoup.com" rel="designer">ThematoSoup</a>' ); ?>
			</div><!-- .site-info -->
			<?php tha_footer_bottom(); ?>
		</div><!-- .inner -->
	</footer><!-- #colophon -->
	<?php tha_footer_after(); ?>
</div><!-- #page -->

<?php tha_body_bottom(); ?>
<?php wp_footer(); ?>
</body>
</html>