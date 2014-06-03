<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?><!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php tha_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php tha_head_bottom(); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php tha_body_top(); ?>

<div id="page" class="hfeed site">	
	<?php if ( ! gumbo_has_no_header() ) : ?>
		<?php tha_header_before(); ?>		
		<header id="masthead" class="site-header <?php echo gumbo_header_classes(); ?>" role="banner">
			<?php if ( has_nav_menu( 'top' ) ) : ?>
			<nav id="top-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'top',
						'container'			=> '',
						'menu_class'		=> 'nav-menu menu inner',
						'depth'				=> 1
					) );
				?>
			</nav><!-- #top-navigation -->
			<?php endif; ?>
	
			<div id="header-inner" class="clear">
				<?php tha_header_top(); ?>
				<hgroup>
					<?php
					// Get current theme options values
					$gumbo_theme_options = thsp_cbp_get_options_values();
					if ( '' != $gumbo_theme_options['logo_image'] ) :
						$logo_image = gumbo_get_logo_image( $gumbo_theme_options['logo_image'] ); ?>
						<h1 class="logo-image">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo $logo_image[0]; ?>" width="<?php echo $logo_image[1]; ?>" height="<?php echo $logo_image[2]; ?>" alt="<?php bloginfo( 'name' ); ?>" />
							</a>
						</h1>
					<?php else : // if ( ! isset( $gumbo_theme_options['logo_image'] ) ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php endif; ?>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			
				<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav id="site-navigation" class="navigation-main" role="navigation">
					<h1 class="menu-toggle"><?php _e( 'Menu', 'gumbo' ); ?></h1>
					<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'gumbo' ); ?>"><?php _e( 'Skip to content', 'gumbo' ); ?></a></div>
			
					<?php
						$walker = new gumbo_Menu_With_Description;
						wp_nav_menu( array(
							'theme_location'	=> 'primary',
							'container'			=> '',
							'menu_class'		=> 'menu inner',
							'fallback_cb'		=> '',
							'walker'			=> $walker
						) );
					?>
				</nav><!-- #site-navigation -->
				<?php endif; // Menu check ?>
				<?php tha_header_bottom(); ?>
			</div><!-- .clear -->
		</header><!-- #masthead -->
		<?php tha_header_after(); ?>
	<?php endif; // header check ?>

	<?php
	if ( is_front_page() && ! is_paged() && $gumbo_theme_options['display_featured'] ) :
		get_template_part( '/partials/featured', 'content' ); 
	endif;
	?>

	<div id="main" class="site-main">
		<div class="inner clear">