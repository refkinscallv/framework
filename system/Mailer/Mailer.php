<?php

    namespace FW\Mailer;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Mailer {

        private PHPMailer $mail;

        public function __construct() {
            $this->mail = new PHPMailer(true);
        }

        public function send(array $args = []): array {
            if (empty($args)) {
                return ["status" => false, "message" => "Mailer arguments cannot be empty."];
            }

            try {
                // Server settings
                $this->mail->SMTPDebug = !empty($_SERVER["MAIL_DEBUG"]) ? SMTP::DEBUG_SERVER : 0;
                $this->mail->isSMTP();
                $this->mail->Host = $_SERVER["MAIL_HOST"] ?? throw new Exception("MAIL_HOST is not set.");
                $this->mail->SMTPAuth = true;
                $this->mail->Username = $_SERVER["MAIL_USER"] ?? throw new Exception("MAIL_USER is not set.");
                $this->mail->Password = $_SERVER["MAIL_PASS"] ?? throw new Exception("MAIL_PASS is not set.");
                $this->mail->SMTPSecure = !empty($_SERVER["MAIL_SSL"]) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port = !empty($_SERVER["MAIL_SSL"]) ? 465 : 587;
    
                // Recipients
                $this->mail->setFrom($_SERVER["MAIL_USER"], $_SERVER["MAIL_NAME"] ?? 'No Name');
                $this->mail->addAddress($args["email"], $args["name"] ?? '');
    
                if (!empty($args["replyTo"])) {
                    $this->mail->addReplyTo($args["replyTo"]["email"], $args["replyTo"]["name"] ?? '');
                }
    
                if (!empty($args["cc"])) {
                    foreach ($args["cc"] as $cc) {
                        $this->mail->addCC($cc["email"], $cc["name"] ?? '');
                    }
                }
    
                if (!empty($args["bcc"])) {
                    foreach ($args["bcc"] as $bcc) {
                        $this->mail->addBCC($bcc["email"], $bcc["name"] ?? '');
                    }
                }
    
                // Attachments
                if (!empty($args["attachments"])) {
                    foreach ($args["attachments"] as $attachment) {
                        $this->mail->addAttachment($attachment["path"], $attachment["name"] ?? '');
                    }
                }
    
                // Content
                $this->mail->isHTML(true);
                $this->mail->Subject = $args["subject"];
                $this->mail->Body = $args["body"];
                $this->mail->AltBody = $args["altBody"] ?? strip_tags($args["body"]);
    
                $this->mail->send();

                return ["status" => true, "message" => "Email sent successfully."];
            } catch (Exception $e) {
                return ["status" => false, "message" => $e->getMessage()];
            }
        }

    }