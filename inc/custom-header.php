<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 *
 * @uses     gumbo_header_style()
 * @uses     gumbo_admin_header_style()
 * @uses     gumbo_admin_header_image()
 *
 * @package  Gumbo
 * @since    Gumbo 1.0
 */
function gumbo_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '#fff',
		'width'                  => 1600,
		'height'                 => 320,
		'flex-height'            => true,
		'wp-head-callback'       => 'gumbo_header_style',
		'admin-head-callback'    => 'gumbo_admin_header_style',
		'admin-preview-callback' => 'gumbo_admin_header_image',
	);

	$args = apply_filters( 'gumbo_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'gumbo_custom_header_setup' );


if ( ! function_exists( 'gumbo_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see gumbo_custom_header_setup().
 */
function gumbo_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles. ?>
	<style type="text/css" id="gumbo-header-css">
	<?php if ( ! empty( $header_image ) ) :	?>
		.has-header-image #masthead.header-nav-below hgroup,
		.has-header-image #masthead.header-nav-below-centered hgroup  {
			background-image: url(<?php header_image(); ?>);
			min-height: <?php echo get_custom_header()->height; ?>px;
			background-position: center;
			background-size: cover;
		}
		.has-header-image #masthead.header-nav-right  {
			background-image: url(<?php header_image(); ?>);
			min-height: <?php echo get_custom_header()->height; ?>px;
			background-position: center;
			background-size: cover;
		}
	<?php endif; ?>
		
	<?php if ( ! display_header_text() ) : // Has the text been hidden?	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
		<?php if ( empty( $header_image ) ) : ?>
		.site-header .home-link {
			min-height: 0;
		}
		<?php endif; ?>

	<?php elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) : // If the user has set a custom color for the text, use that. ?>
		.site-header .site-title,
		.site-header .site-title a,
		.site-header .site-description,
		.header-nav-right .navigation-main a,
		#top-navigation a,
		.header-nav-right .menu-toggle,
		#masthead.header-nav-right .main-small-navigation a,
		.scheme-dark #masthead .main-small-navigation a {
			color: #<?php echo esc_attr( $text_color ); ?> !important;
		}
		@media screen and (min-width: 601px) {
			#masthead.header-nav-right .navigation-main > ul > li.current-menu-item {
				border-bottom: 2px solid #<?php echo esc_attr( $text_color ); ?>;
			}
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // gumbo_header_style

if ( ! function_exists( 'gumbo_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see gumbo_custom_header_setup().
 */
function gumbo_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		position: relative;
	}
	.appearance_page_custom-header #headimg,
	.appearance_page_custom-header img {
		border: none;
		max-width: 100%;
	}
	#headimg h1,
	#desc {
		display: block;
		position: absolute;
	}
	#headimg h1 {
		top: 45px;
		font-size: 48px;
		left: 40px;
		line-height: 1;
		margin: 0 0 0.25em;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#desc {
		position: absolute;
		top: 95px;
		left: 40px;
		font-size: 16px;
	}
	</style>
<?php
}
endif; // gumbo_admin_header_style

if ( ! function_exists( 'gumbo_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see gumbo_custom_header_setup().
 */
function gumbo_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // gumbo_admin_header_image