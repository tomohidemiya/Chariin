<?php
	 // 1. 通信時にauth-guard処理を入れる
	require_once GP3_PLUGIN_DIR . '/rest/includes/gp4_rest_auth_guard.php';

	// rest_api_init 時の関数登録
	add_action( 'rest_api_init', 'add_custom_endpoint' );
	function add_custom_endpoint() {
		register_rest_route( 'gpay/1', '/pay', array(
			'methods' => 'POST',
			'callback' => 'payment_handler',
			// 'permission_callback' => function() {
			// 	return current_user_can( 'read' );
			// },
			// 2. input validation
			'args' => [
				'c_number' => [
					'required' => true,
					'description' => '12桁のカード番号',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var ) && strlen( $var ) === 12;
					},
				],
				'exp_year' => [
					'required' => true,
					'description' => '有効期限の年',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var );
					},
				],
				'exp_month' => [
					'required' => true,
					'description' => '有効期限の月',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var ) && (int)$var >= 1 && (int)$var <= 12;
					},
				],
				'cvc' => [
					'required' => true,
					'description' => 'カード裏面に記載の3桁か4桁のセキュリティチェックコード',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var ) && (strlen( $var ) === 3 || strlen( $var ) === 4 );
					},
				],
				'name' => [
					'required' => false,
					'description' => 'カード名義人。ローマ字',
					'validation_callback' => function( $var ) {
						return ctype_alpha( str_replace( ' ', '', $var ) );
					},
				],
				'amount'=> [
					'required' => true,
					'description' => '支払い金額',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var );
					},
				],
			],
		) );
	}
	function payment_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// input configuration
		$user_id = get_current_user_id();
		$post_req = $request["POST"];
		$card_num = $post_req["c_number"];
		$card_exp_year = (int)$post_req["exp_year"];
		$card_exp_month = (int)$post_req["exp_month"];
		$card_cvc = (int)$post_req["cvc"];
		$amount = (int)$post_req["amount"];
		$card_name = $post_req["name"];

		$payjp_util = new GP3_Payjp_Util();
		// if () {
		$ch = $payjp_util->test_communicate_to_payjp();
		// } else {
			// $ch = $payjp_util->create_pay($number, $card_exp_month, $card_exp_year, $amount);
		// }


		$response = new WP_REST_Response();
		$response->set_status(200);
		$domain = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"];
		$response->header( 'Location', $domain );
		$response->set_data($ch);
		return $response;
	}
