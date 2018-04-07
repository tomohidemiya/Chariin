<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function gp3_uninstall() {
	global $wpdb;

	delete_option( 'gp3_api_keys' );

}

gp3_uninstall();
