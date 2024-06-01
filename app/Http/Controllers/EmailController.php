<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use SebastianBergmann\Template\Template;

class EmailController extends Controller
{

    public function sendMail(Request $request)
    {
        // dd($request->file('files'));
        self::sendPhpMail('javier.jj132@gmail.com','Hola Mundo');
    }

    static function sendPhpMail($mailTo, $subject, $files = [])
    {
        try {
            $mailFrom = Contact::where('type', 1)->first();
            $finalMessage = EmailTemplate::select('template')->first();
            $boundary = md5(time()); // define boundary with a md5 hashed value 
            $name     = [];
            $size     = [];
            $type     = [];
            $files    = [];

            $ccFormat = session()->get('EMAIL_CC_FOR_SEND') == 'true' ? 'CC: ' : 'BCC: ';
            $signedBy = session()->get('EMAIL_SINGNED_BY_SEND');
            $mime_boundary = "$boundary";
            $headers = "From: " . strtoupper(session()->get('EMAIL_FROM')) . " <$mailFrom->email> \r\n";
            $headers .= "Reply-To: <$mailFrom->email>  \r\n";
            $headers .= "Sent-By: <$signedBy> \r\n";
            $headers .= "Signed-By: <$signedBy> \r\n";
            // $headers .= $ccFormat . implode(",", session()->get('EMAIL_FOR_SEND')) . "\r\n";
            $headers .= "MIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

            $body = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=iso-8859-1\n" .
                "Content-Transfer-Encoding: 2bit\n\n" . $finalMessage . "\n\n";

            //plain text 
            if (isset($files) and is_iterable($files)) {
                $i = 0;
                foreach ($files as $file) {
                    $contentID = rand(1000, 99999);
                    $handle = @fopen($file, "r"); // set the file handle only for reading the file 
                    $content = @fread($handle, $size[$i]); // reading the file 
                    @fclose($handle);                 // close upon completion 

                    $file = chunk_split(base64_encode($content));

                    //attachment 
                    $body .= "--{$mime_boundary}\r\n";
                    $body .= 'Content-Type: ' . $type[$i] . '; name="' . $name[$i] . '"' . "\r\n";
                    $body .= 'Content-Disposition: attachment; filename="' . $name[$i] . '"' . "\r\n";
                    $body .= "Content-Transfer-Encoding: base64\r\n";
                    $body .= "Content-ID: <$contentID> \r\n";
                    $body .= "X-Attachment-Id: $contentID \r\n\r\n";
                    $body .= $file; // Attaching the encoded file with email 
                    $i++;
                }
            }
            $body .= "--{$mime_boundary}--";
            @mail($mailTo, $subject, $body, $headers);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
