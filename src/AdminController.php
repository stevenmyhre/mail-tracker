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
        $emails = SentEmail::paginate(config('mail-tracker.emails-per-page'));

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
}
