<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailing_Class {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
    }

    public function sendCustomEmail($fromEmail, $to, $subject, $message, $attachments = array(), $replyToName = '') {
        try {
            $this->configureMailer();

            $fromName = 'MailCholage';
            $this->mailer->setFrom($fromEmail, $fromName);

            foreach ($to as $recipient) {
                $this->mailer->addAddress($recipient);
            }

            $this->mailer->Subject = $subject;
            $this->mailer->Body = $message;
            $this->mailer->isHTML(true);

            // Vérifier si des pièces jointes ont été envoyées et les attacher à l'e-mail
            if (!empty($attachments['tmp_name'])) {
                foreach ($attachments['tmp_name'] as $index => $tmpName) {
                    $this->mailer->addAttachment($tmpName, $attachments['name'][$index]);
                }
            }

            // Envoyer l'e-mail
            if ($this->mailer->send()) {
                return true;
            } else {
                return 'L\'email n\'a pas pu être envoyé.';
            }
        } catch (Exception $e) {
            return 'Erreur lors de l\'envoi de l\'email : ' . $this->mailer->ErrorInfo;
        }
    }


    public function getAvailableEmails(){
        require_once('../Model/DatabaseConnection.php');

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT mail FROM users WHERE cotisation = 1");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function configureMailer() {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'cholagemail@gmail.com';
        $this->mailer->Password = 'gtoo xgvw gnnd otqq';
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = 587;
        $this->mailer->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }
}