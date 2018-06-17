<?php
	$deposit_route = [
		
	];

    function deposit_handler( WP_REST_Request $request ) {
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
			$payjp_util = new GP3_Payjp_Util();
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

	function send_mail() {
		wp_mail( 't.miya19890131@gmail.com', '頑張れ', 'なんとかしろ' );
	}