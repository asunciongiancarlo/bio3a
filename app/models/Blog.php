<?php 
class Blog extends \Eloquent {

	protected $fillable = ['blog_name','blog_image','blog_content'];

	
	public static function index()
	{
		return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','blog_featured','price','blog_sale','price_before')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->where('primary_image','=',1)
			 ->orderBy('blogs.created_at','DESC')
			 ->groupBy('blogs.id')
			 ->get();
	}

	public static function saveBlog()
	{
		$file               = Input::file('blog_image');
		$destinationPath    = 'img/';
		
		$blog                = New Blog;
		$blog->category_id   = Input::get('category_id');
		$blog->blog_title    = Input::get('blog_title');
		$blog->blog_content  = Input::get('blog_content');
		$blog->blog_publish  = Input::get('blog_publish');
		$blog->blog_featured = Input::get('blog_featured');
		$blog->blog_sale     = Input::get('blog_sale');
		$blog->price         = Input::get('price');
		$blog->price_before  = Input::get('price_before');
		$blog->blog_intro    = Input::get('blog_intro');
		$blog->blog_image    = '';
		$blog->save();

		if(Input::file('blog_images'))
		{
			foreach (Input::file('blog_images') as $value) {
				$fileName = Str::random(12).'.'.$value->getClientOriginalExtension();
				$destinationPath    = 'img/';

				// upload new image
				Image::make($value->getRealPath())
				->save($destinationPath.'original/'.$fileName)
				->resize('140', '140')
				->save($destinationPath.'thumbnail/'.$fileName)
				->resize('280', '255') 
				->save($destinationPath.'resize/'.$fileName)
				->destroy();
				
				//SAVE ALL IMAGES
				$blog_image 			   = New BlogImage;
				$blog_image->blog_id 	   = $blog->id;
				$blog_image->image_name    = $fileName;
				$blog_image->primary_image = 0;
				$blog_image->save();
			}

			//SET PRIMARY IMAGE
			//GET LAST INSERTED IMAGE
			DB::table('blog_images')
					->select('max(updated_at)')
					->where('blog_id','=',$blog->id)
					->skip(0)
					->take(1)
				    ->update(array('primary_image' => 1));
		}
	
		
	}

	public static function updateBlog($id)
	{
		$file               = Input::file('blog_image');
		$destinationPath    = 'img/';

		$blog                = Blog::find($id);
		$blog->category_id   = Input::get('category_id');
		$blog->blog_title    = Input::get('blog_title');
		$blog->blog_content  = Input::get('blog_content');
		$blog->blog_publish  = Input::get('blog_publish');
		$blog->blog_featured = Input::get('blog_featured');
		$blog->blog_sale     = Input::get('blog_sale');
		$blog->price         = Input::get('price');
		$blog->price_before  = Input::get('price_before');
		$blog->blog_intro    = Input::get('blog_intro');

		if(Input::hasFile('blog_images'))
		{

			foreach (Input::file('blog_images') as $value) {
					$fileName = Str::random(12).'.'.$value->getClientOriginalExtension();
					$destinationPath    = 'img/';

					// upload new image
					Image::make($value->getRealPath())
					->save($destinationPath.'original/'.$fileName)->destroy();

					Image::make($destinationPath.'original/'.$fileName)
					->resize('140', '140') 
					->save($destinationPath.'thumbnail/'.$fileName)
					->resize('280','255')
					->save($destinationPath.'resize/'.$fileName)
					->destroy();
					
					//SAVE ALL IMAGES
					$blog_image 			   = New BlogImage;
					$blog_image->blog_id 	   = $blog->id;
					$blog_image->image_name    = $fileName;
					$blog_image->primary_image = 0;
					$blog_image->save();
			}
		}
		
		$blog->save();
	}

	public static function deleteBlog($id)
	{
		$blog = Blog::find($id);
		$blog->delete();
	}	

	//RETURN ALL BLOGS UNDER SPECIFIC CATEGORIES
	public static function under_child_categories($child_categories)
	{
		//CHECK IF USER IS NOT LOOKING FOR SALE ITEMS
		//ELSE RETURN ALL SALE ITEMS
		if($child_categories!='sale')
		{
			return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','price','blog_sale','blogs.created_at as created_at','price_before')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->where('primary_image','=',1)
			 ->whereRaw("category_id IN ($child_categories)")
			 ->orderBy('blogs.created_at','DESC')
			 ->groupBy('blogs.id')
			 ->paginate(9);
		}
		else
		{
			return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','price','blog_sale','blogs.created_at as created_at','price_before')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->where('primary_image','=',1)
			 ->where('blog_sale','=','y')
			 ->where('blog_publish','=','y')
			 ->orderBy('blogs.created_at','DESC')
			 ->groupBy('blogs.id')
			 ->paginate(9);
		}
		
	}

	public static function all_blogs_under_categories()
	{
		return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','price','blog_sale','blogs.created_at as created_at','price_before')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->where('primary_image','=',1)
			 ->where('blogs.blog_publish','=','y')
			 ->orderBy('blogs.created_at','DESC')
			 ->groupBy('blogs.id')
			 ->paginate(9);
	}

	//RETURN CATEGORY ID FOR PRODUCT PREVIEW
	public static function returnCategoryID($blog_id)
	{
		return Blog::find($blog_id)->category_id;
	}

	public static function previewWithImages($blog_id)
	{
		$data['form_data']	    = Blog::find($blog_id)->toArray();
		$data['images']			= BlogImage::edit($blog_id);

		return $data;
	}

	//VIEW RELATED PRODUCTS
	public static function getRelatedProducts($category_id)
	{
		return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','price','blog_sale','blogs.created_at as created_at','price_before')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->where('primary_image','=',1)
			 ->where('category_id','=',$category_id)
			 ->orderBy(DB::raw('RAND()'))
			 ->skip(0)
			 ->take(3)
			 ->groupBy('blogs.id')
			 ->get();
	}
}