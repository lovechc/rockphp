<?php

/**
 * 发送邮件示例
 * composer require phpmailer/phpmailer
 * "phpoffice/phpspreadsheet": "^6"
 */
class Mail
{
    /**
     * 发送邮件
     * @param array $sendTo
     * @param string $subject 邮件主题
     * @param string $body 邮件内容
     * @param array $attachment
     * @return bool
     * @throws Exception
     */
    public static function send(array $sendTo, string $subject, string $body, array $attachment = [])
    {
        $config = [
            'mail_smtp_host' => 'smtp.qq.com',
            'mail_smtp_user' => '894387026@qq.com',
            'mail_smtp_pass' => 'schylbqqgnhabfeh',
            'mail_smtp_port' => 25,
            'mail_from' => '894387026@qq.com',
        ];

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // 开启bug模式
            $mail->isSMTP();    // Send using SMTP
            $mail->Host = $config['mail_smtp_host'] ?? 'smtp.qq.com';
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $config['mail_smtp_user'] ?? '894387026@qq.com'; // SMTP username
            $mail->Password = $config['mail_smtp_pass'] ?? 'schylbqqgnhabfeh'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = $config['mail_smtp_port'] ?? 25; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->CharSet = "UTF-8";
            $mail->setLanguage('zh_cn');

            $from_address = $config['mail_from'] ?? '894387026@qq.com';
            $mail->setFrom($from_address); // 发件人邮箱地址

            foreach ($sendTo as $address) {
                $mail->addAddress($address);     // 收件人邮箱地址
            }

            // 添加附件，附件文件路径
            if (is_array($attachment)) {
//                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');
                foreach ($attachment as $item) {
                    $mail->addAttachment($item);
                }
            }

            $mail->isHTML(true);    // 开启html内容
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}