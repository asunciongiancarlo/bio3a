<?php namespace Acme\Mailers;

Use Mail;

class Mailer{

	public static function sentTo($user, $subject, $view, $data = [])
	{
		Mail::send($view, $data, function($message)
		{
			$message->to($user)
					->subject($subject);
		});
	}
}

