<?php
/*
 * Keyphrase Extraction plugin - Settings
 * Plugin's settings page for admins. Index all posts in order to get the keyphrases. 
 * The posts are sent to the external Web Service and the Web Service returns a JSON file
 * with post's keyphrases.
 */

defined('ABSPATH') or die;

add_action( 'admin_menu', 'kpe_add_admin_menu' );
add_action( 'admin_init', 'kpe_settings_init' );


function kpe_add_admin_menu() {
    add_menu_page(
        __( 'TagBot', 'kpe' ),
        'TagBot',
        'manage_options',
        'kpe',
        'kpe_settings',
        'dashicons-tag',
        90
    );
}


/*
 * Register settings for Keyphrase Extraction plugin
 */
function kpe_settings_init(  ) { 
	
	register_setting( 'kpeIndexing', 'kpe_indexing' );
	register_setting( 'kpeIndexingSettings', 'kpe_indexing_settings' );

	add_settings_section(
		'kpe_indexing_section', 
		__( 'Post Indexing', 'kpe' ), 
		'kpe_indexing_section_callback', 
		'kpeIndexing'
	);
	add_settings_section(
		'kpe_indexing_settings_section', 
		__( 'Options', 'kpe' ), 
		'kpe_indexing_settings_section_callback', 
		'kpeIndexingSettings'
	);
	
	add_settings_field( 
		'kpe_indexing_field', 
		__( 'Index All Posts', 'kpe' ), 
		'kpe_indexing_field_render', 
		'kpeIndexing', 
		'kpe_indexing_section' 
	);
	add_settings_field( 
		'keyphrases_position', 
		__( 'Display Keyphrases', 'kpe' ), 
		'keyphrases_position_render', 
		'kpeIndexingSettings', 
		'kpe_indexing_settings_section' 
	);
	add_settings_field( 
		'posts_per_keyphrase', 
		__( 'Posts per keyphrase', 'kpe' ), 
		'posts_per_keyphrase_render', 
		'kpeIndexingSettings', 
		'kpe_indexing_settings_section' 
	);
}

function kpe_indexing_field_render( ) { 
	$options = get_option( 'kpe_indexing' );
?><input type="hidden" id="kpe_indexing_field" name="kpe_indexing_field" value="1" />
<?php
}
function keyphrases_position_render( ) { 
	$option = get_option( 'kpe_indexing_settings' );
?>
<select name='kpe_indexing_settings[keyphrases_position]'>
	<option value='after-content' <?php selected( $option['keyphrases_position'], 'after-content' ); ?>>After Content</option>
	<option value='before-content' <?php selected( $option['keyphrases_position'], 'before-content' ); ?>>Before Content</option>
</select>
<?php
}
function posts_per_keyphrase_render( ) { 
	$option = get_option( 'kpe_indexing_settings' );
?>
<input type="number" id="posts_per_keyphrase" name="kpe_indexing_settings[posts_per_keyphrase]" value="<?php echo $option['posts_per_keyphrase']; ?>" />
<?php
	echo '<p>Display keyphrases only if they appear in minimum of X (e.g. 2) posts.</p>';
}

/* Callbacks */
function kpe_indexing_section_callback(  ) { 
	echo __( 'Using this page, you can index all posts of your site with only one click.', 'kpe' );
}
function kpe_indexing_settings_section_callback(  ) { 
	echo __( '', 'kpe' );
}


/*
 * Create the page and display the settings
 */
function kpe_settings(  ) {
	$plugin_data = get_plugin_data( dirname(plugin_dir_path(__DIR__)) . '/tagbot.php', false, false ); 
	?>
<div id="kpe-settings">
	<div class="top-bar">
		<h3>
			<?php echo __('TagBot - Settings', 'kpe'); ?>
			<span class="kpe-version">
				<?php echo __('Version: ' . $plugin_data['Version'], 'kpe'); ?>
				<a href="#kpe-options" data-uk-modal><i class="fa fa-cog"></i></a>
			</span> 
		</h3>
	</div>
	
	<div id="kpe-options" class="uk-modal">
		<div class="uk-modal-dialog">
			<h3>
				<?php echo __('TagBot - Options', 'kpe'); ?>
				<a class="uk-modal-close uk-close"></a>
			</h3>
			<form action="options.php" method='post'>
				<?php
					settings_fields( 'kpeIndexingSettings' );
					do_settings_sections( 'kpeIndexingSettings' );
					submit_button();
				?>
			</form>
		</div>
	</div>
	
	<form action="options.php" method='post'>
		<?php
			$other_attributes = array( 
				'data-message' => 'Message',
				'data-pos' => 'bottom-right',
			);
			settings_fields( 'kpeIndexing' );
			do_settings_sections( 'kpeIndexing' );
		?>
		<p class="submit">
			<?php
				submit_button('Index Posts', '', 'kpe_indexing', '', $other_attributes);
			?>
		</p>
	</form>
</div>
<?php
}

?>