<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiriusEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    // public function build()
    // {
    //     $email = $this->view('emails.sendgrid')
    //                   ->subject($this->data['subject'])
    //                   ->with('data', $this->data);

    //     if (!empty($this->data['message'])) {
    //         $imageData = $this->data['message'];
    //         $imageName = 'image.png'; // You can set a custom name for the image
    //         $imageMimeType = 'image/png'; // Set the image MIME type

    //         $decodedImage = base64_decode($imageData);
    //         $email->attachData($decodedImage, $imageName, ['mime' => $imageMimeType]);
    //     }

    //     return $email;
    // }
    public function build()
    {
        $email = $this->view('emails.sendgrid')
            ->subject($this->data['subject'])
            ->with('data', $this->data);

        $message = $this->data['message'];
        $nonImageMessages = [];
        foreach ($message as $key => $msg) {
            if (strpos($msg, 'data:image') !== false) {
                // Decode the base64 encoded string and attach as a separate part
                $base64String = $msg;
                $mime = 'image/png';
                if (strpos($base64String, 'data:image/jpeg;base64,') === 0) {
                    $decodedString = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64String));
                    $mime = 'image/jpeg';
                } elseif (strpos($base64String, 'data:image/png;base64,') === 0) {
                    $decodedString = base64_decode(str_replace('data:image/png;base64,', '', $base64String));
                } else {
                    throw new \Exception('Invalid image MIME type');
                }

                // Remove the original image message from the array
                unset($message[$key]);

                $email->attachData($decodedString, 'hello/image', ['mime' => $mime]);
                $containsImage = true;

                // Do not add a new message part for the image attachment, it will be displayed via the cid reference
            }
        }
        // Add the non-image messages to the email body
        $email->with(['message' => implode("\n", $message)]);
    }
}
