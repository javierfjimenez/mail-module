<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Webklex\IMAP\Facades\Client;

class EmailController extends Controller
{

    public function getRecievedBox()
    {
        //  $client = Client::account('default');
        // try {
        //Connect to the IMAP Server
        //$client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        // $folders = $client->getFolders();
        //Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        // foreach ($folders as $folder) {

        //Get all Messages of the current Mailbox $folder
        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        //  $messages = $folder->messages()->all()->get();
        /** @var \Webklex\PHPIMAP\Message $message */
        //  foreach ($messages as $message) {
        //    dd($message->getSubject(), $message->getSender());
        //    echo $message->getSubject() . '<br />';
        //   echo 'Attachments: ' . $message->getAttachments()->count() . '<br />';
        //   echo $message->getHTMLBody();

        //Move the current Message to 'INBOX.read'
        //   if ($message->move('INBOX.read') == true) {
        //   echo 'Message has ben moved';
        //  } else {
        //     echo 'Message could not be moved';
        // }
        //  }
        //    }
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
        //dd($folders);
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', ['pageConfigs' => $pageConfigs]);
    }

    public function sendMail(Request $request)
    {
        // Validar entrada
        $request->validate([
            //'email-to' => 'required|email',
            'emailSubject' => 'required|string|max:255',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,zip'
        ]);

        $mailTo = 'javier.jj132@gmail.com'/* $request->input('mailTo')*/;
        $subject = $request->input('emailSubject');
        $files = $request->file('files');

        if ($this->sendPhpMail($mailTo, $subject, $files))
            return response()->json(true);

        return response()->json(false);
    }
    private function sendPhpMail($mailTo, $subject, $files = [])
    {
        try {
            $mailFrom = Contact::select('email')->where('type', 1)->first()->email ?? '';
            $finalMessage = EmailTemplate::select('template')->first()->template ?? '';
            $boundary = md5(time()); // define boundary with a md5 hashed value

            $headers = "From: " . strtoupper(session()->get('EMAIL_FROM')) . " <{$mailFrom}>\r\n";
            $headers .= "Reply-To: <{$mailFrom}>\r\n";
            $headers .= "Sent-By: <{$mailFrom}>\r\n";
            $headers .= "Signed-By: <{$mailFrom}>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

            $body = "--{$boundary}\r\n";
            $body .= "Content-Type: text/html; charset=iso-8859-1\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= $finalMessage . "\r\n\r\n";
            if (!empty($files)) {
                for ($i = 0; $i < count($files); $i++) {
                    $file_name = basename($files[$i]);
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
            if (mail($mailTo, $subject, $body, $headers)) {
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
        ]);
        
        EmailTemplate::updateOrCreate([
            'name' => 'base_template',
        ],
         [
            'template' => $request->template ?? null
        ]);

        return response()->json(true);
    }
}
