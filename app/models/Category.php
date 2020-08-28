<?php 

class Category extends \Eloquent {

	protected $fillable = ['category_name','category_publish','category_icon'];
	
	public static function list_all_categories()
	{
		//START WITH PARENT
		$parent_categories = DB::table('categories')
								 ->select('categories.id as cat_id','category_name')
								 ->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								 ->where('parent_id','=',0)
								 ->orderBy('xOrder','ASC')
								 ->get();						 
		//DECLARE LISTS OF CATEGORIES
		$category_lists = array('0'=>'select');
		//EXTRACT PARENT CATEGORIES
		//GET EACH CHILD
		foreach ($parent_categories as $pc) 
	    {   
			//PUSH INTO AN ARRAY
			$category_lists += array($pc->cat_id=>$pc->category_name);	
			//GET EACH CHILD
			if(self::getCategoryChild($pc->cat_id))
			 $category_lists += self::getCategoryChild($pc->cat_id);
		}
			 
		return $category_lists;
	}

	//GET CHILD OF CATEGORIES
	public static function getCategoryChild($parent_id,$underscore='')
	{
		$categoryChildren  = array();
		$parent_categories = DB::table('categories')
								->select('categories.id as cat_id','category_name')
								->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								->where('parent_id','=',$parent_id)
								->orderBy('xOrder','ASC')
								->get();	
		if($parent_categories)
		{
		    $underscore       = '_'.$underscore;
			foreach ($parent_categories as $pc) 
		    {   
				//PUSH CHILD INTO AN ARRAY
			    $categoryChildren += array($pc->cat_id=>$underscore.$pc->category_name);	
				//IF CHILD HAS A CHILD
				if(self::getCategoryChild($pc->cat_id,'_'))
				  $categoryChildren += self::getCategoryChild($pc->cat_id,'_');			
			}
		}
		//CHECK IF EMPTY ARRAY
		if(!empty($categoryChildren)) return $categoryChildren; 
	}


	public static function list_all_child_categories($parent_id, $margin_left)
	{
		$categoryChildren  = '';
		$parent_categories = DB::table('categories')
								->select('categories.id as child_cat_id','category_name','category_icon','category_publish','xOrder')
								->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								->where('parent_id','=',$parent_id)
								->orderBy('xOrder','ASC')
								->get();	
		    $margin_left       += $margin_left;
			foreach ($parent_categories as $pc) 
		    {   
		    	$pc->category_publish = ($pc->category_publish=='y') ? 'Yes' : 'No';
				//PUSH CHILD INTO AN ARRAY	
				$categoryChildren .= "<tr>";
				$categoryChildren .=  "<td>".$pc->xOrder."</td>";
				$categoryChildren .=  "<td style='padding-left:".$margin_left."px;'> » ".$pc->category_name."</td>";
				$categoryChildren .=  "<td>".$pc->category_publish."</td>";
				$categoryChildren .=  "<td>".
										 link_to('categories/'.$pc->child_cat_id.'/edit', 'Edit')." | ".
										 link_to('#', 'Delete', array('class'=>'delOption','data-id'=>$pc->child_cat_id,'onclick'=>"delOption($pc->child_cat_id)")) 	 																													
									 ." </td>";
				$categoryChildren .= "</tr>";
				//IF CHILD HAS A CHILD
				$categoryChildren .= self::list_all_child_categories($pc->child_cat_id,$margin_left);
			}
		//CHECK IF EMPTY ARRAY
		return $categoryChildren; 
	}
	

	public static function index()
	{
		return $parent_categories = DB::table('categories')
								 ->select('categories.id as id','category_name','category_publish','category_icon','xOrder')
								 ->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								 ->where('parent_id','=',0)
								 ->orderBy('categories.xOrder','ASC')
								 ->get();	
	}

	public static function edit($parent_id)
	{
		return $parent_categories = DB::table('categories')
								 ->select('categories.id as id','category_name','category_publish','category_icon','parent_id','xOrder')
								 ->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								 ->where('categories.id','=',$parent_id)
								 ->first();	
	}

	public static function store()
	{
		
		$category                   = New Category;
		$category->category_name    = Input::get('category_name');
		$category->category_publish = Input::get('category_publish');
		$category->xOrder 		    = Input::get('xOrder');
		$category->save();

		//INSERT INTO REFERENCE TABLE
		$category_ref            = New CategoryRef;
		$category_ref->parent_id = Input::get('parent_id');
		$category_ref->child_id  = $category->id;
		$category_ref->save();
	}

	public static function updateCategory($id)
	{	
		$category                   = Category::find($id);
		$category->category_name    = Input::get('category_name');
		$category->category_publish = Input::get('category_publish');
		$category->xOrder           = Input::get('xOrder');
		$category->save();

		//DELETE PREVOIUSLY ADDED REF
		DB::table('category_ref')->where('child_id','=',$category->id)->delete();

		//INSERT INTO REFERENCE TABLE
		$category_ref            = New CategoryRef;
		$category_ref->parent_id = Input::get('parent_id');
		$category_ref->child_id  = $category->id;
		$category_ref->save();
	}

	public static function destroy($parent_id)
	{
		//FIND IF CATEGORY IS NOT A PARENT
		if(!DB::table('category_ref')->where('parent_id','=',$parent_id)->get())
		{
			//DELETE CATEGORY
			$category = Category::find($parent_id);
			$category->delete();
			//DELETE AS CHILD 
			DB::table('category_ref')->where('child_id','=',$parent_id)->delete();
		}
		else
		{
			return false;
		}
	}
}