<?php
/**
 * Uninstall the Query AJAX translation plugin.
 *
 * This will remove the options from the database.
 * 
 */
if ( plugin_basename('jquery-ajax-translation/jquerytranslation.php') == WP_UNINSTALL_PLUGIN ) { // 
	require_once("jquerytranslation.php");
	$JqueryTranslation->uninstall(); // delete options from wp_options table
}
