<?php
	 // 1. 通信時にauth-guard処理を入れる
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/includes/a4n_rest_auth_guard.php';
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/payment/payment_handler.php';
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/deposit/deposit_handler.php';

	// rest_api_init 時の関数登録
	add_action( 'rest_api_init', 'add_custom_endpoint' );
	function add_custom_endpoint() {
		register_rest_route( 'chariin/1', '/pay', $payment_route);
		register_rest_route('chariin/1', '/depo', $deposit_route);
	}
	
