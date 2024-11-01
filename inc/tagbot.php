<?php
/*
 * TagBot plugin - Files
 * Include all required files
 */
defined('ABSPATH') or die;

/*
 * Core Files
 */
include_once dirname(plugin_dir_path(__FILE__)) . '/inc/config/tagbot-meta-fields.php';
include_once dirname(plugin_dir_path(__FILE__)) . '/inc/config/tagbot-functions.php';
include_once dirname(plugin_dir_path(__FILE__)) . '/inc/config/tagbot-enqueue-scripts.php';

/*
 * Admin Files
 */
include_once dirname(plugin_dir_path(__FILE__)) . '/inc/admin/options.php';

?>