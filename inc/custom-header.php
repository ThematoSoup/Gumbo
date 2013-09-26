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
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses thsp_header_style()
 * @uses thsp_admin_header_style()
 * @uses thsp_admin_header_image()
 *
 * @package Gumbo
 */
function thsp_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '',
		'width'                  => 1600,
		'height'                 => 300,
		'flex-height'            => true,
		'wp-head-callback'       => 'thsp_header_style',
		'admin-head-callback'    => 'thsp_admin_header_style',
		'admin-preview-callback' => 'thsp_admin_header_image',
	);

	$args = apply_filters( 'thsp_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'thsp_custom_header_setup' );


if ( ! function_exists( 'thsp_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see thsp_custom_header_setup().
 */
function thsp_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="twentythirteen-header-css">
	<?php
		if ( ! empty( $header_image ) ) :
	?>
		#masthead.header-image  {
			background-image: url(<?php header_image(); ?>);
			background-attachment: fixed;
			background-position: center top;
			background-size: 1600px auto;
			background-repeat: no-repeat;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
			if ( empty( $header_image ) ) :
	?>
		.site-header .home-link {
			min-height: 0;
		}
	<?php
			endif;

		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-header .site-title,
		.site-header .site-title a,
		.site-header .site-description,
		.header-nav-right .navigation-main a {
			color: #<?php echo esc_attr( $text_color ); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // thsp_header_style

if ( ! function_exists( 'thsp_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see thsp_custom_header_setup().
 */
function thsp_admin_header_style() {
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
		top: 70px;
		font-size: 48px;
		left: 40px;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#desc {
		position: absolute;
		top: 140px;
		left: 40px;
		font-size: 16px;
	}
	</style>
<?php
}
endif; // thsp_admin_header_style

if ( ! function_exists( 'thsp_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see thsp_custom_header_setup().
 */
function thsp_admin_header_image() { ?>
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
endif; // thsp_admin_header_image