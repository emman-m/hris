<?php

namespace App\Libraries;

use Config\Services;

class SendMail
{
    protected $email;

    protected $setFrom = 'LCC Tanauan HRIS';

    public function __construct()
    {
        $this->email = Services::email();
    }

    public function setTo($sentTo)
    {
        $this->email->setTo($sentTo);

        return $this;
    }

    public function setSubject($subject)
    {
        $this->email->setSubject($subject);

        return $this;
    }

    public function setMessage($template, $data)
    {
        $this->email->setMessage(view('Templates/emails/' . $template, $data));

        return $this;
    }

    public function send()
    {
        $this->email->setFrom('magnomagz@gmail.com', $this->setFrom);
        if ($this->email->send()) {
            return true;
        }

        log_message('error', $this->email->printDebugger(['headers']));

        return false;
    }
}