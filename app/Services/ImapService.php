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
    public function getSeenEmails()
    {
        $folder = $this->client->getFolder('INBOX');
        return $folder->query()->seen()->get();
    }
    public function getDeletedEmails()
    {
        $folder = $this->client->getFolder('INBOX.deleted');
        return $folder->query()->unseen()->get();
    }
    public function getEmailByUid($uid)
    {
        $folder = $this->client->getFolder('INBOX');
        return $folder->query()->getMessageByUid($uid);
    }

    public function getEmailCount()
    {
        $folder = $this->client->getFolder('INBOX');
        return [
            'total' => $folder->query()->count(),
            'unseen' => $folder->query()->unseen()->count(),
            'seen' => $folder->query()->seen()->count(),
            'deleted' => $folder->query()->deleted()->count(),
            'draft' => 0,
        ];
    }
}
