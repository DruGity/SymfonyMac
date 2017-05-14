<?php

namespace MyShop\AdminBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailNotification 
{
	private $mailer;

	public function __construct($mailer)
    {
    		$this->mailer = $mailer; 
   	}

    public function sendEmail($mas, $email)
    {

        $message = new \Swift_Message();

        // $message->setTo("igorlessonhillel@gmail.com");
        $message->setTo($email);
        $message->addFrom("Unknow_Hacker-spamer@hillel.com");
        $message->setBody($mas , "text/html" );

        $this->mailer->send($message);
        
    }
}



