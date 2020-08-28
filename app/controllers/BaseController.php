<?php

class BaseController extends Controller {


	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	
		View::share('currentUser', Auth::user());
		View::share('key', '');
		View::share('customer_info', Session::get('customer_info'));

		//VIEW NUMBER OF UNREAD MESSAGES
		$result[0] = 0;
		if(Session::get('customer_info'))
		{
			$ctr = Conversation::showMessageCounter();

			$result = array();
			foreach ($ctr as $key => $value) {
			    $result[] = $value->message_ctr;
			}
		}	

		view::share('msg_ctr', $result[0]);
		//VIEW NUMBER OF UNREAD MESSAGES

		//GET BACKGROUND COLOR OF FRONT END
		view::share('font_end_background_color', Theme::find(1));
	}


}
