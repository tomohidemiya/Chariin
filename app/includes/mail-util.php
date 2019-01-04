<?php
class A4N_C_MailUtil {

    private $mail_confirm;
    private $mail_deposit;

    public function __constructor() {
        //the_postでデータロード
        
        $mail_confirm = new A4n_Mail();
        $mail_deposit = new A4n_Mail();
    }

    public function initialise_mail_templates() {
        
    }

    public function update_mail_template($category, $from, $cc, $bcc, $subject, $body) {
        if( $category == 'deposit' ) {
            
        } elseif ( $category == 'confirm' ) {

        } else {
            return;
        }
        
        $args = array( 'post_type' => 'a4n_chariin' );
        $posts = get_posts( $args );

        // var_dump($posts);

        foreach($posts as &$post) {
            if ($post->post_name == $category) {
                
                $post_content = '{"a4n_from":"' . $from . '","a4n_cc":"' . $cc . '","a4n_bcc":"' . $bcc . '","a4n_subject":"' . $subject . '","a4n_mailbody":"' . $body . '"}';
                wp_update_post(
                    array(
                        'ID' => $post->ID,
                        'post_content' => $post_content
                    )
                );
            }
        }


    }

    public function insert_mail_template() {

    }

    public function reset_mail_template() {

    }

    public function send_mail_sync($category, $to, $replacer = array()) {
        $headers = array();

        $args = array( 'post_type' => 'a4n_chariin' );
        $posts = get_posts( $args );

        // var_dump($posts);

        $mail_content = json_decode($this->get_mail_template_from_category($category));
        
        $from = htmlspecialchars_decode( $mail_content->a4n_from );
        if ( $from !== '' ) {
            array_push($headers, 'From: ' . $from);
        }
        $ccs = explode( ';', htmlspecialchars_decode( $mail_content->a4n_cc ) );
        foreach($ccs as &$cc) {
            array_push($headers, 'Cc: ' . $cc);
        }
        $bccs = explode( ';', htmlspecialchars_decode( $mail_content->a4n_bcc ) );
        foreach($bccs as &$bcc) {
            array_push($headers, 'Bcc: ' . $bcc);
        }
        $subject = htmlspecialchars_decode( $mail_content->a4n_subject );
        $mail_body = preg_replace( '/<br[[:space:]]*\/?[[:space:]]*>/i', '\n', htmlspecialchars_decode( $mail_content->a4n_mailbody ) );

        // TODO: メール本文の置換処理

        wp_mail($to, $subject, $mail_body, $headers);
    }
    
    // Future function
    public function send_mail_async() {

    }

    public function check_enable_to_send_mail() {

    }

    public function get_mail_template_from_category($category) {
        if ( $category !== 'deposit' && $category !== 'confirm' ) {
            return null;
        }

        $args = array( 'post_type' => 'a4n_chariin' );
        $posts = get_posts( $args );

        foreach($posts as &$post) {
            if ($post->post_name == $category) {
                $subject = $post->post_title;
                $mail_content = $post->post_content;
            }
        }

        return $mail_content;
        
    }

    private function get_mail_template() {

    }
}