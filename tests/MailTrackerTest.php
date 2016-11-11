<?php

use jdavidbakr\MailTracker\MailTracker;

class AddressVerificationTest extends TestCase
{
	public function testSendMessage()
	{
		// Create an old email to purge
		Config::set('mail-tracker.expire-days', 1);
		$old_email = \jdavidbakr\MailTracker\Model\SentEmail::create([
				'hash'=>str_random(32),
			]);
		$old_url = \jdavidbakr\MailTracker\Model\SentEmailUrlClicked::create([
				'sent_email_id'=>$old_email->id,
				'hash'=>str_random(32),
			]);
		// Go into the future to make sure that the old email gets removed
		\Carbon\Carbon::setTestNow(\Carbon\Carbon::now()->addWeek());

		$faker = Faker\Factory::create();
		$email = $faker->email;
		$subject = $faker->sentence;
		$name = $faker->firstName . ' ' .$faker->lastName;
		\View::addLocation(__DIR__);
		\Mail::send('email.test', [], function ($message) use($email, $subject, $name) {
		    $message->from('from@johndoe.com', 'From Name');
		    $message->sender('sender@johndoe.com', 'Sender Name');
		
		    $message->to($email, $name);
		
		    $message->cc('cc@johndoe.com', 'CC Name');
		    $message->bcc('bcc@johndoe.com', 'BCC Name');
		
		    $message->replyTo('reply-to@johndoe.com', 'Reply-To Name');
		
		    $message->subject($subject);
		
		    $message->priority(3);
		});
		$this->seeInDatabase('sent_emails',[
				'recipient'=>$name.' <'.$email.'>',
				'subject'=>$subject,
				'sender'=>'From Name <from@johndoe.com>',
				'recipient'=>"{$name} <{$email}>",
			]);
		$this->assertNull($old_email->fresh());
		$this->assertNull($old_url->fresh());
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
		$track = \jdavidbakr\MailTracker\Model\SentEmail::orderBy('id','desc')->first();

		Event::fake();

		$clicks = $track->clicks;
		$clicks++;

		$redirect = 'http://'.str_random(15).'.com/'.str_random(10).'/'.str_random(10).'/'.rand(0,100).'/'.rand(0,100).'?page='.rand(0,100).'&amp;x='.str_random(32);

		$url = action('\jdavidbakr\MailTracker\MailTrackerController@getL',[
    			\jdavidbakr\MailTracker\MailTracker::hash_url($redirect), // Replace slash with dollar sign
				$track->hash
			]);
		$this->call('GET',$url);
		$this->assertRedirectedTo($redirect);

		Event::assertFired(jdavidbakr\MailTracker\Events\LinkClickedEvent::class);

		$this->seeInDatabase('sent_emails_url_clicked',[
				'url'=>$redirect,
				'clicks'=>1,
			]);

		$track = $track->fresh();
		$this->assertEquals($clicks, $track->clicks);

		// Do it with an invalid hash
		$url = action('\jdavidbakr\MailTracker\MailTrackerController@getL',[
    			\jdavidbakr\MailTracker\MailTracker::hash_url($redirect), // Replace slash with dollar sign
				'bad-hash'
			]);
		$this->call('GET',$url);
		$this->assertRedirectedTo($redirect);
	}

	/**
	 * @test
	 *
	 * Note that to complete this test, you must have aws credentials as well as a valid
	 * from address in the mail config.
	 */
	public function it_retrieves_the_mesage_id_from_ses()
	{
		if(!config('aws.credentials.key') || config('mail.from.address') == null) {
			$this->markTestIncomplete();
			return;
		}
		Config::set('mail.driver', 'ses');
		(new Illuminate\Mail\MailServiceProvider(app()))->register();
		// Must re-register the MailTracker to get the test to work
        $this->app['mailer']->getSwiftMailer()->registerPlugin(new MailTracker());

		$faker = Faker\Factory::create();
		$email = 'success@simulator.amazonses.com';
		$subject = $faker->sentence;
		$name = $faker->firstName . ' ' .$faker->lastName;
		\View::addLocation(__DIR__);
		\Mail::send('email.test', [], function ($message) use($email, $subject, $name) {
		    $message->to($email, $name);
		
		    $message->replyTo('reply-to@johndoe.com', 'Reply-To Name');
		
		    $message->subject($subject);
		
		    $message->priority(3);
		});
		$sent_email = \jdavidbakr\MailTracker\Model\SentEmail::orderBy('id','desc')->first();
		$this->assertEquals(0, preg_match('/swift\.generated/',$sent_email->message_id));
	}
}
