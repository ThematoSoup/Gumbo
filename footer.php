<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

		</div><!-- .inner -->
	</div><!-- #main -->

	<?php if ( ! gumbo_has_no_footer() ) : ?>
		<?php tha_footer_before(); ?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php tha_footer_top(); ?>
			<?php
			if ( is_active_sidebar( 'footer-widget-area' ) ) :
				echo '<div id="footer-widgets" class="inner clear flexible-widget-area ' . gumbo_count_widgets( 'footer-widget-area' ) . '">';
					echo '<div class="clear">';
					dynamic_sidebar( 'footer-widget-area' );
					echo '</div>';
				echo '</div><!-- #footer-widgets -->';
			endif;
			?>

			<div class="footer-bottom">
				<div class="inner clear">
					<div class="site-info">
						<?php
						/*
						 * Site credits
						 *
						 * @hooked	gumbo_footer_credits
						 */
						do_action( 'gumbo_credits' );
						?>
					</div><!-- .site-info -->

					<?php
						// Footer menu
						wp_nav_menu( array(
							'theme_location'	=> 'footer',
							'container'			=> '',
							'menu_class'		=> 'menu',
							'depth'				=> 1
						) );
					?>
				</div><!-- .clear -->
			</div><!-- .footer-bottom -->
			<?php tha_footer_bottom(); ?>
		</footer><!-- #colophon -->
		<?php tha_footer_after(); ?>
	<?php endif; // footer check ?>
</div><!-- #page -->

<?php tha_body_bottom(); ?>
<?php wp_footer(); ?>
</body>
</html>
