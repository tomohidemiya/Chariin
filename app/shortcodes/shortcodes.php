<?php
function a4n_form_short_code( $args ) {
    $prod_mode = 'false';
    if ( $args['prod'] !== '' && strtolower( $args['prod'] ) == 'true') {
        $prod_mode = 'true';
    }

    return '<div class="a4n_pay">
                <div class="a4n_pay_select_howtopay" id="a4n_pay_select_howtopay">
                    <a href="#" id="a4n_pay_credit">クレジットカードで決済する</a>
                    <a href="#" id="a4n_pay_depositment">銀行振込で決済する</a>
                </div>
                <form action="" id="a4n-pay-form" class="a4n_payment">
                    <input type="hidden" name="test_mode" value="' . $prod_mode . '">
                    <input type="hidden" name="user_id" value="' . get_current_user_id() . '">
                </form>
            </div>';
}
add_shortcode( "a4n-form" , "a4n_form_short_code" );


function checkout_form_short_code() {
  $str =
<<<EOD
<form action="/pay" method="post">
<script
type="text/javascript"
src="https://checkout.pay.jp/"
class="payjp-button"
data-key="pk_test_0383a1b8f91e8a6e3ea0e2a9"
data-on-created="onCreated"
data-text="カード情報の入力"
data-submit-text="支払う"
data-partial="true">
</script>
</form>
EOD;
  return $str;
}
add_shortcode( "checkout" , "checkout_form_short_code" );

function a4n_form_script() {


    // 変数にする
    wp_enqueue_script(
        'custom-script',
        plugins_url( 'gp-payment', 'gp-payment' ) . '/shortcode/scripts/main.js',
        array( 'jquery' ),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'a4n_form_script' );
