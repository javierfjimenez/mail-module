<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        // Cargar contactos solo cuando se necesiten
        $contacts = $this->contactModel->select('id', 'name', 'email')->where('status', 1)->get();
        $groups = $this->groupModel->select('id', 'name')->where('status', 1)->get();

        return view('content.apps.user.app-user-list', [
            'pageConfigs' => $pageConfigs,
            'contacts' => $contacts,
            'groups' => $groups,
        ]);
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

    public function userStore(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user_id,
            'password' => 'nullable|string|min:5',
        ]);

        // Envolver en una transacción para asegurar la consistencia de los datos
        return DB::transaction(function () use ($request) {
            if ($request->has('user_id') && !is_null($request->user_id)) {
                // Actualizar usuario existente
                $user = User::find($request->user_id);

                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'User not found'], 404);
                }

                $user->name = $request->name;
                $user->email = $request->email;
                $user->status = (int)$request->status;

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();

                return response()->json(['success' => true, 'user' => $user], 200);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => (int)$request->status,
                    'password' => Hash::make($request->password),
                ]);

                return response()->json(['success' => true, 'user' => $user], 201);
            }
        });
    }

    // User List Page
    public function contactList()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        $contacts = $this->contactModel->select('id', 'name', 'email')->where('status', 1)->get();
        $groups = $this->groupModel->select('id', 'name')->where('status', 1)->get();

        return view('/content/apps/user/app-contact-list', ['pageConfigs' => $pageConfigs, 'messagesCount' => $this->messagesCount, 'contacts' => $contacts, 'groups' => $groups]);
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
            $contact = Contact::where('id', $contact_id)->update(['name' => $request->name, 'email' => $request->email, 'status' => (int)$request->status]);
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
            'status' => (int)$request->status,
            'type' => 0,
        ]);
        return response()->json(['success' => true, 'contact' => $contact]);
    }
    // User List Page
    public function groupList()
    {
        $contacts = $this->contactModel->select('id', 'name', 'email')->where('status', 1)->get();
        $groups = $this->groupModel->select('id', 'name')->where('status', 1)->get();

        $groups = Group::select('id', 'name', 'created_at')->get();
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        return view('/content/apps/user/app-contact-group-list', ['pageConfigs' => $pageConfigs, 'groups' => $groups, 'contacts' => $contacts, 'messagesCount' => $this->messagesCount]);
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
            $group = Group::where('id', $group_id)->update(['name' => $request->name, 'status' => (int)$request->status]);
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
            'name' => $request->name,
            'status' => (int)$request->status
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



    // Quill Editor
    public function emailTemplate()
    {
        // $pageConfigs = ['pageHeader' => false];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];
        $contacts = $this->contactModel->select('id', 'name', 'email')->where('status', 1)->get();
        $groups = $this->groupModel->select('id', 'name')->where('status', 1)->get();

        $emailTemplate = EmailTemplate::select('template', 'email')->first();
        return view('/content/apps/user/app-email-template', ['pageConfigs' => $pageConfigs, 'emailTemplate' => $emailTemplate->template ?? null, 'email' => $emailTemplate->email ?? null, 'messagesCount' => $this->messagesCount, 'contacts' => $contacts, 'groups' => $groups]);
    }
}
