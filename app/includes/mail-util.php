<?php
// TODO: 作る
class A4N_C_MailUtil {

    private $mail_confirm;
    private $mail_deposit;

    public function __constructor() {
        $mail_confirm = new A4n_Mail();
        $mail_deposit = new A4n_Mail();

        //the_postでデータロード

    }

    public function initialise_mail_templates() {
        
    }

    public function update_mail_template($category, $from, $cc, $bcc, $subject, $body) {
        if( $category == 'deposit' ) {

        } elseif ( $category == 'confirm' ) {

        } else {
            return;
        }
    }

    public function insert_mail_template() {

    }

    public function reset_mail_template() {

    }

    public function send_mail_sync($category, $to) {

    }
    
    // Future function
    public function send_mail_async() {

    }

    public function check_enable_to_send_mail() {

    }

    private function get_mail_template() {

    }
}