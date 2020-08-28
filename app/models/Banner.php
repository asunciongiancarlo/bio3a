<?php 

class Banner extends Eloquent {

	protected $fillable = ['xOrder','banner_image','banner_link','banner_publish'];

	public static function index()
	{
		return Banner::all();
	}

	public static function store()
	{
		$file               = Input::file('banner_image');
		$destinationPath    = 'img/banners/';
		
		if (Input::hasFile('banner_image'))
		{
		 $filename           = $file->getClientOriginalName();	
		 $file->move($destinationPath, $filename);
		}
		
		$banner                    = New banner;
		$banner->xOrder            = Input::get('xOrder');
		$banner->banner_publish    = Input::get('banner_publish');
		$banner->banner_link       = Input::get('banner_link');
		$banner->banner_header     = Input::get('banner_header');
		$banner->banner_sub_header = Input::get('banner_sub_header');
		$banner->banner_image      = $filename;
		$banner->save();
	}

	public static function destroy($id)
	{
		$banner = Banner::find($id);
		$banner->delete();
	}

	public static function edit($id)
	{
		return Banner::find($id)->toArray();
	}

	public static function updateBanner($id)
	{
		$file               = Input::file('banner_image');
		$destinationPath    = 'img/banners/';
		
		if (Input::hasFile('banner_image'))
		{
		 $filename           = $file->getClientOriginalName();	
		 $file->move($destinationPath, $filename);
		}
		
		$banner                    = Banner::find($id);
		$banner->xOrder            = Input::get('xOrder');
		$banner->banner_publish    = Input::get('banner_publish');
		$banner->banner_link       = Input::get('banner_link');
		$banner->banner_header     = Input::get('banner_header');
		$banner->banner_sub_header = Input::get('banner_sub_header');
		if(isset($filename))	$banner->banner_image    	= $filename;
		$banner->save();
	}

}