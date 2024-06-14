<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function getNewEmails()
    {
        try {
            $messages = $this->imapService->getUnseenEmails();
        } catch (\Throwable $th) {
            Log::error('Error fetching new emails: ' . $th->getMessage());
            return response()->view('errors.custom', [], 500);
        }

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', [
            'pageConfigs' => $pageConfigs,
            'messages' => $messages,
            'messagesCount' => $this->messagesCount

        ]);
    }

    public function seenEmails()
    {
        try {
            $messages = $this->imapService->getSentEmails();
        } catch (\Throwable $th) {
            Log::error('Error fetching new emails: ' . $th->getMessage());
            return response()->view('errors.custom', [], 500);
        }

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', [
            'pageConfigs' => $pageConfigs,
            'messages' => $messages,
            'messagesCount' => $this->messagesCount
        ]);
    }
    public function sentEmails()
    {
        try {
            $messages = $this->imapService->getSentEmails();
        } catch (\Throwable $th) {
            Log::error('Error fetching new emails: ' . $th->getMessage());
            return response()->view('errors.custom', [], 500);
        }

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', [
            'pageConfigs' => $pageConfigs,
            'messages' => $messages,
            'messagesCount' => $this->messagesCount
        ]);
    }

    public function deletedEmails()
    {
        try {
            $messages = $this->imapService->getDeletedEmails();
        } catch (\Throwable $th) {
            Log::error('Error fetching new emails: ' . $th->getMessage());
            return response()->view('errors.custom', [], 500);
        }

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', [
            'pageConfigs' => $pageConfigs,
            'messages' => $messages,
            'messagesCount' => $this->messagesCount

        ]);
    }

    public function getEmailByUid($uid)
    {
        try {
            $message = $this->imapService->getEmailByUid($uid);

            // $message->getAttachments()->each(function ($attachment) use ($message) {
            //     $fp = fopen(storage_path('attachments/') . $attachment->name, "wb");
            //     file_put_contents(storage_path('attachments/' . $attachment->name), $attachment->content);
            //     $content = file_get_contents(storage_path('attachments/' . $attachment->name));
            //     $file = "data:file/pdf;base64," . base64_encode($content);
            //     dd($file);
            //     fclose($fp);
            // });
            $data = [
                'subject' => $message->getSubject(),
                'from' => ['personal' => $message->getFrom()[0]->personal, 'mail' => $message->getFrom()[0]->mail],
                'to' => $message->getTo()[0]->mail,
                'date' => $message->getDate(),
                'body' => $message->getHTMLBody(),
                'attachments' => ['count' => $message->getAttachments()->count(), 'files' => $message->getAttachments()]
            ];
            $message->setFlag('SEEN');
            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching email by UID: ' . $th->getMessage());
            return response()->json(['success' => false, 'error' => 'Error fetching emails' . $th], 200);
        }
    }
    public function sendMail(Request $request)
    {
        // Validar entrada
        $request->validate([
            'emailSubject' => 'required|string|max:255',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,zip'
        ]);

        $mailTo = Contact::where('id', $request->input('emailTo'))->first()->email ?? '';
        $emailCC = $request->input('emailCC');
        $emailBCC = $request->input('emailBCC');

        $group = [];
        if (isset($emailCC) || isset($emailBCC)) {
            $roup_id = $emailBCC ?? $emailCC;
            $records = Contact::select('email')->where('group_id', $roup_id)->get()->toArray() ?? [];
            $data = [];
            foreach ($records as $group) {
                $data[] = $group['email'];
            }
            $group = isset($emailBCC) ? ['type' => 'BCC: ', 'emails' => $data] :  ['type' => 'CC: ', 'emails' => $data];
        }
        $subject = $request->input('emailSubject');
        $files = $request->file('files');
        if ($this->sendPhpMail($mailTo, $subject, $files, $group))
            return response()->json(true);

        return response()->json(false);
    }
    private function sendPhpMail($mailTo, $subject, $files = [], $group = [])
    {
        try {
            $mailFrom = EmailTemplate::select('email')->first()->email ?? '';
            $finalMessage = EmailTemplate::select('template')->first()->template ?? '';
            $boundary = md5(time()); // define boundary with a md5 hashed value

            $headers = "From: <{$mailFrom}>\r\n";
            $headers .= "Reply-To: <{$mailFrom}>\r\n";
            if (!empty($group))
                $headers .= $group['type'] . implode(",", $group['emails']) . "\r\n";

            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

            $body = "--{$boundary}\r\n";
            $body .= "Content-Type: text/html; charset=iso-8859-1\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= $finalMessage . "\r\n\r\n";
            if (!empty($files)) {
                for ($i = 0; $i < count($files); $i++) {
                    $file_size = filesize($files[$i]);
                    $file_type = $files[$i]->getClientMimeType();
                    $file_original_name = $files[$i]->getClientOriginalName();
                    $fp =    @fopen($files[$i], "rb");
                    $data =  @fread($fp, $file_size);
                    @fclose($fp);
                    $fileContent = chunk_split(base64_encode($data));
                    $body .= "--{$boundary}\r\n";
                    $body .= "Content-Type: {$file_type}; name=\"{$file_original_name}\"\r\n";
                    $body .= "Content-Disposition: attachment; filename=\"{$file_original_name}\"\r\n";
                    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                    $body .= $fileContent . "\r\n\r\n";
                }
            }
            $body .= "--{$boundary}--";
            if (mail($mailTo ?? $group['emails'][0], $subject, $body, $headers)) {
                return true;
            } else {
                throw new \Exception('Mail function failed');
            }
        } catch (\Exception $e) {
            Log::error("Error sending email: " . $e->getMessage());
            return false;
        }
    }

    public function emailTemplateStore(Request $request)
    {
        $request->validate([
            'template' => 'required|string',
            'email' => 'required|string',
        ]);

        EmailTemplate::updateOrCreate(
            [
                'name' => 'base_template',
            ],
            [
                'template' => $request->template ?? null,
                'email' => $request->email ?? null,
            ]
        );

        return response()->json(true);
    }
}
