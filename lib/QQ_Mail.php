<?php
/**
 * Created by PhpStorm.
 * User: xiaochi.wang
 * Date: 2017/2/9
 * Time: 15:05
 */

namespace lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class QQ_Mail
{
    private $config;

    public $mail;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function send($receiver_list, $title, $content)
    {
        $username = $this->config['username'];
        $password = $this->config['password'];

        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $username;                 // SMTP username
        $mail->Password = $password;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom($username, 'Mailer');
        foreach ($receiver_list as $r) {
            $mail->addAddress($r);     // Add a recipient

        }
        $mail->addCC($username);

        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->AltBody = strip_tags($content);

        $this->mail = $mail;

        return $mail->send();
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}