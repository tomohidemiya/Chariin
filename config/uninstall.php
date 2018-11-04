<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function a4n_uninstall() {
	global $wpdb;

	delete_option( 'a4n_pay_api_keys' );

}

a4n_uninstall();
