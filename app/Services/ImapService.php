<?php

namespace App\Services;

use Webklex\IMAP\Facades\Client;

class ImapService
{
    protected $client;

    public function __construct()
    {
        $this->client = Client::account('default');
        $this->client->connect();
    }

    public function getUnseenEmails()
    {
        $folder = $this->client->getFolder('INBOX');
        return $folder->query()->unseen()->get();
    }

    public function getEmailByUid($uid)
    {
        $folder = $this->client->getFolder('INBOX');
        return $folder->query()->getMessageByUid($uid);
    }
}
