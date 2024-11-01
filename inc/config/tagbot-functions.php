<?php
/*
 * Core functions for TagBot plugin
 */
defined('ABSPATH') or die;

/*
 * Display keyphrases before or after post
 */
function tagbot_before_after_post_content($content){
	global $post;
	$custom_content = NULL;
	$keyphrases_new = wp_get_post_terms($post->ID, 'keyphrases');
	if (is_single()) {  
		if (!empty ($keyphrases_new)) {
			$option = get_option('kpe_indexing_settings');
			if (!defined('keyphrases_position')) define('keyphrases_position', 'keyphrases_position'); 
			if (!defined('posts_per_keyphrase')) define('posts_per_keyphrase', 'posts_per_keyphrase'); 
			if ($option[keyphrases_position] == 'after-content') {
				$content .= '<p class="post-keyphrases"><span>Keyphrases:</span>';
				foreach ($keyphrases_new as $keyphrase) {
					$count = $keyphrase->count;
					if ($count >= $option[posts_per_keyphrase]) {
						$content .= '<a href="' . get_term_link($keyphrase) . '">' . $keyphrase->name . '</a>';
					}
				}
				return $content;
			}
			else {
				$custom_content .= '<p class="post-keyphrases"><span>Keyphrases:</span>';
				foreach ($keyphrases_new as $keyphrase) {
					$count = $keyphrase->count; 
					if ($count >= $option[posts_per_keyphrase]) {
						$custom_content .= '<a href="' . get_term_link($keyphrase) . '">' . $keyphrase->name . '</a>';
					}
				}
				$custom_content .= $content;
				return $custom_content;
			}
		}
		else {
			return $content;
		}
	}
}
add_filter( 'the_content', 'tagbot_before_after_post_content' );



/*
 * Keyphrase Extraction function
 * Sends all posts to the external web service and gets the list of keyphrases
 */
add_action('admin_init', 'tagbot_index_posts');
function tagbot_index_posts( ) {
    if (!empty($_POST['kpe_indexing_field'])) {
 
        $args = array (
			'posts_per_page' => -1,
			'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
		);
 
		$kpe_posts = get_posts( $args );
		
		$endpoint_url = 'https://atypon.csd.auth.gr/keyphrase';
		
		
		
			foreach ( $kpe_posts as $kpe_post ) {
				$content = get_post_field('post_content', $kpe_post->ID);

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
					wp_set_post_terms( $kpe_post->ID, $results_new3, 'keyphrases', false );
				}
			}
		
	}
}
?>