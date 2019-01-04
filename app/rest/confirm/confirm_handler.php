<?php
    
    function confirm_handler( WP_REST_Request $request ) {
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
		$email = $post_req["email"];
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
			
			// アーキテクチャを考える
			$mailUtil = new A4N_C_MailUtil();
			$mailUtil->send_mail_sync('confirm', $email);
			
			// TODO 適切な内容に変える
			$response->set_data( a4n_create_res_data_payment( $user_id ) );
		} catch( Exception $e ) {
			$response->set_status(500);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			$response->set_data( a4n_create_res_data_payment( $user_id ) );
		} finally {

		}
		return $response;
	}

	function a4n_create_res_data_payment( $ch ) {
		$data = array(
			'pay' => array(
				'hoge' => $ch
			)
		);
		return json_encode($data);
	}
