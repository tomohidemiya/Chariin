<?php
	 // 1. 通信時にauth-guard処理を入れる
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/includes/a4n_rest_auth_guard.php';
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/confirm/confirm_handler.php';
	require_once A4N_PAY_PLUGIN_DIR . '/app/rest/deposit/deposit_handler.php';

	// rest_api_init 時の関数登録
	add_action( 'rest_api_init', 'add_custom_endpoint' );
	function add_custom_endpoint() {

        $confirm_route = [
            'methods' => 'POST',
            'callback' => 'confirm_handler',
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
        
        $deposit_route = [
            'methods' => 'POST',
            'callback' => 'deposit_handler',
            'args' => [
                'token'=> [
                    'required' => true,
                    'description' => 'PayJpのトークン'
                ],
                'email' => [
                    'required' => true,
                    'description' => 'メールアドレス'
                ],
                'deposit_type' => [
                    'required' => true,
                    'description' => '決済タイプ'
                ],
                'price'=> [
                    'required' => true,
                    'description' => '支払い金額',
                    'validation_callback' => function( $var ) {
                        return ! empty( $var ) && ctype_digit( $var );
                    },
                ],
                'hash_key' => [
                    'required' => false,
                    'description' => '改ざん防止用のハッシュ',
                ],
                'prod_mode' => [
                    'required' => false,
                    'description' => ''
                ],
                'user_id' => [
                    'required' => false,
                    'description' => ''
                ],
            ],
        ];

		register_rest_route( 'chariin/1', '/confirm', $confirm_route );
		register_rest_route( 'chariin/1', '/depo', $deposit_route );
	}

	
