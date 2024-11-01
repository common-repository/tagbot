<?php

defined('ABSPATH') or die;

/*
 * Create custom taxonomy 'keyphrases' for posts
 */
function tagbot_tags() {
	register_taxonomy( 
		'keyphrases', //taxonomy 
		'post', //post-type
		array( 
			'hierarchical'  => false, 
			'label'         => __( 'Keyphrases','kpe'), 
			'singular_name' => __( 'Keyphrases', 'kpe' ), 
			'rewrite'       => true, 
			'query_var'     => true 
		)
	);
}
add_action( 'init', 'tagbot_tags');


/*
 * Function add_kpe_fields
 * Sends post's content to external web service,
 * gets the list of keyphrases and add it as tags for this post
 */
function add_tagbot_fields( $kpe_id, $kpe ) {
    if ( $kpe->post_type == 'post' ) {
		$endpoint_url = 'https://atypon.csd.auth.gr/keyphrase';

		$content = get_post_field('post_content', $kpe->ID);
		
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'body' => array('text' => $content)
		);
			
		$results = wp_remote_post( $endpoint_url, $args);
		
		if ( is_wp_error( $results ) ) {
			$error_message = $results->get_error_message();
			return $error_message;
		} else {
			$results_new = str_replace('"', '', $results['body']);
			$results_new2 = str_replace('[', '', $results_new);
			$results_new3 = str_replace(']', '', $results_new2);
			wp_set_post_terms( $kpe->ID, $results_new3, 'keyphrases', false );
		}
    }
}
add_action( 'save_post', 'add_tagbot_fields', 10, 2 );

?>