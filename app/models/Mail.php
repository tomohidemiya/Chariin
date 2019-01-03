<?php
class A4n_Mail {
    private $subject;
    private $mail_body = '';
    private $to = [];
    private $cc = [];
    private $bcc = [];
    private $from = '';

    public function __constructor() {

    }

    public function setFrom($from) {
        $this->$from = htmlspecialchars($from);
    }

    public function getFrom() {
        return $this->$from;
    }

    public function setSubject($subject) {
        $this->$subject = htmlspecialchars($subject);
    }

    public function getSubject() {
        return $this->$subject;
    }

    public function addTo($to) {
        if(is_null($to) || $to == '') {
           return;
        }
        array_push($this->$to, htmlspecialchars($to));
    }

    public function getToArray() {
        if(is_array($this->$to)) {
            return $this->$to;
        } elseif (is_string($this)) {
            return [$this->$to];
        }
    }

    public function addCc($cc) {
        if(is_null($cc) || $cc == '') {
           return;
        }
        array_push($this->$cc, htmlspecialchars($cc));
    }

    public function getCcArray() {
        if(is_array($this->$cc)) {
            return $this->$cc;
        } elseif (is_string($this)) {
            return [$this->$cc];
        }
    }

    public function addBcc($bcc) {
        if(is_null($bcc) || $bcc == '') {
           return;
        }
        array_push($this->$bcc, htmlspecialchars($bcc));
    }

    public function getBccArray() {
        if(is_array($this->$bcc)) {
            return $this->$bcc;
        } elseif (is_string($this)) {
            return [$this->$bcc];
        }
    }

    public function setMailBody($mail_body) {
        if(is_null($mail_body) || $mail_body == '') {
            return;
        }
        $this->$mail_body = htmlspecialchars($mail_body);
    }


    public function getMailBody() {
        return $this->$mail_body;
    }

}