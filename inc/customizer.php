<?php
/**
 * zillah Theme Customizer.
 *
 * @package zillah
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zillah_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->default = '#7fcaad';

	require_once ( 'class/zillah_category-selector-control.php');

    $wp_customize->get_control( 'blogname' )->priority = 3;
    $wp_customize->get_control( 'blogdescription' )->priority = 4;

	$custom_logo = $wp_customize->get_control( 'custom_logo' );
	if( !empty( $custom_logo ) ) {
		$wp_customize->get_control( 'custom_logo' )->priority = 5;
	}

	/* Title tagline */
	$wp_customize->add_setting('zillah_tagline_show', array(
		'default' => 0,
		'sanitize_callback' => 'zillah_sanitize_checkbox',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('zillah_tagline_show', array(
		'label' => esc_html__('Hide Site Title', 'zillah'),
		'section' => 'title_tagline',
		'priority' => 50,
		'type'	=> 'checkbox',
	));

	/* Advanced options */
	$wp_customize->add_section( 'zillah_home_theme_option_section', array(
		'title'	=> esc_html__( 'Theme options', 'zillah' ),
		'priority'	=> 20,
	) );

	/* Show sidebar */
	$wp_customize->add_setting('zillah_sidebar_show', array(
		'default' => 0,
		'sanitize_callback' => 'zillah_sanitize_checkbox',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('zillah_sidebar_show', array(
		'label' => esc_html__('Show sidebar', 'zillah'),
		'description' => esc_html__('If you check this box, the sidebar will appear.', 'zillah'),
		'section' => 'zillah_home_theme_option_section',
		'priority' => 1,
		'type'	=> 'checkbox',
	));

	/* Show Tags */
	$wp_customize->add_setting('zillah_tags_show', array(
		'default' => 0,
		'sanitize_callback' => 'zillah_sanitize_checkbox',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('zillah_tags_show', array(
		'label' => esc_html__('Show tags', 'zillah'),
		'description' => esc_html__('If you check this box, the tags will appear in posts.', 'zillah'),
		'section' => 'zillah_home_theme_option_section',
		'priority' => 2,
		'type'	=> 'checkbox',
	));

	/* Featured Content Slider */
	$wp_customize->add_section( 'zillah_featured_content_slider_section', array(
		'title'	=> esc_html__( 'Featured content slider', 'zillah' ),
		'priority'	=> 25,
	) );

	$wp_customize->add_setting('zillah_home_slider_show', array(
		'default' => 0,
		'sanitize_callback' => 'zillah_sanitize_checkbox',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control('zillah_home_slider_show', array(
		'label' => esc_html__('Show slider', 'zillah'),
		'description' => esc_html__('If you check this box, the slider area will appear on the homepage.', 'zillah'),
		'section' => 'zillah_featured_content_slider_section',
		'priority' => 1,
		'type'	=> 'checkbox',
	));

	$wp_customize->add_setting('zillah_home_slider_category', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control( new Zillah_Category_Control( $wp_customize, 'zillah_home_slider_category', array(
		'label'    => 'Category',
		'section'  => 'zillah_featured_content_slider_section',
		'priority' => 2,
	)));

	/* Colors */
	require_once ( 'class/zillah-palette-picker.php');
	$wp_customize->add_setting( 'zillah_palette_picker',array('sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control( new Zillah_Palette( $wp_customize, 'zillah_palette_picker', array(
		'label'   => esc_html__('Change the color scheme','zillah'),
		'section' => 'colors',
		'priority' => 1,
		'metro_customizr_image_control' => true,
		'metro_customizr_icon_control' => true,
		'metro_customizr_text_control' => false,
		'metro_customizr_link_control' => true
	) ) );

}
add_action( 'customize_register', 'zillah_customize_register' );

/**
 * Sanitization functions
 */
function zillah_sanitize_checkbox( $input ){
    return ( isset( $input ) && true == $input ? true : false );
}

function zillah_sanitize_repeater( $input ) {
    $input_decoded = json_decode( $input, true );
    if( !empty( $input_decoded ) ) {
        $icons_array = array('none' => 'none','500px' => 'fa-500px','amazon' => 'fa-amazon','android' => 'fa-android','behance' => 'fa-behance','behance-square' => 'fa-behance-square','bitbucket' => 'fa-bitbucket','bitbucket-square' => 'fa-bitbucket-square','american-express' => 'fa-cc-amex','diners-club' => 'fa-cc-diners-club','discover' => 'fa-cc-discover','jcb' => 'fa-cc-jcb','mastercard' => 'fa-cc-mastercard','paypal' => 'fa-cc-paypal','stripe' => 'fa-cc-stripe','visa' => 'fa-cc-visa','codepen' => 'fa-codepen','css3' => 'fa-css3','delicious' => 'fa-delicious','deviantart' => 'fa-deviantart','digg' => 'fa-digg','dribble' => 'fa-dribbble','dropbox' => 'fa-dropbox','drupal' => 'fa-drupal','facebook' => 'fa-facebook','facebook-official' => 'fa-facebook-official','facebook-square' => 'fa-facebook-square','flickr' => 'fa-flickr','foursquare' => 'fa-foursquare','git' => 'fa-git','git-square' => 'fa-git-square','github' => 'fa-github','github-alt' => 'fa-github-alt','github-square' => 'fa-github-square','google' => 'fa-google','google-plus' => 'fa-google-plus','google-plus-square' => 'fa-google-plus-square','html5' => 'fa-html5','instagram' => 'fa-instagram','joomla' => 'fa-joomla','jsfiddle' => 'fa-jsfiddle','linkedin' => 'fa-linkedin','linkedin-square' => 'fa-linkedin-square','opencart' => 'fa-opencart','openid' => 'fa-openid','paypal' => 'fa-paypal','pinterest' => 'fa-pinterest','pinterest-p' => 'fa-pinterest-p','pinterest-square' => 'fa-pinterest-square','rebel' => 'fa-rebel','reddit' => 'fa-reddit','reddit-square' => 'fa-reddit-square','share' => 'fa-share-alt','share-square' => 'fa-share-alt-square','skype' => 'fa-skype','slack' => 'fa-slack','soundcloud' => 'fa-soundcloud','spotify' => 'fa-spotify','stack-overflow' => 'fa-stack-overflow','steam' => 'fa-steam','steam-square' => 'fa-steam-square','tripadvisor' => 'fa-tripadvisor','tumblr' => 'fa-tumblr','tumblr-square' => 'fa-tumblr-square','twitch' => 'fa-twitch','twitter' => 'fa-twitter','twitter-square' => 'fa-twitter-square','vimeo' => 'fa-vimeo','vimeo-square' => 'fa-vimeo-square','vine' => 'fa-vine','whatsapp' => 'fa-whatsapp','wordpress' => 'fa-wordpress','yahoo' => 'fa-yahoo','youtube' => 'fa-youtube','youtube-play' => 'fa-youtube-play','youtube-squar' => 'fa-youtube-square');

        foreach ($input_decoded as $iconk => $iconv) {
            foreach ($iconv as $key => $value) {
                if ( $key == 'icon_value' && !in_array( $value, $icons_array ) ){
                    $input_decoded [$iconk][$key] = 'none';
                }
                if( $key == 'link' ){
                    $input_decoded [$iconk][$key] = esc_url( $value );;
                }
            }
        }
        $result =  json_encode( $input_decoded );
        return $result;
    }
    return $input;
}

function zillah_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function zillah_customize_preview_js() {
	wp_enqueue_script( 'zillah_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'zillah_customize_preview_js' );
