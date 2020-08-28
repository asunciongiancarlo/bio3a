<?php 
class Theme extends \Eloquent {

	protected $fillable = [];

	public static function updateThemes()
	{
		foreach (Input::get('ids') as $key=>$value) {
				
			$theme        = Theme::find($value);
			$theme->value = Input::get('values')[$key];
			$theme->save();

		}
		
	}
}