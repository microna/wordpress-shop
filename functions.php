<?php

/**
 * Shop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shop
 */

 require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
 require_once get_template_directory() . '/inc/customizer.php';


/**
* Enqueue scripts and styles.
*/
function shop_scripts(){
	//Bootstrap javascript and CSS files
 	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/inc/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
 	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/inc/bootstrap.min.css', array(), '4.3.1', 'all' );

 	// Theme's main stylesheet
 	wp_enqueue_style( 'shop-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900');

	wp_enqueue_script('flexslider-min-js', get_template_directory_uri() . '/inc/flexslider/jquery.flexslider-min.js', array('jquery'), '', true);
	wp_enqueue_script('flexslider-js', get_template_directory_uri() . '/inc/flexslider/flexslider.js', array('jquery'), '', true);
	wp_enqueue_style('flexslider-css', get_template_directory_uri() . '/inc/flexslider/flexslider.css', array(), '', 'all');
 }
 add_action( 'wp_enqueue_scripts', 'shop_scripts' );

/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which
* runs before the init hook. The init hook is too late for some features, such
* as indicating support for post thumbnails.
*/
function shop_config(){

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'shop_main_menu' 	=> 'Shop Main Menu',
				'shop_footer_menu' => 'Shop Footer Menu',
			)
		);

		// This theme is WooCommerce compatible, so we're adding support to WooCommerce
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width' => 255,
			'single_image_width'	=> 255,
			'product_grid' 			=> array(
	            'default_rows'    => 10,
	            'min_rows'        => 5,
	            'max_rows'        => 10,
	            'default_columns' => 1,
	            'min_columns'     => 1,
	            'max_columns'     => 1,				
			)
		) );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support('custom-logo', array(
			'height' => 16,
			'width' => 325,
			'flex_height' => true,
			'flex_width' => true,
		));
		add_theme_support('post-thumbnails');
		add_image_size('shop-slider', 550, 380, array('center', 'center'));
		add_image_size('shop-blog', 960, 640, array('center', 'center'));

		if ( ! isset( $content_width ) ) {
			$content_width = 600;
		}				
}

add_action( 'after_setup_theme', 'shop_config', 0 );


if(class_exists('WooCommerce')){
    require get_template_directory() . '/inc/wc-modifications.php';
}

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'shop_woocommerce_header_add_to_cart_fragment' );

function shop_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<span class="items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['span.items'] = ob_get_clean();
	return $fragments;
}





    
