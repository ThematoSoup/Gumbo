<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Gumbo
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
		$thsp_theme_options = thsp_cbp_get_options_values();
		$thsp_header_class = $thsp_theme_options['main_nav_placement'];
	?>
	<header id="masthead" class="site-header <?php echo $thsp_header_class; ?>" role="banner">
		<div class="inner clear">
			<?php tha_header_top(); ?>
			<hgroup>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
		
			<nav id="site-navigation" class="navigation-main" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'gumbo' ); ?></h1>
				<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'gumbo' ); ?>"><?php _e( 'Skip to content', 'gumbo' ); ?></a></div>
		
				<?php
					$thsp_walker = new THSP_Menu_With_Description;
					wp_nav_menu( array(
						'theme_location'	=> 'primary',
						'walker'			=> $thsp_walker,
						'link_before'		=> '<span class="menu-item-text">',
						'link_after'		=> '</span>',
						'container'			=> ''
					) );
				?>
			</nav><!-- #site-navigation -->
			<?php tha_header_bottom(); ?>
		</div><!-- .inner -->
	</header><!-- #masthead -->
	<?php tha_header_after(); ?>

	<div id="main" class="site-main">
		<div class="inner clear">