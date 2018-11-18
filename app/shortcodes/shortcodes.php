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