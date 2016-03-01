<?php

class AddressVerificationTest extends TestCase
{
	public function testSendMessage()
	{
		\View::addLocation(__DIR__);
		\Mail::send('email.test', [], function ($message) {
		    $message->from('from@johndoe.com', 'From Name');
		    $message->sender('sender@johndoe.com', 'Sender Name');
		
		    $message->to('to@johndoe.com', 'To Name');
		
		    $message->cc('cc@johndoe.com', 'CC Name');
		    $message->bcc('bcc@johndoe.com', 'BCC Name');
		
		    $message->replyTo('reply-to@johndoe.com', 'Reply-To Name');
		
		    $message->subject('Subject');
		
		    $message->priority(3);
		});
	}
}