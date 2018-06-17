<?php
	 // 1. 通信時にauth-guard処理を入れる
	require_once GP3_PLUGIN_DIR . '/rest/includes/gp4_rest_auth_guard.php';
	require_once GP3_PLUGIN_DIR . '/rest/payment/payment_handler.php';
	require_once GP3_PLUGIN_DIR . '/rest/deposit/deposit_handler.php';

	// rest_api_init 時の関数登録
	add_action( 'rest_api_init', 'add_custom_endpoint' );
	function add_custom_endpoint() {
		register_rest_route( 'gpay/1', '/pay', $payment_route);
		register_rest_route('gpay/1', '/depo', $deposit_route);
	}
	
