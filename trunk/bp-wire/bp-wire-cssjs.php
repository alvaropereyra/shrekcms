<?php

function bp_wire_add_structure_css() {
	/* Enqueue the structure CSS file to give basic positional formatting for components */
	wp_enqueue_style( 'bp-wire-structure', BP_PLUGIN_URL . '/bp-wire/css/structure.css' );	
}
add_action( 'bp_styles', 'bp_wire_add_structure_css' );


?>