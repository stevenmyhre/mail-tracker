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

	public function testPing()
	{
		$track = \jdavidbakr\MailTracker\Model\SentEmail::first();

		Event::fake();

		$pings = $track->opens;
		$pings++;

		$url = action('\jdavidbakr\MailTracker\MailTrackerController@getT',[$track->hash]);
		$this->visit($url);

		$track = $track->fresh();
		$this->assertEquals($pings, $track->opens);

		Event::assertFired(jdavidbakr\MailTracker\Events\ViewEmailEvent::class);
	}

	public function testLink()
	{
		$track = \jdavidbakr\MailTracker\Model\SentEmail::first();

		Event::fake();

		$clicks = $track->clicks;
		$clicks++;

		$redirect = 'http://mfn1.myfootballnow.com/community/thread/2/1636?page=4&amp;x=tRnYCfp9mT#10111';

		$url = action('\jdavidbakr\MailTracker\MailTrackerController@getL',[
    			\jdavidbakr\MailTracker\MailTracker::hash_url($redirect), // Replace slash with dollar sign
				$track->hash
			]);
		$this->call('GET',$url);
		$this->assertRedirectedTo($redirect);

		$track = $track->fresh();
		$this->assertEquals($clicks, $track->clicks);

		// Do it with an invalid hash
		$url = action('\jdavidbakr\MailTracker\MailTrackerController@getL',[
    			\jdavidbakr\MailTracker\MailTracker::hash_url($redirect), // Replace slash with dollar sign
				'bad-hash'
			]);
		$this->call('GET',$url);
		$this->assertRedirectedTo($redirect);

		Event::assertFired(jdavidbakr\MailTracker\Events\LinkClickedEvent::class);
	}
}
