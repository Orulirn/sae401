<?php
session_start();
include_once "../View/index.php";
include "../Model/Mailing_Class.php";

class ControllerMailing
{
    private $mailingModel;

    public function __construct()
    {
        $this->mailingModel = new Mailing_Class();
    }

    public function getEmailsForView()
    {
        return $this->mailingModel->getAvailableEmails();
    }

    public function processRequest()
    {
        $emails = $this->mailingModel->getAvailableEmails();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['selectedEmails']) && isset($_POST['emailContent'])) {
            $selectedEmails = json_decode($_POST['selectedEmails']);
            $emailContent = $_POST['emailContent'];
            $attachments = $_FILES['attachments'];

            $result = $this->mailingModel->sendCustomEmail(
                'lasae301test@gmail.com',
                $selectedEmails,
                'Sujet de l\'email',
                $emailContent,
                $attachments
            );

            if ($result === true) {
                echo 'Les e-mails ont été envoyés avec succès à tous les destinataires !';
            } else {
                echo 'Erreur lors de l\'envoi des e-mails : ' . $result;
            }
            include('../View/MailingView.php');
        }
    }
}

$controller = new ControllerMailing();
$controller->processRequest();
$emails = $controller->getEmailsForView();
include('../View/MailingView.php');
