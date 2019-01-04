<?php
    
    function confirm_handler( WP_REST_Request $request ) {
		//何かしらの処理
		// input configuration
		$post_req = $request["POST"];
		$price = $post_req["price"];
		$depo_type = $post_req["deposit_type"];
		$email = $post_req["email"];
		$is_prod = false;

		if ( $post_req["prod_mode"] !== '' && $post_req["prod_mode"] === 'true' ) {
			$is_prod = true;
		}

		$response = new WP_REST_Response();
		try {
			
			$response->set_status(200);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			
			// アーキテクチャを考える
			$mail_util = new A4N_C_MailUtil();
			$mail_util->send_mail_sync('confirm', $email);
			
			// TODO 適切な内容に変える
			$response->set_data( a4n_create_res_data_payment( 'success', '' ) );
		} catch( Exception $e ) {
			$response->set_status(500);
			$domain = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"];
			$response->header( 'Location', $domain );
			$response->set_data( a4n_create_res_data_payment( 'fail', $e->getMessage() ) );
		} finally {

		}
		return $response;
	}

	function a4n_create_res_data_payment( $status, $message ) {
		$data = array(
			'confirm' => array(
				'status' => $status,
				'message' => $message
			)
		);
		return json_encode($data);
	}
