<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Group;
use App\Services\ImapService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The IMAP service instance.
     *
     * @var ImapService
     */
    protected $imapService;

    /**
     * The count of messages.
     *
     * @var int
     */
    protected $messagesCount;

    /**
     * The Contact model instance.
     *
     * @var Contact
     */
    protected $contactModel;

    /**
     * The Group model instance.
     *
     * @var Group
     */
    protected $groupModel;

    /**
     * Create a new controller instance.
     *
     * @param ImapService $imapService
     * @param Contact $contactModel
     * @param Group $groupModel
     * @return void
     */
    public function __construct(ImapService $imapService, Contact $contactModel, Group $groupModel)
    {
        $this->imapService = $imapService;
        $this->messagesCount = $this->imapService->getEmailCount();
        $this->contactModel = $contactModel;
        $this->groupModel = $groupModel;
    }
}
