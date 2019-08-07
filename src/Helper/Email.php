<?php

namespace App\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Entity\Eav\EavAttributesOption;
use Symfony\Component\Dotenv\Dotenv;

class Email
{
    public function __construct() {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');
    }

    public function sendHello($user, $em) {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = 2; // W razie wystąpienia błędów ustawić wartość 2, a logi pokażą się w body response
            $mail->isSMTP();
            $mail->Host = getenv('PHPMAILER_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('PHPMAILER_USERNAME');
            $mail->Password = getenv('PHPMAILER_PASSWORD');
            $mail->SMTPSecure = getenv('PHPMAILER_SMTPSECURE');
            $mail->Port = getenv('PHPMAILER_PORT');
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->setFrom(getenv('PHPMAILER_FROM_EMAIL'), getenv('PHPMAILER_FROM_NAME'));
            $mail->addAddress(reset($user)['email'], reset($user)['firstname'].' '.reset($user)['lastname']);
            $mail->isHTML(true);
            $mail->Subject = 'Dziękujemy za rejestrację';
            $mail->Body    = $this->sayHello($user, $em);
            $mail->CharSet = 'UTF-8';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function sayHello($user, $em) {
        $user = $user[0];
        $html = "<p>Witaj ".$user['firstname'].",</p>
                <p>dziękujemy za rejestrację w aplikacji stworzonej na potrzeby rekrutacji do firmy WIP!</p>
                <p>Oto Twoje dane:</p>";
        $html .= "<table border=\"1\">";
        $html .= "<tr><td>Imię</td><td>".$user['firstname']."</td></tr>";
        $html .= "<tr><td>Nazwisko</td><td>".$user['lastname']."</td></tr>";
        $html .= "<tr><td>Email</td><td>".$user['email']."</td></tr>";
        $html .= "<tr><td>Opis</td><td>".$user['description']."</td></tr>";
        foreach($user['attributes'] as $attribute) {
            switch($attribute['type'])
            {
                case 'select':
                    $result = $em->getRepository(EavAttributesOption::class)->findOneById($attribute['value']);
                    if($result) {
                        $html .= "<tr><td>".$attribute['label']."</td><td>".$result->getValue()."</td></tr>";
                    }
                    break;
                case 'checkbox':
                    $html .= "<tr><td>".$attribute['label']."</td><td>".$this->getCheckbox($attribute['value'])."</td></tr>";
                    break;
                default:
                    $html .= "<tr><td>".$attribute['label']."</td><td>".$attribute['value']."</td></tr>";
                    break;
            }
        }
        $html .= "</table>";
        $html .= "<p>Pozdrawiamy</p>";

        return $html;
    }

    public function getCheckbox($value) {
        if($value == 1) {
            return "Tak";
        }

        return "Nie";
    }
}