<?php
function gp4_form_short_code( $args ) {
    $prod_mode = 'false';
    if ( $args['prod'] !== '' && strtolower( $args['prod'] ) == 'true') {
        $prod_mode = 'true';
    }
    return '<div class="gp4_pay"><form action="" id="gp4-pay-form" class="gp4_payment">
            <p class="gp4_cardnumber_row"><label class="gp4_cardnumber_row__label">カード番号：</label><input type="text" id="gp4-c-number" name="c_number" class="gp4_cardnumber_row__input"></p>
            <p class="gp4_exp_row"><label class="gp4_exp_row__label">有効期限：</label><input type="text" id="gp4-exp-year" name="exp_year" class="gp4_exp_row__input--year"><span> / </span><input type="text" id="gp4-exp-month" name="exp_month" class="gp4_exp_row__input--month"></p>
            <p class="gp4_cvc_row"><label class="gp4_cvc_row__label">セキュリティキー：</label><input type="text" id="gp4-cvc" name="cvc" class="gp4_cvc_row__input"></p>
            <p class="gp4_name_row"><label class="gp4_name_row__label">カード名義人：</label><input type="text" id="gp4-name" name="name" class="gp4_name_row__input"></p>


            <p class="gp4_amount_row"><label class="gp4_amount_row__label">料金：</label><input type="text" id="gp4-amount" name="amount" class="gp4_amount_row__input"></p>
            <input type="hidden" name="test_mode" value="' . $prod_mode . '">
            <input type="hidden" name="user_id" value="' . get_current_user_id() . '">
            <input type="submit" id="gp4-form-button" value="送信" class="btn gp4_submit">
            </form><div id="gp4-pay-result"></div></div>';
}
add_shortcode( "gp4-form" , "gp4_form_short_code" );

function gp4_form_script() {

    wp_enqueue_script(
        'custom-script',
        plugins_url( 'gp-payment-for-payjp', 'gp-payment-for-payjp' ) . '/scripts/main.js',
        array( 'jquery' ),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'gp4_form_script' );
