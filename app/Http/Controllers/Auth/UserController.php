<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        // $pageConfigs = ['pageHeader' => false];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs]);
    }
    public function getUsers()
    {
        $users = User::select('name as full_name', 'email', 'status', 'id')->get();
        return response()->json($users);
    }
    public function getUserByID($id)
    {
        $user = User::select('name as full_name', 'email', 'id')->where('id', $id)->first();
        return response()->json($user);
    }
    public function userRemove(Request $request)
    {
        $user = User::where('id', $request->id)->update(['status' => 2]);
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {
        $user_id = $request->user_id ?? null;

        if (isset($user_id)) {
            $user = User::where('id', $user_id)->update(['name' => $request->name, 'email' => $request->email]);

            if (isset($request->password))
                User::where('id', $user_id)->update(['password' => $request->password]);

            return response()->json(['success' => true, 'user' => $user]);
        }
        /* 
        Validation
        */
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        return response()->json(['success' => true, 'user' => $user]);
    }
    // User List Page
    public function contactList()
    {
        // $pageConfigs = ['pageHeader' => false];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        return view('/content/apps/user/app-contact-list', ['pageConfigs' => $pageConfigs]);
    }

    public function getContacts()
    {
        $contacts = Contact::select('id', 'name as full_name', 'email', 'status')->get();
        return response()->json($contacts);
    }

    public function getContactByID($id)
    {

        $user = Contact::select('name as full_name', 'email', 'id')->where('id', $id)->first();
        return response()->json($user);
    }

    public function contactRemove(Request $request)
    {
        $user = Contact::where('id', $request->id)->update(['status' => 2]);
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactStore(Request $request)
    {
        $contact_id = $request->contact_id ?? null;

        if (isset($contact_id)) {
            $contact = Contact::where('id', $contact_id)->update(['name' => $request->name, 'email' => $request->email]);
            return response()->json(['success' => true, 'user' => $contact]);
        }
        /* 
        Validation
        */
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);
        /*
        Database Insert
        */
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json(['success' => true, 'contact' => $contact]);
    }
    // User List Page
    public function groupList()
    {
        $contacts = Contact::select('id', 'name', 'email')->get();
        $groups = Group::select('id', 'name', 'created_at')->get();
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        return view('/content/apps/user/app-contact-group-list', ['pageConfigs' => $pageConfigs, 'groups' => $groups, 'contacts' => $contacts]);
    }

    public function getGroups()
    {
        $users = Group::select('id', 'name as full_name', 'status')->get();
        return response()->json($users);
    }

    public function getGroupByID($id)
    {
        $group = Group::select('name as full_name', 'status', 'id')->where('id', $id)->first();
        $contacts = Contact::select('id')->where([['group_id', $id], ['status', 1]])->get();
        $groupContacts = [];
        foreach ($contacts as $value) {
            $groupContacts[] = $value->id;
        }

        $group->contacts = $groupContacts;
        return response()->json($group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function groupStore(Request $request)
    {
        $group_id = $request->group_id ?? null;

        if (isset($group_id)) {
            $group = Group::where('id', $group_id)->update(['name' => $request->name]);
            Contact::where('group_id', $group)->update(['group_id' => null]);
            foreach ($request->contact as $value) {
                Contact::where('id', $value)->update([
                    'group_id' => $group
                ]);
            }
            return response()->json(['success' => true, 'group' => $group]);
        }
        $request->validate([
            'name' => 'required|unique:groups',
        ]);

        $group = Group::create([
            'name' => $request->name
        ]);

        /*
        Database Insert
        */
        foreach ($request->contact as $value) {
            Contact::where('id', $value)->update([
                'group_id' => $group->id
            ]);
        }

        return response()->json(['success' => true, 'group' => $group]);
    }

    public function groupRemove(Request $request)
    {
        $user = Group::where('id', $request->id)->update(['status' => 2]);
        return response()->json($user);
    }

    // public function emailTemplate(Request $request)
    // {
    //    try {
    //     $template = new EmailTemplate();
    //     $template->name = 'actual_template';
    //     $template->template = $request->template ?? null;
    //     $template->save();
    //    } catch (\Throwable $th) {
    //     dd($th->getMessage());
    //    }
    //     return response()->json($template);
    // }

    // Quill Editor
    public function emailTemplate()
    {

        // $pageConfigs = ['pageHeader' => false];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        $emailTemplate = EmailTemplate::select('template')->first();
        // dd($emailTemplate->template);
        return view('/content/apps/user/app-email-template', ['pageConfigs' => $pageConfigs, 'emailTemplate' => $emailTemplate->template ?? null]);

        // $breadcrumbs = [
        //     ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Form Elements"], ['name' => "Quill Editor"]
        // ];

        // return view('/content/forms/form-elements/form-quill-editor', [
        //     'breadcrumbs' => $breadcrumbs,'page' => $pageConfigs
        // ]);
    }
}
