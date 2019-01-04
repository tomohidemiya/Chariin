<?php


    function deposit_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// Input Configuration
		$post_req = $request["POST"];
		
		$payjp_token = $post_req["token"];
		$email = $post_req["email"];
		$depo_type = $post_req["deposit_type"];
		$total_price = (int)$post_req["price"];
		$hash_key = $post_req["hash_key"];
		$user_id = $post_req["user_id"];
		$is_prod = false;

		if ( $post_req["prod_mode"] !== '' && $post_req["prod_mode"] === 'true' ) {
			$is_prod = true;
		}
		if ( $post_req["user_id"] !== '' ) {
			// $user_id からEmailAddress取ってくる？
		}

		$response = new WP_REST_Response();
		try {

			// TODO: ハッシュ値の検証する

			$payjp_util = new A4N_PAY_Payjp_Util();
			if ($is_prod) {
				// FIXME なぜか必ず200が帰る。。。
				$ch = $payjp_util->deposit_payment( $payjp_token, $total_price, $depo_type );
			} else {
				$ch = $payjp_util->test_communicate_to_payjp();
			}

			if ($ch['error'] !== '' ) {
				throw new Exception($ch['error']['message']);
			}

			$response->set_status(200);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			
			// TODO: Future Function: Async対応
			$mailUtil = new A4N_C_MailUtil();
			$mailUtil->send_mail_sync('deposit', $email);
			
			// TODO: 適切な内容に変える
			$response->set_data( a4n_create_res_data_deposit( $ch, True ) );
		} catch( Exception $e ) {
			$response->set_status(500);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			$response->set_data( a4n_create_res_data_deposit( $e->getMessage(), False ) );
		} finally {

		}
		return $response;
	}

	function a4n_create_res_data_deposit( $ch, $status ) {
		$status_str = '';
		if ( $status == True ) {
			$status_str = 'success';
		} else {
			$status_str = 'fail';
		}
		$data = array(
			'status' => $status_str,
			'pay' =>  $ch
		);
		return $data;
	}