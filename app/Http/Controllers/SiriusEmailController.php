<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\SiriusEmail;

class SiriusEmailController extends Controller
{
    // public function sendEmail(Request $request)
    // {
    //     // Validation
    //     $validator = Validator::make($request->all(), [
    //         'selectedOptions' => 'required|string|min:1',
    //         // 'selectedOptions.*' => 'required|string|email|max:255',
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->all();


    //     // Send email using SendGrid
    //     // foreach ($data['selectedOptions'] as $email) {
    //         Mail::to($data['selectedOptions'])->send(new SiriusEmail());
    //     // }

    //     return response()->json(['message' => true, 'email' => $data], 200);
    // }
    // public function sendEmail(Request $request)
    // {
    //     // Validation
    //     $validator = Validator::make($request->all(), [

    //         'selectedOptions' => 'required|string|email|max:255',
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->all();

    //     // Send email using SendGrid
    //     Mail::to($data['selectedOptions'])->send(new SiriusEmail($data));

    //     return response()->json(['message' => 'Email sent successfully']);
    // }
    // public function sendEmail(Request $request)
    // {
    //     // Validation
    //     $validator = Validator::make($request->all(), [
    //         'selectedOptions' => 'required|array|min:1',
    //         'selectedOptions.*' => 'required|string|email|max:255',
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->all();

    //     // Send email using SendGrid
    //     foreach ($data['selectedOptions'] as $email) {
    //         Mail::to($email)->send(new SiriusEmail([
    //             'selectedOptions' => $email,
    //             'subject' => $data['subject'],
    //             'message' => $data['message'],
    //         ]));
    //     }

    //     return response()->json(['message' => 'Email sent successfully'], 200);
    // }
    // public function sendEmail(Request $request)
    // {
    //     // Validation
    //     $validator = Validator::make($request->all(), [
    //         'selectedOptions' => 'required|array|min:1',
    //         'selectedOptions.*' => 'required|string|email|max:255',
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|array',
    //         'message.*' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->all();
    //         // dd($data);


    //     // Send email using SendGrid
    //     foreach ($data['selectedOptions'] as $email) {
    //         foreach($data['message'] as $message){
    //             if(is_array($message)) {
    //                 // If the value is an object, iterate through it and concatenate the values
    //                 $messageString = '';
    //                 foreach($message as $key => $value) {
    //                     $messageString .= $value['insert'];
    //                 }
    //                 $message = $messageString;

    //             } else {
    //                 // If the value is a string, use it as-is
    //                 $message = $message;

    //             }
    //             Mail::to($email)->send(new SiriusEmail([
    //                 'selectedOptions' => $email,
    //                 'subject' => $data['subject'],
    //                 'message' => $message,
    //                 'attributes' => $data['attributes']
    //             ]));
    //         }
    //     }

    //     return response()->json(['message' => 'Email sent successfully'], 200);
    // }
    public function sendEmail(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'selectedOptions' => 'required|array|min:1',
            'selectedOptions.*' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|array',
            'message.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        // Send email using SendGrid
        foreach ($data['selectedOptions'] as $email) {
        //     Mail::to($email)->send(new SiriusEmail([
        //         'selectedOptions' => $email,
        //         'subject' => $data['subject'],
        //         'message' => $data['message'],
        //     ]));
        }

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
