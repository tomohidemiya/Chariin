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

}

function a4n_chariin_register_mail_template() {
    $post_content = 'テストです';

    $post_id_deposit = wp_insert_post( array(
        'post_type' => 'a4n_chariin',
        'post_status' => 'publish',
        'post_title' => '【ご購入のお礼】',
        'post_content' => trim( $post_content ),
    ) );

    $post_id_confirm = wp_insert_post( array(
        'post_type' => 'a4n_chariin',
        'post_status' => 'publish',
        'post_title' => '【決済サイトのご案内】',
        'post_content' => trim( $post_content ),
    ) );
    
    $props = get_properties();

    foreach ( $props as $prop => $value ) {
        update_post_meta( $post_id_deposit, '_' . $prop,
            normalize_newline_deep( $value ) );
    }
    update_post_meta( $post_id, '_locale', get_user_locale() );
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