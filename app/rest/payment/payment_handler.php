<?php
    $payment_route = [
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
    ];


    function payment_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// input configuration
		$post_req = $request["POST"];
		$user_id = (int)$post_req["user_id"];
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

		$response = new WP_REST_Response();
		try {
			$payjp_util = new A4N_PAY_Payjp_Util();
			if ($is_prod) {
				// FIXME なぜか必ず200が帰る。。。
				$ch = $payjp_util->create_pay( $number, $card_exp_month, $card_exp_year, $amount );
			} else {
				$ch = $payjp_util->test_communicate_to_payjp();
			}
			$response->set_status(200);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			// TODO 適切な内容に変える
			$response->set_data( gp4_create_res_data( $user_id ) );

			// アーキテクチャを考える
			send_mail();

		} catch( Exception $e ) {
			$response->set_status(500);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			$response->set_data( gp4_create_res_data( $user_id ) );
		} finally {

		}
		return $response;
	}

	function gp4_create_res_data( $ch ) {
		$data = array(
			'pay' => array(
				'hoge' => $ch
			)
		);
		return json_encode($data);
	}

    // FIXME!! 多分消す
	function send_mail() {
		wp_mail( 't.miya19890131@gmail.com', '頑張れ', 'なんとかしろ' );
	}