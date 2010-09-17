<?php

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'ES_tag_highlighter_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'ES_tag_highlighter_remove' );

function ES_tag_highlighter_install() {
/* Creates new database field */
add_option("selectpost", 'Default', '', 'yes');
add_option("selectpage", 'Default', '', 'yes');
}

function ES_tag_highlighter_remove() {
/* Deletes the database field */
delete_option('selectpost');
delete_option('selectpage');
}

?>
