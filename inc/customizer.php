<?php
/**
 * FitClub Theme Customizer.
 *
 * @package FitClub
 */

/**
 * Loads custom control for layout settings
 */
function fitclub_custom_controls() {

	require_once get_template_directory() . '/inc/admin/customize-image-radio-control.php';
	require_once get_template_directory() . '/inc/admin/customize-custom-css-control.php';

}

/* Theme Customizer setup. */
add_action( 'customize_register', 'fitclub_custom_controls' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fitclub_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Header Options
	$wp_customize->add_panel(
		'fitclub_header_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Change Header Settings here', 'fitclub' ),
			'priority'    => 160,
			'title'       => esc_html__( 'Header Options', 'fitclub' )
			)
		);

	// Logo Section
	$wp_customize->add_section(
		'fitclub_header_logo',
		array(
			'priority'   => 10,
			'title'      => esc_html__( 'Header Logo', 'fitclub' ),
			'panel'      => 'fitclub_header_options'
		)
	);

	// Logo Upload
	$wp_customize->add_setting(
		'fitclub_logo',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'esc_url_raw'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'fitclub_logo',
			array(
				'label'    => esc_html__( 'Upload logo' , 'fitclub' ),
				'section'  => 'fitclub_header_logo',
				'setting'  => 'fitclub_logo'
			)
		)
	);

	// Logo Placement
	$wp_customize->add_setting(
		'fitclub_logo_placement',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_radio_sanitize'
		)
	);

	$wp_customize->add_control(
		'fitclub_logo_placement',
		array(
			'label'    => esc_html__( 'Choose the required option', 'fitclub' ),
			'section'  => 'fitclub_header_logo',
			'type'     => 'radio',
			'choices'  => array(
				'header_logo_only' => esc_html__( 'Header Logo Only', 'fitclub' ),
				'header_text_only' => esc_html__( 'Header Text Only', 'fitclub' ),
				'show_both'        => esc_html__( 'Show both header logo and text', 'fitclub' ),
				'disable'          => esc_html__( 'Disable', 'fitclub' )
			)
		)
	);

	// Slider Options
	$wp_customize->add_panel(
		'fitclub_slider_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Change Slider Settings here', 'fitclub' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Slider Options', 'fitclub' )
			)
		);

	// Slider Section
	$wp_customize->add_section(
		'fitclub_header_slider',
		array(
			'priority'    => 10,
			'title'       => esc_html__( 'Slider Settings', 'fitclub' ),
			'description' => '<strong>'.__( 'Note', 'fitclub').'</strong><br/>'.__( '1. To display the Slider first check Enable the slider below. Now create the page for each slider and enter title, text and featured image. Choose that pages in the dropdown options.', 'fitclub').'<br/>'.__( '2. The recommended size for the slider image is 1920 x 1000 pixels. For better functioning of slider use equal size images for each slide.', 'fitclub' ).'<br/>'.__( '3. If page do not have featured Image than that page will not included in slider show.', 'fitclub' ),
			'panel'       => 'fitclub_slider_options'
		)
	);

	// Slider Activation Setting
	$wp_customize->add_setting(
		'fitclub_slider_activation',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_slider_activation',
		array(
			'label'    => esc_html__( 'Enable Slider' , 'fitclub' ),
			'section'  => 'fitclub_header_slider',
			'type'     => 'checkbox',
			'priority' => 10
		)
	);

	// Slider Images Selection Setting
	for( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting(
			'fitclub_slide'.$i,
			array(
				'default'            => '',
				'capability'         => 'edit_theme_options',
				'sanitize_callback'  => 'fitclub_sanitize_integer'
			)
		);

		$wp_customize->add_control(
			'fitclub_slide'.$i,
			array(
				'label'    => esc_html__( 'Slide ' , 'fitclub' ).$i,
				'section'  => 'fitclub_header_slider',
				'type'     => 'dropdown-pages',
				'priority' =>  $i+10
			)
		);
	}

	// Design Related Options
	$wp_customize->add_panel(
		'fitclub_design_options',
		array(
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Design Related Settings', 'fitclub' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Design Options', 'fitclub' )
		)
	);

	// Default Layout
	$wp_customize->add_section(
		'fitclub_default_layout_section',
		array(
			'priority'  => 10,
			'title'     => esc_html__( 'Default Layout', 'fitclub' ),
			'panel'     => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_default_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'fitclub_radio_sanitize'
		)
	);

	$wp_customize->add_control(
		new FitClub_Image_Radio_Control (
			$wp_customize,
			'fitclub_default_layout',
			array(
				'label'   => esc_html__( 'Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options', 'fitclub' ),
				'section' => 'fitclub_default_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => FitClub_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => FitClub_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Default Pages Layout
	$wp_customize->add_section(
		'fitclub_default_page_layout_section',
		array(
			'priority'  => 20,
			'title'     => esc_html__( 'Default Page Layout', 'fitclub' ),
			'panel'     => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_default_page_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'fitclub_radio_sanitize'
		)
	);

	$wp_customize->add_control(
		new FitClub_Image_Radio_Control (
			$wp_customize,
			'fitclub_default_page_layout',
			array(
				'label'   => esc_html__( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page', 'fitclub' ),
				'section' => 'fitclub_default_page_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => FitClub_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => FitClub_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Default Single Post Layout
	$wp_customize->add_section(
		'fitclub_default_single_post_layout_section',
		array(
			'priority'  => 30,
			'title'     => esc_html__( 'Default Single Post Layout', 'fitclub' ),
			'panel'     => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_default_single_post_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'fitclub_radio_sanitize'
		)
	);

	$wp_customize->add_control(
		new FitClub_Image_Radio_Control (
			$wp_customize,
			'fitclub_default_single_post_layout',
			array(
				'label'   => esc_html__( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'fitclub' ),
				'section' => 'fitclub_default_single_post_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => FitClub_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => FitClub_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => FitClub_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Primary Color Setting
	$wp_customize->add_section(
		'fitclub_primary_color_section',
		array(
			'priority'   => 40,
			'title'      => esc_html__( 'Primary Color Option', 'fitclub' ),
			'panel'      => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_primary_color',
		array(
			'default'              => '#b5d043',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'fitclub_hex_color_sanitize',
			'sanitize_js_callback' => 'fitclub_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fitclub_primary_color',
			array(
				'label'    => esc_html__( 'This will reflect in links, buttons and many others. Choose a color to match your site', 'fitclub' ),
				'section'  => 'fitclub_primary_color_section'
			)
		)
	);

	// Custom CSS Section
	$wp_customize->add_section(
		'fitclub_custom_css_section',
		array(
			'priority'  => 50,
			'title'     => esc_html__( 'Custom CSS', 'fitclub' ),
			'panel'     => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_custom_css',
		array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);

	$wp_customize->add_control(
		new FitClub_Custom_CSS_Control(
			$wp_customize,
			'fitclub_custom_css',
			array(
				'label'   => esc_html__( 'Write your Custom CSS here', 'fitclub' ),
				'section' => 'fitclub_custom_css_section'
			)
		)
	);

	// Footer Widget Section
	$wp_customize->add_section(
		'fitclub_footer_widget_section',
		array(
			'priority'   => 60,
			'title'      => esc_html__( 'Footer Widgets', 'fitclub' ),
			'panel'      => 'fitclub_design_options'
		)
	);

	$wp_customize->add_setting(
		'fitclub_footer_widgets',
		array(
			'default'            => 4,
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_integer'
		)
	);

	$wp_customize->add_control(
		'fitclub_footer_widgets',
		array(
			'label'    => esc_html__( 'Choose the number of widget area you want in footer', 'fitclub' ),
			'section'  => 'fitclub_footer_widget_section',
			'type'     => 'select',
			'choices'    => array(
            	'1' => esc_html__('1 Footer Widget Area', 'fitclub'),
            	'2' => esc_html__('2 Footer Widget Area', 'fitclub'),
            	'3' => esc_html__('3 Footer Widget Area', 'fitclub'),
            	'4' => esc_html__('4 Footer Widget Area', 'fitclub')
        	),
 		)
	);

	// Additional Options
	$wp_customize->add_panel(
		'fitclub_additional_options',
		array(
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Some additional settings.', 'fitclub' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Additional Options', 'fitclub' )
			)
		);

	// Content Selection Section
	$wp_customize->add_section(
		'fitclub_content_setting',
		array(
			'priority'   => 10,
			'title'      => esc_html__( 'Excerpt/Full Content Option', 'fitclub' ),
			'panel'      => 'fitclub_additional_options'
		)
	);

	// Content Selection Setting
	$wp_customize->add_setting(
		'fitclub_content_show',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_radio_sanitize'
		)
	);

	$wp_customize->add_control(
		'fitclub_content_show',
		array(
			'label'    => esc_html__( 'Toggle between displaying excerpts and full posts on your blog and archives.' , 'fitclub' ),
			'section'  => 'fitclub_content_setting',
			'priority' => 10,
			'type'     => 'radio',
			'choices'  => array(
				'show_fullcontent' => esc_html__( 'Show Full Post Content', 'fitclub' ),
				'show_excerpt'     => esc_html__( 'Show Excerpt', 'fitclub' )
			)
		)
	);

	// Front/Blog Page Content Section
	$wp_customize->add_section(
		'fitclub_frontpage_content_section',
		array(
			'priority'   => '20',
			'title'      => esc_html__( 'Hide Content in Front/Blog Page', 'fitclub' ),
			'panel'      => 'fitclub_additional_options'
		)
	);

	// Front/Blog Page Content Setting
	$wp_customize->add_setting(
		'fitclub_frontpage_content',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_frontpage_content',
		array(
			'label'    => esc_html__( 'Check to hide blog posts/static page on front page.' , 'fitclub' ),
			'section'  => 'fitclub_frontpage_content_section',
			'priority' => 10,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Section
	$wp_customize->add_section(
		'fitclub_postmeta_section',
		array(
			'priority'   => 30,
			'title'      => esc_html__( 'Post Meta Settings', 'fitclub'),
			'panel'      => 'fitclub_additional_options'
		)
	);

	// Post Meta Setting
	$wp_customize->add_setting(
		'fitclub_postmeta',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta',
		array(
			'label'    => esc_html__( 'Hide all post meta data under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_section',
			'priority' => 10,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Date Setting
	$wp_customize->add_setting(
		'fitclub_postmeta_date',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta_date',
		array(
			'label'    => esc_html__( 'Hide date under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_section',
			'priority' => 20,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Author Setting
	$wp_customize->add_setting(
		'fitclub_postmeta_author',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta_author',
		array(
			'label'    => esc_html__( 'Hide author under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_section',
			'priority' => 30,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Comment Count Setting
	$wp_customize->add_setting(
		'fitclub_postmeta_comment',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta_comment',
		array(
			'label'    => esc_html__( 'Hide comment count under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_section',
			'priority' => 40,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Category Setting
	$wp_customize->add_setting(
		'fitclub_postmeta_category',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta_category',
		array(
			'label'    => esc_html__( 'Hide category under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_section',
			'priority' => 50,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Tags Setting
	$wp_customize->add_setting(
		'fitclub_postmeta_tags',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'fitclub_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'fitclub_postmeta_tags',
		array(
			'label'    => esc_html__( 'Hide tags under post title.' , 'fitclub' ),
			'section'  => 'fitclub_postmeta_tags',
			'priority' => 60,
			'type'     => 'checkbox'
		)
	);
}


// Checkbox sanitization
function fitclub_sanitize_checkbox($input) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}
// Sanitize Integer
function fitclub_sanitize_integer( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}
// Sanitize Radio Button
function fitclub_radio_sanitize( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
// Sanitize Color
function fitclub_hex_color_sanitize( $color ) {
	if ($unhashed = sanitize_hex_color_no_hash($color))
		return '#' . $unhashed;

	return $color;
}
// Escape Color
function fitclub_color_escaping_sanitize( $input ) {
	$input = esc_attr($input);
	return $input;
}

add_action( 'customize_register', 'fitclub_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fitclub_customize_preview_js() {
	wp_enqueue_script( 'fitclub_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'fitclub_customize_preview_js' );
