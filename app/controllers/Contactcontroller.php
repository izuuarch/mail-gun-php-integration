<?php
namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use Exception;
use Mailgun\Mailgun;
class Contactcontroller extends Controller{
    public function index(){
        $this->view("contact");
    }
    public function send(Request $req){
        try{
            $to = $req->input("to");
            $subject = $req->input("subject");
            $text = $req->input("text");
            $mgClient = Mailgun::create(MAILGUNPRIVATEKEY, 'https://sandboxe6d005311aca4a07ad4ae940352105b2.mailgun.org');
    $domain = "http://localhost:3000";
    $params = array(
      'from'    => 'Excited User '.$domain.'',
      'to'      => $to,
      'subject' => $subject,
      'text'    => $text
    );
        }catch(Exception $e){
            $e->getMessage();
        }

# Make the call to the client.
$mgClient->messages()->send($domain, $params);
    }
}