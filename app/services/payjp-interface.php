<?php

/**
* Pay.jp utilities
*
*/
class A4N_PAY_Payjp_Util {
    public function test_communicate_to_payjp() {
        $test_key_name = $this->get_test_prv_key();
        // $user_email = '';
        // $user_name = '';
        // $user_id = get_current_user_id();

        // if (is_user_logged_in()) {
        //     $user = wp_get_current_user();
        //     // $user_email = $user->user_email;
        //     // $user_name = $user->user_login;
        //     $user_id = $user->ID;
        // }

        // $user_id = get_current_user_id();

        \Payjp\Payjp::setApiKey($test_key_name);
        try {
            // FIXME user_metadataにカスタマーIDなかったら、カスタマー登録する処理が入る予定
            // $wpdb =
            // $user_id = get_current_user_id();
            // if (user_mmetadata) {
            // }
            $myCard = array( 'number' => '4242424242424242', 'cvc' => '123', 'exp_month' => 5, 'exp_year' => 2020 );
            $charge = \Payjp\Charge::create( array(
                'card' => $myCard,
                'amount' => 5000,
                'currency' => 'jpy',
                'capture' => false,
                'expiry_days' => 1,
                'description' => 1,
            ) );

            if ( $charge['card']['cvc_check'] !== 'passed' && $charge['card']['cvc_check'] !== 'unchecked' ) {
                return array( 'error' => array( 'code' => 'invalid_cvc', 'message' => 'セキュリティコードが確認できませんでした。再度ご確認下さい' ) );
            }
            $ch = \Payjp\Charge::retrieve($charge['id']);
            $ch->capture();

        } catch(Exception $e) {
            // var_dump($e);
            return $e->jsonBody;
        }
        return $ch;
    }

    public function deposit_payment(string $token, int $total_price, string $depo_type) {
        $key_name = $this->get_prv_key();
        \Payjp\Payjp::setApiKey($key_name);

        try {
            $charge = \Payjp\Charge::create(array(
                'card' => $token,
                'amount' => $total_price,
                'currency' => 'jpy', // その内なおす
                'capture' => false,
                'expiry_days' => 1,
                'description' => $depo_type,
            ));
            $ch = \Payjp\Charge::retrieve($charge['id']);
            $ch->capture();
        } catch(Exception $e) {
            // var_dump($e);
            return $e->jsonBody;
        }

        return $ch;

    }


    public function create_pay(int $user_id, string $number, int $exp_month, int $exp_year, int $amount) {
        $key_name = $this->get_prv_key();

        \Payjp\Payjp::setApiKey($key_name);
        try {
            $payment_card = array('number' => $number, 'exp_month' => $exp_month, 'exp_year' => $exp_year);
            $charge = \Payjp\Charge::create(array(
                'card' => $payment_card,
                'amount' => $amount,
                'currency' => 'jpy',
                'capture' => false,
                'expiry_days' => 1,
                'description' => $user_id,
            ));
            if ( $charge['card']['cvc_check'] !== 'passed' ) {
                return array('error' => array('code' => 'invalid_cvc', 'message' => 'セキュリティコードが確認できませんでした。再度ご確認下さい'));
            }
            $ch = \Payjp\Charge::retrieve($charge['id']);
            $ch->capture();
        } catch(Exception $e) {
            // var_dump($e);
            return $e->jsonBody;
        }

        return $ch;
    }

    private function get_test_prv_key() {
        $a4n_pay_api_keys = get_option('a4n_pay_api_keys');
        $test_key_name = array_values( array_filter( $a4n_pay_api_keys, function( $item ) {
            return '0' == $item[ 'key_type' ];
        } ) )[0]['key_name'];
        return $test_key_name;
    }

    private function get_test_pub_key() {
        $a4n_pay_api_keys = get_option('a4n_pay_api_keys');
        $test_key_name = array_values( array_filter( $a4n_pay_api_keys, function( $item ) {
            return '1' == $item[ 'key_type' ];
        } ) )[0]['key_name'];
        return $test_key_name;
    }

    private function get_prv_key() {
        $a4n_pay_api_keys = get_option('a4n_pay_api_keys');
        $test_key_name = array_values( array_filter( $a4n_pay_api_keys, function( $item ) {
            return '2' == $item[ 'key_type' ];
        } ) )[0]['key_name'];
        return $test_key_name;
    }

    private function get_pub_key() {
        $a4n_pay_api_keys = get_option('a4n_pay_api_keys');
        $test_key_name = array_values( array_filter( $a4n_pay_api_keys, function( $item ) {
            return '3' == $item[ 'key_type' ];
        } ) )[0]['key_name'];
        return $test_key_name;
    }

    private function convert_err_message_jp(string $code) {
        $err_jp = '';
        switch( $code ) {
            case 'invalid_number':
                $err_jp = 'カード番号が正しくありません。';
                break;
            case 'invalid_expiry_year':
                $err_jp = '有効期限がただしくありません。';
                break;

        }
        return $err_jp;
    }

    private function create_customer_for_payjp() {

    }
}
