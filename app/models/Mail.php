class Chrn_Mail {
    private $subject;
    private $description;
    private $to;
    private $cc;
    private $bcc;

    public function __constructor() {

    }

    setSubject($subject) {
        $this->$subject = $subject;
    }
}