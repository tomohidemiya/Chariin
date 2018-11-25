<?php
class A4n_Mail {
    private $subject;
    private $description = '';
    private $to = [];
    private $cc = [];
    private $bcc = [];

    public function __constructor() {

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

    public function setDescription($description)
    {
        if(is_null($description) || $description == '') {
            return;
        }
        $this->$description = htmlspecialchars($description);
    }


    public function getDescription() {
        return $this->$description;
    }

}