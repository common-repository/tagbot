<?php

defined('ABSPATH') or die;

/* 
 * Enqueue CSS & JS Files for TagBot Plugin - Frontend Area
 */
function tagbot_scripts() {
	$pluginDIR = 'tagbot';
	wp_register_style('tagbot-css', plugins_url( $pluginDIR . '/assets/css/tagbot.css'));
	wp_enqueue_style('tagbot-css');
	wp_register_style('tagbot-fontawesome', plugins_url( $pluginDIR . '/assets/css/font-awesome.css'));
	wp_enqueue_style('tagbot-fontawesome');
	wp_register_style('tagbot-uikit', plugins_url( $pluginDIR . '/assets/css/uikit.css'));
	wp_enqueue_style('tagbot-uikit');
	wp_register_style('tagbot-uikit-notify', plugins_url( $pluginDIR . '/assets/css/notify.min.css'));
	wp_enqueue_style('tagbot-uikit-notify');
	
    wp_register_script( 'tagbot-uikit', plugins_url( $pluginDIR . '/assets/js/uikit.min.js'), array('jquery'));
    wp_enqueue_script( 'tagbot-uikit' );
}
add_action( 'wp_enqueue_scripts', 'tagbot_scripts' );


/* 
 * Enqueue CSS & JS Files for TagBot Plugin - Admin Area
 */
function tagbot_admin_scripts() {
	$pluginDIR = 'tagbot';
	wp_register_style('tagbot-uikit', plugins_url( $pluginDIR . '/assets/css/uikit.css'));
	wp_enqueue_style('tagbot-uikit');
	wp_register_style('tagbot-fontawesome', plugins_url( $pluginDIR . '/assets/css/font-awesome.css'));
	wp_enqueue_style('tagbot-fontawesome');
	wp_register_style('tagbot-uikit-notify', plugins_url( $pluginDIR . '/assets/css/notify.min.css'));
	wp_enqueue_style('tagbot-uikit-notify');
	wp_register_style('tagbot-admin', plugins_url( $pluginDIR . '/assets/css/tagbot-admin.css'));
	wp_enqueue_style('tagbot-admin');
	
    wp_register_script( 'tagbot-uikit', plugins_url( $pluginDIR . '/assets/js/uikit.min.js'), array('jquery'));
    wp_enqueue_script( 'tagbot-uikit' );
	wp_register_script( 'tagbot-uikit-notify', plugins_url( $pluginDIR . '/assets/js/notify.min.js'), array('jquery'));
    wp_enqueue_script( 'tagbot-uikit-notify' );
	
	wp_enqueue_style( 'tagbot-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,700', false ); 
}
add_action( 'admin_enqueue_scripts', 'tagbot_admin_scripts' );

?>