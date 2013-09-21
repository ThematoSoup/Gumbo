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
	<?php tha_header_before(); ?>		
	<?php
	// Header layout
	$thsp_theme_options = thsp_cbp_get_options_values();
	$thsp_header_class = 'header-' . $thsp_theme_options['main_nav_placement'];
	// Check header image
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) :
		$thsp_header_class .= ' header-image';
	endif;
	?>

	<header id="masthead" class="site-header <?php echo $thsp_header_class; ?>" role="banner">
		<?php if ( has_nav_menu( 'top' ) ) : ?>
		<nav id="top-navigation" role="navigation">
			<?php
				wp_nav_menu( array(
					'theme_location'	=> 'top',
					'container'			=> '',
					'menu_class'		=> 'menu inner'
				) );
			?>
		</nav><!-- #top-navigation -->
		<?php endif; ?>

		<div id="header-inner" class="clear">
			<?php tha_header_top(); ?>
			<hgroup>
				<?php
				// Get current theme options values
				$thsp_theme_options = thsp_cbp_get_options_values();
				if ( '' != $thsp_theme_options['logo_image'] ) :
					$logo_image = thsp_get_logo_image( $thsp_theme_options['logo_image'] ); ?>
					<a class="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php echo $logo_image[0]; ?>" width="<?php echo $logo_image[1]; ?>" height="<?php echo $logo_image[2]; ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
				<?php else : // if ( ! isset( $thsp_theme_options['logo_image'] ) ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
		
			<nav id="site-navigation" class="navigation-main" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'gumbo' ); ?></h1>
				<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'gumbo' ); ?>"><?php _e( 'Skip to content', 'gumbo' ); ?></a></div>
		
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'primary',
						'container'			=> '',
						'menu_class'		=> 'menu inner'
					) );
				?>
			</nav><!-- #site-navigation -->
			<?php tha_header_bottom(); ?>
		</div><!-- .clear -->
	</header><!-- #masthead -->
	<?php tha_header_after(); ?>

	<div id="main" class="site-main">
		<div class="inner clear">