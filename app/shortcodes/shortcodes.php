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
// <<<EOD
// <script
//         type="text/javascript"
//         src="https://checkout.pay.jp/"
//         class="payjp-button"
//         data-key="pk_test_0383a1b8f91e8a6e3ea0e2a9"
//         data-on-created="onCreated"
//         data-text="カード情報の入力"
//         data-submit-text="支払う"
//         data-on-created="onCreated"
//         data-partial="true">
//     </script>
//     <span id="token"></span>
//     <input type="hidden" name="email" value="">
//     <input type="hidden" name="userid" value="">
//     <input type="hidden" name="testmode" value="">
// EOD;
<<<EOD
<head>
  <meta charset="utf-8">
  <meta content="width=device-width,initial-scale=1.0" name="viewport">
  <title></title>
  <script type="text/javascript" src="https://js.pay.jp/"></script>

  <style media="screen">
    section {
      margin: 15px;
      max-width: 960px;
    }
  </style>
</head>
<body>
  <section>
    <form class="ui form" id="charge-form">
    <span class="charge-errors"></span>      
      <div class="fields">
      <h4>支払い</h4>
        <label>カード番号</label>
        <input type="text" class="number" name="number" maxlength="16" placeholder="カード番号">

        <label>CVC</label>
        <input type="text" class="cvc" name="cvc" maxlength="3" placeholder="CVC">

        <label>有効期限</label>
        <input type="text" class="exp_month" name="exp_month" maxlength="2" placeholder="月">
        <input type="text" class="exp_year" name="exp_year" maxlength="4" placeholder="年">
      </div>
      <button class="ui primary button submit">
        送信
      </button>
      <p id="result"></p>
    </form>
  </section>
</body>
EOD;
  return $str;
}
add_shortcode( "checkout" , "checkout_form_short_code" );

function a4n_form_script() {
    // 変数にする
    wp_enqueue_script(
        'custom-script',
        plugins_url( 'Chariin', 'Chariin' ) . '/app/shortcodes/scripts/main.js',
        array( 'jquery' ),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'a4n_form_script' );
