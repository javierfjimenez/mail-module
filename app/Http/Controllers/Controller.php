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
    protected $imapService;
    protected $messagesCount;
    protected $contactModel;
    protected $groupModel;
    public function __construct(ImapService $imapService, Contact $contactModel, Group $groupModel)
    {
        $this->imapService = $imapService;
        $this->messagesCount = $this->imapService->getEmailCount();
        $this->contactModel = $contactModel;
        $this->groupModel = $groupModel;
    }
}
