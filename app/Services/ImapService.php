<?php

namespace App\Services;

use Webklex\IMAP\Facades\Client;

class ImapService
{
    protected $client;
    protected $folder;

    public function __construct()
    {
        $this->client = Client::account('default');
        $this->client->connect();
        $this->folder = $this->client->getFolder('INBOX');
    }

    public function getUnseenEmails()
    {
        return $this->folder->query()->limit(100)->unseen()->get();
    }
    public function getSeenEmails()
    {
        return $this->folder->query()->limit(100)->seen()->get();
    }

    public function getSentEmails()
    {
        return $this->folder->query()->limit(100)->seen()->get();
    }
    public function getDeletedEmails()
    {
        return $this->folder->query()->limit(100)->unseen()->get();
    }
    public function getEmailByUid($uid)
    {
        return $this->folder->query()->limit(100)->getMessageByUid($uid);
    }

    public function getEmailCount()
    {
        return [
            'total' => $this->folder->query()->count(),
            'unseen' => $this->folder->query()->unseen()->count(),
            'seen' => $this->folder->query()->seen()->count(),
            'deleted' => $this->folder->query()->deleted()->count(),
            'draft' => 0,
        ];
    }
}
