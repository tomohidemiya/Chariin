<?php
require_once GP3_PLUGIN_DIR . '/admin/pages/api_key_list.php';
// require_once GP3_PLUGIN_DIR . '/admin/pages/register_api_key.php';
require_once GP3_PLUGIN_DIR . '/includes/payjp-interface.php';

// 管理画面を表示している場合のみ実行します。
if( !is_admin() ) {
    return;
}

add_action( 'admin_menu', 'gp3_admin_menu' );
function gp3_admin_menu () {
    add_menu_page(
        __('Payment', 'my-custom-admin'),
        __('Payment', 'my-custom-admin'),
        'administrator',
        'my-custom-admin',
        'my_custom_admin'
     );

     add_submenu_page(
        'my-custom-admin',
        __('APIキーリスト', 'my-custom-admin'),
        __('APIキーリスト', 'my-custom-admin'),
        'manage_options',
        'gp3-key-list-menu',
        'gp3_key_list_menu'
     );

     add_submenu_page(
        'my-custom-admin',
        __('APIキー登録', 'my-custom-admin'),
        __('APIキー登録', 'my-custom-admin'),
        'manage_options',
        'my-sub-menu',
        'my_sub_menu'
     );
}
function my_custom_admin () {
    ?>
    <div class="wrap">
        <h2>GP Payment Plugin for Pay.jp</h2>
        <p>
            当プラグインはPay.jpでのクレジットカード決済をWordpressから行うためのプラグインです。<br>
            Pay.jpのAPIキー（公開鍵、秘密鍵）をWordpress内に保存することで、セキュアな決済環境を作ります。<br>
            決済履歴などの情報に関しては、<a href="https://pay.jp/login">Pay.jpの会員ページ</a>をご確認ください。
        </p>
        <div class="card">
	        <h2 class="title">Pay.jpメニュー</h2>
	        <ul>
                <li><a href="/wp-admin/admin.php?page=gp3-key-list-menu">APIキーリスト</a></li>
                <li><a href="/wp-admin/admin.php?page=my-sub-menu">APIキー登録</a></li>
            </ul>
        </div>
    </div>
    <?php
}

function my_sub_menu () {
    ?>
    <div class="wrap">
        <h2>APIキー登録</h2>
        <p>
            この管理メニューではAPIキーを登録し、Pay.jpにて決済をする上で認証を行うことができるようにします。<br>
            APIキーを登録するには、Pay.jpのマイページから下記の手順をご実施ください。<br>
            <ul>
                <ol>(1) マイページにログイン</ol>
                <ol>(2) 左側メニューのAPIを選択</ol>
                <ol>(3) 登録するAPIキーをコピー</ol>
                <ol>(4) 当管理メニューのフォームに入力</ol>
            </ul>
        </p>

        <div id="message" class="notice-info notice">
            <p><strong>ご注意ください！:</strong></p>
            <p>
                APIキーは最も高セキュリティな情報です。必ずHTTPS通信時でのみ登録してください。<br>
                この管理画面では、HTTP通信（HTTPSの高セキュリティ環境ではない通信）では情報を登録できません。<br><br>
                また、APIキーが登録されていない場合、決済機能は利用できません。
            </p>
        </div>
        <?php
            // add_options_page()で設定のサブメニューとして追加している場合は
            // 問題ありませんが、add_menu_page()で追加している場合
            // options-head.phpが読み込まれずメッセージが出ない(※)ため
            // メッセージが出るようにします。
            // ※ add_menu_page()の場合親ファイルがoptions-general.phpではない
            global $parent_file;
            if ( $parent_file != 'options-general.php' ) {
                require(ABSPATH . 'wp-admin/options-head.php');
            }
        ?>
        <form id="api_key_form" method="post" action="">
            <?php
                wp_nonce_field( 'my-nonce-key', 'my_sub_menu' );
                $registered_api_keys = get_option( 'gp3_api_keys' );
            ?>
            <table class="form-table">
                <tbody>
                    <tr class="form-field form-required">
                        <th scope="row"><label for="key_type">APIキーの種類 <span class="description">(必須)</span></label></th>
                        <td>
                            <select name="key_type" id="key_type" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
                                <option value=""></option>
                                <option value="0">テスト秘密鍵</option>
                                <option value="1">テスト公開鍵</option>
                                <option value="2">本番秘密鍵</option>
                                <option value="3">本番公開鍵</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><label for="key_name">APIキー名 <span class="description">(必須)</span></label></th>
                        <td><input name="key_name" type="text" id="key_name" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" style="width: 25em;"></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="create_api_key" id="create_api_key_btn" class="button button-primary" value="キー情報を更新">
                <input type="submit" name="test_api_key" id="test_api_key_btn" class="button button-info" value="APIキーをテスト">
            </p>
        </form>
    </div>
    <?php
}

add_action( 'admin_init', 'post_register_api_key_handler' );
function post_register_api_key_handler() {
    // var_dump($_POST);
    if ( isset( $_POST['create_api_key'] ) ) {
        post_api_key();
    } elseif( isset( $_POST['test_api_key'] ) ) {
        test_api_key();
    }
}

function test_api_key() {

    $payjp_util = new GP3_Payjp_Util();
    $res = $payjp_util->test_communicate_to_payjp();
    if ( isset($res['error']) ) {
        wp_die( $res['error']['message'] );
    } else {
        // FIXME テストがうまく行った時の処理を入れる
    }

}

function post_api_key() {

    // list とる
    $api_key_list = get_option( 'gp3_api_keys', array() );
    if ( isset( $_POST['my_sub_menu'] ) && $_POST['my_sub_menu'] ) {

        if ( check_admin_referer( 'my-nonce-key', 'my_sub_menu' ) ) {

            $e = new WP_Error();

            if ( $_POST['key_type'] == '0' || $_POST['key_type'] == '1' || $_POST['key_type'] == '2' || $_POST['key_type'] == '3' ) {

            } else {
                $e->add( 'error', 'APIキーの種類は、空欄以外を選択してください。' );
            }

            if ( isset($_POST['key_name']) && $_POST['key_name'] ) {

            } else {
                $e->add( 'error', 'APIキー名に値を入力してください。' );
            }

            if (count($e->errors) > 0) {
                set_transient( 'api_register_errors', $e -> get_error_messages(), 10 );
            } else {
                $input_array = array(
                    'key_type' => $_POST['key_type'],
                    'key_name' => $_POST['key_name'],
                );
                array_push( $api_key_list, $input_array );
                update_option( 'gp3_api_keys', $api_key_list, true );

                wp_safe_redirect( menu_page_url( 'gp3-key-list-menu', false ) );

            }
        }
    }
}

function validateRegisterKey() {
    $isValid = false;


    return $isValid;
}

add_action( 'admin_notices', 'add_error_notices' );
function add_error_notices() {
?>
    <?php if( $messages = get_transient( 'api_register_errors' ) ): ?>
    <div class="error">
        <ul>
            <?php foreach( $messages as $message): ?>
                <li><?php echo esc_html($message); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
<?php
}

function gp3_key_list_menu() {


    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">APIキーリスト</h1>
        <a href="/wp-admin/admin.php?page=my-sub-menu" class="page-title-action">新規追加</a>
        <p>
            現在登録されているAPIキーの一覧を表示しています。<br>
            APIキーの名称は厳重に管理すべきデータであるため、一部のみ表示しています。
        </p>
        <form method="post" id="bulk-action-form">

        <?php
            // todo prepare_itemsの引数
            $api_key_list = get_option( 'gp3_api_keys' );
            $gp3_api_key_list = new GP3_Api_Key_List_Table();
            $gp3_api_key_list->prepare_items( $api_key_list );
            $gp3_api_key_list->display();
        ?>
    </div>
    <?php

}

