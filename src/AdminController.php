<?php

namespace jdavidbakr\MailTracker;

use Illuminate\Http\Request;
use Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use jdavidbakr\MailTracker\Model\SentEmail;
use jdavidbakr\MailTracker\Model\SentEmailUrlClicked;

use Mail;


class AdminController extends Controller
{
    /**
     * Index.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $emails = SentEmail::all();

        return \View('emailTrakingViews::index')->with('emails', $emails);
    }

    /**
     * Show Email.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShowEmail($id)
    {
        $email = SentEmail::where('id',$id)->first();
        return \View('emailTrakingViews::show')->with('email', $email);
    }

    /**
     * Url Detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUrlDetail($id)
    {
        $detalle = SentEmailUrlClicked::where('sent_email_id',$id)->get();
        return \View('emailTrakingViews::url_detail')->with('details', $detalle);
    }

    /**
     * New Email.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewEmail()
    {

        return view('emailTrakingViews::email_form');
    }

    /**
     * Send Email.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSendEmail(Request $request)
    {

        $data = [
            'name' => $request->name,
            'to' => $request->email,
            'message' => $request->message
        ];
        Mail::send('emailTrakingViews::emails/mensaje', ['data' => $data], function($message) use ($data){
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($data['to'], $data['name']);
            // $message->cc('cc@johndoe.com', 'CC Name');
		    // $message->bcc('bcc@johndoe.com', 'BCC Name');
		    // $message->replyTo('reply-to@johndoe.com', 'Reply-To Name');
		    // $message->priority(3);
            $message->subject('New Message from '. config('mail-tracker.name') );
        });
        \Log::notice('Email Sent to: '.$data['to'] . ' - '. $data['name']);
        return redirect()->route('mailTracker_Index');
    }
}
