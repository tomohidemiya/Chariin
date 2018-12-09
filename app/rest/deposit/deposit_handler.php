<?php


    function deposit_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// input configuration
		$post_req = $request["POST"];
		
		$payjp_token = $post_req["token"];
		$total_price = (int)$post_req["price"];
		$depo_type = $post_req["deposit_type"];
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
			$response->set_data( a4n_create_res_data_deposit( $user_id ) );

			// アーキテクチャを考える
			send_mail_deposit();

		} catch( Exception $e ) {
			$response->set_status(500);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			$response->set_data( a4n_create_res_data_deposit( $user_id ) );
		} finally {

		}
		return $response;
	}

	function a4n_create_res_data_deposit( $ch ) {
		$data = array(
			'pay' => array(
				'hoge' => $ch
			)
		);
		return json_encode($data);
	}

	function send_mail_deposit() {
		wp_mail( 't.miya19890131@gmail.com', '頑張れ', 'なんとかしろ' );
	}