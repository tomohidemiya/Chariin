<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function a4n_uninstall() {
	global $wpdb;

	$args = array( 'post_type' => 'a4n_chariin' );
	$posts = get_posts( $args );

	foreach ( $posts as $p ) {
		wp_delete_post($p->ID, true);
	}
	delete_option( 'a4n_pay_api_keys' );
	unregister_post_type('a4n_chariin');

}

a4n_uninstall();
