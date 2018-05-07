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
				'user_id' => [
					'required' => true,
					'description' => 'ユーザID',
					'validation_callback' => function( $var ) {
						return ! empty( $var ) && ctype_digit( $var );
					},
				],
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
					'required' => true,
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
				'prod_mode'=> [
					'required' => false,
					'description' => 'テストモード',
				]
			],
		) );
	}
	function payment_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// input configuration
		$post_req = $request["POST"];
		$user_id = (int)$post_req["c_number"];
		$card_num = $post_req["c_number"];
		$card_exp_year = (int)$post_req["exp_year"];
		$card_exp_month = (int)$post_req["exp_month"];
		$card_cvc = (int)$post_req["cvc"];
		$amount = (int)$post_req["amount"];
		$card_name = $post_req["name"];
		$is_prod = false;

		if ( $post_req["prod_mode"] !== '' && $post_req["prod_mode"] === 'true' ) {
			$is_prod = true;
		}

		$payjp_util = new GP3_Payjp_Util();
		if ($is_prod) {
			$ch = $payjp_util->create_pay($number, $card_exp_month, $card_exp_year, $amount);
		} else {
			$ch = $payjp_util->test_communicate_to_payjp();
		}

		$response = new WP_REST_Response();
		$response->set_status(200);
		$domain = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"];
		$response->header( 'Location', $domain );

		$response->set_data(gp4_create_res_data($user_id));
		send_mail();
		return $response;
	}

	function gp4_create_res_data($ch) {
		$data = array(
			'pay' => array(
				'hoge' => $ch
			)
		);
		return $data;
	}

	function send_mail() {
		wp_mail( 't.miya19890131@gmail.com', '頑張れ', 'なんとかしろ' );
	}
