<?php
namespace Lily\Core;
require_once CORE_PATH . DS . 'phpmailer' . DS . 'class.smtp.php';
require_once CORE_PATH . DS . 'phpmailer' . DS . 'class.phpmailer.php';

class Mailer
{
    public static function notify($email, $subject, $content) {

        $from = 'no-reply@me.com';
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASS;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = EMAIL_PORT;

        $mail->CharSet = 'UTF-8';
        $mail->From = $from;
        $mail->FromName = APP_HEADER_TITLE;
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body
            = '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
            </head>
            <body>
            <table style="width:100%;direction:rtl !important;">
                <tr>
                    <td style="border-bottom: solid 1px #e4e4e4;">
                        <h1 style="font-size: 1.5em;color:#f2652a;margin: 0 0 15px 0;direction:rtl;">' . $subject . '</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;background: #f1f1f1;">
                        <p style="font-size:1em;color:#333;padding:0;margin:15px 0 0 0;direction:rtl;">' .
                        $content
                        . '</p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#f2652a;padding: 10px;">
                        <p style="font-size:1em;color:#FFF;text-align:center;padding:0;margin:0">هذه الرسالة رسالة تلقائية من النظام و لا يجب الرد عليها</p>
                    </td>
                </tr>
            </table>
            </body>
            </html>';
        if ($mail->send()) {
            return true;
        }
        return false;
    }
}