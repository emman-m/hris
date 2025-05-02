<?php

namespace App\Services;

use Config\Services;

class SendMail
{
    protected $email;

    protected $setFrom = 'LCC Tanauan HRMS';

    public function __construct()
    {
        $this->email = Services::email();
    }

    public function setTo($sentTo)
    {
        $this->email->setTo($sentTo);

        return $this;
    }

    public function setBcc($sentCc)
    {
        // $emails = $this->normalizeRecipient($sentCc);

        $this->email->BCCBatchMode = true;

        $this->email->setBCC($sentCc);

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
        if (getenv('email.mockEmail') === true) {
            return true;
        }

        $this->email->setFrom('magnomagz@gmail.com', $this->setFrom);
        if ($this->email->send()) {
            return true;
        }

        log_message('error', json_encode(['Email Error:' => $this->email->printDebugger(['headers'])]));

        return false;
    }

    protected function normalizeRecipient($recipient)
    {
        if (is_array($recipient)) {
            return implode(', ', $recipient);
        }

        return $recipient;
    }
}