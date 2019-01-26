<?php
function a4n_activate() {
    a4n_chariin_register_post_mail_type();
    a4n_chariin_register_option_keys();
    a4n_chariin_register_mail_template();
}

function a4n_chariin_register_post_mail_type() {
    register_post_type('a4n_chariin', array(
        'labels' => array(
            'name' => __( 'A4N Chariin', 'a4n-chariin' ),
            'singular_name' => __( 'A4N Chariin', 'a4n-chariin' ),
        ),
        'rewrite' => false,
        'query_var' => false,
        'public' => false,
        'capability_type' => 'page',
    ) );
}

function a4n_chariin_register_option_keys() {
    $api_keys = array(
        [ 'key_type' => '0', 'key_name' => '' ],
        [ 'key_type' => '1', 'key_name' => '' ],
        [ 'key_type' => '2', 'key_name' => '' ],
        [ 'key_type' => '3', 'key_name' => '' ]
    );
    update_option('a4n_pay_api_keys', $api_keys);
}

function a4n_chariin_register_mail_template() {
    $admin_user = wp_get_current_user();
    

    $from = '"a4n_from":"'. $admin_user->display_name .' <' . $admin_user->user_email . '>"';
    $cc = '"a4n_cc":"' . $admin_user->user_email . '"';
    $bcc = '"a4n_bcc":"' . $admin_user->user_email . '"'; 
    $mail_body = '"a4n_mailbody":"テストです"';
    
    
    $subject = '"a4n_subject":"【ご購入のお礼】"'; 
    $post_content = '{' . $from . ',' . $cc . ',' . $bcc . ',' . $subject . ',' . $mail_body . '}';
    $post_id_deposit = wp_insert_post( array(
        'post_type' => 'a4n_chariin',
        'post_name' => 'deposit',
        'post_status' => 'publish',
        'post_title' => '【ご購入のお礼】',
        'post_content' => trim( $post_content ),
    ) );

    $subject = '"a4n_subject":"【決済専用サイトのご案内】"'; 
    $post_content = '{' . $from . ',' . $cc . ',' . $bcc . ',' . $subject . ',' . $mail_body . '}';
    $post_id_confirm = wp_insert_post( array(
        'post_type' => 'a4n_chariin',
        'post_name' => 'confirm',
        'post_status' => 'publish',
        'post_title' => '【決済専用サイトのご案内】',
        'post_content' => trim( $post_content ),
    ) );
}

function normalize_newline_deep( $arr, $to = "\n" ) {
	if ( is_array( $arr ) ) {
		$result = array();

		foreach ( $arr as $key => $text ) {
			$result[$key] = wpcf7_normalize_newline_deep( $text, $to );
		}

		return $result;
	}

	return normalize_newline( $arr, $to );
}

function get_properties() {
    $properties = array();

    $properties = wp_parse_args( $properties, array(
        'form' => '',
        'mail' => array(),
        'mail_2' => array(),
        'messages' => array(),
        'additional_settings' => '',
    ) );

    $properties = (array) apply_filters( 'a4n_chariin_properties',
        $properties, $this );

    return $properties;
}