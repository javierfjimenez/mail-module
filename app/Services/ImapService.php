<?php

namespace App\Services;

use Webklex\IMAP\Facades\Client;

class ImapService
{
    /**
     * The IMAP client instance.
     */
    protected $client;

    /**
     * The folder instance.
     */
    protected $folder;

    /**
     * Create a new ImapService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = Client::account('default');
        $this->client->connect();
        $this->folder = $this->client->getFolder('INBOX');
    }

    /**
     * Get the unseen emails.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUnseenEmails()
    {
        return $this->getEmailsByStatus('unseen');
    }

    /**
     * Get the seen emails.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSeenEmails()
    {
        return $this->getEmailsByStatus('seen');
    }

    /**
     * Get the sent emails.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSentEmails()
    {
        return $this->getEmailsByStatus('seen'); // Assuming sent emails are marked as seen
    }

    /**
     * Get the deleted emails.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDeletedEmails()
    {
        return $this->getEmailsByStatus('deleted');
    }

    /**
     * Get an email by its UID.
     *
     * @param string $uid
     */
    public function getEmailByUid($uid)
    {
        return $this->folder->query()->getMessageByUid($uid);
    }

    /**
     * Get the count of emails by status.
     *
     * @return array
     */
    public function getEmailCount()
    {
        return [
            'total' => $this->getEmailCountByStatus(),
            'unseen' => $this->getEmailCountByStatus('unseen'),
            'seen' => $this->getEmailCountByStatus('seen'),
            'deleted' => $this->getEmailCountByStatus('deleted'),
            'draft' => 0, // Assuming there are no drafts in the INBOX
        ];
    }

    /**
     * Get emails by status.
     *
     * @param string|null $status
     * @return \Illuminate\Support\Collection
     */
    protected function getEmailsByStatus($status = null)
    {
        $query = $this->folder->query()->limit(100);
        if ($status) {
            $query->$status();
        }
        return $query->get();
    }

    /**
     * Get email count by status.
     *
     * @param string|null $status
     * @return int
     */
    protected function getEmailCountByStatus($status = null)
    {
        $query = $this->folder->query();
        if ($status) {
            $query->$status();
        }
        return $query->count();
    }
}

// <?php

// namespace App\Services;

// use Webklex\IMAP\Facades\Client;

// class ImapService
// {
//     /**
//      * The IMAP client instance.
//      *
//      * @var \Webklex\IMAP\Client
//      */
//     protected $client;

//     /**
//      * The folder instance.
//      *
//      * @var \Webklex\IMAP\Folder
//      */
//     protected $folder;

//     /**
//      * Create a new ImapService instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->client = Client::account('default');
//         $this->client->connect();
//         $this->folder = $this->client->getFolder('INBOX');
//     }

//     /**
//      * Get emails by status.
//      *
//      * @param string|null $status
//      * @return \Illuminate\Support\Collection
//      */
//     public function getEmails($status = null)
//     {
//         $query = $this->folder->query()->limit(100);

//         if ($status) {
//             $query->$status();
//         }

//         return $query->get();
//     }

//     /**
//      * Get an email by its UID.
//      *
//      * @param string $uid
//      * @return \Webklex\IMAP\Message|null
//      */
//     public function getEmailByUid($uid)
//     {
//         return $this->folder->getMessage($uid);
//     }

//     /**
//      * Get email count by status.
//      *
//      * @param string|null $status
//      * @return int
//      */
//     public function getEmailCount($status = null)
//     {
//         $query = $this->folder->query();

//         if ($status) {
//             $query->$status();
//         }

//         return $query->count();
//     }
// }

