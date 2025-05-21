<?php

namespace App\Http\Controllers\Common;

use Exception;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class CommonMailer
{
    public function setSmtpDriver($config)
    {
        try {
            if (!$config) {
                return false;
            }
            $transport = new EsmtpTransport($config['host'], $config['port']);

            $username = isset($config['username']) && $config['username'] !== null ? $config['username'] : '';
            $passowrd = isset($config['password']) && $config['password'] !== null ? $config['password'] : '';

            $transport->setUsername($username);
            $transport->setPassword($passowrd);

            // Set the mailer
            \Mail::setSymfonyTransport($transport);

            return true;
        } catch (Exception $e) {
            loging('mail-config', $e->getMessage());

            return $e->getMessage();
        }
    }

    public function setMailGunDriver($config)
    {
        if (!$config) {
            return false;
        }

        return true;
    }
}
