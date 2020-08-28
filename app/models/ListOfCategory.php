<?php 

class ListOfCategory extends Eloquent {

	protected $fillable = [];

	//CATEGORIES SIDENAV
	public static function categories($active_parent)
	{
		$parent_categories = DB::table('categories')
									 ->select('categories.id as id','category_name','category_publish','category_icon')
									 ->leftjoin('category_ref','categories.id','=','category_ref.child_id')
									 ->where('parent_id','=',0)
									 ->where('category_publish','=','y')
									 ->orderBy('category_name','ASC')
									 ->get();
		 $active = '';
		 $cat    = "<ul class='blog_category'>";

		 $cat   .= "<li>".link_to('lists_of_categories','All Categories', array('class'=>'list-group-item active'. ($active_parent)==null ? 'active' : '' ))."</li>";
		  //IF UESR IS SEARCHING FOR SALE ITEMS
		 //if($active_parent=='sale')
		 //$cat .= link_to('lists_of_categories/show/sale', 'Sale', array('class'=>'list-group-item '. ($active_parent=='sale' ? 'active':'') ));

		 foreach ($parent_categories as $parent_category) 
		 {
		 	$active = ($active_parent==$parent_category->id) ? 'active' : '';
		 	$cat   .= "<li>".link_to('lists_of_categories/show/'.$parent_category->id, '  '.$parent_category->category_name, array('class'=>'list-group-item '.$active))."</li>";
			$cat   .= self::list_all_child_categories($parent_category->id, 7, $active_parent);
			$active = '';
		 }

		 //CLOSE LINKS
		 $cat .= "</ul>";

		 return $cat;
	}

	//CATEGORIES SIDENAV CHILDREN
	public static function list_all_child_categories($parent_id, $padding_left, $active_parent)
	{
		$categoryChildren  = '';
		$parent_categories = DB::table('categories')
								->select('categories.id as child_cat_id','category_name','category_icon','category_publish')
								->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								->where('parent_id','=',$parent_id)
								->where('category_publish','=','y')
								->orderBy('category_name','ASC')
								->get();	

			$active 		= '';
		    $padding_left  += $padding_left;
			foreach ($parent_categories as $pc) 
		    {   
				//PUSH CHILD INTO AN ARRAY	
				$active = ($active_parent==$pc->child_cat_id) ? 'active' : '';
				$categoryChildren .=  link_to('lists_of_categories/show/'.$pc->child_cat_id, '» '.$pc->category_name, array('style'=>'padding-left:'.$padding_left.'px;', 'class'=>'list-group-item '.$active)) ;
				//IF CHILD HAS A CHILD
				$categoryChildren .= self::list_all_child_categories($pc->child_cat_id, $padding_left, $active_parent);
			}
		//CHECK IF EMPTY ARRAY
		return $categoryChildren; 
	}

	//VIEW ALL ITEMS UNDER PARENT CATEGORY
	public static function show_all_items_under($parent_id)
	{
		$listOfChildCategories = '';
		
		//GET ALL CHILD CATEGORIES
		$child_categories = DB::table('categories')
								->select('categories.id as child_cat_id','category_name','category_icon','category_publish')
								->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								->where('parent_id','=',$parent_id)
								->where('category_publish','=','y')
								->orderBy('category_name','ASC')
								->get();	

		//COMPILE ALL CHILD CATEGORIES
		foreach ($child_categories as $child_category) 
		{
			$listOfChildCategories .= $child_category->child_cat_id.',';	
			$listOfChildCategories .= self::show_all_items_under($child_category->child_cat_id);
		}

		return $listOfChildCategories;
	}

	//GENERATE BREAD CRUMBS
	public static function generate_bread_crumbs($child_id, $active_parent)
	{
		$breadCrumbs      = '';	
		$active 		  = '';
		//GET ALL CHILD CATEGORIES
		$child_categories = DB::table('categories')
								->select('parent_id as parent_id','child_id','category_name','category_icon','category_publish')
								->leftjoin('category_ref','categories.id','=','category_ref.child_id')
								->where('child_id','=',$child_id)
								->where('category_publish','=','y')
								->orderBy('category_name','ASC')
								->get();	

		//COMPILE ALL CHILD CATEGORIES
		foreach ($child_categories as $child_category) 
		{
			$active 	  = ($active_parent==$child_category->parent_id) ? 'active' : '';
			$breadCrumbs  = "<li class='$active'>". link_to('lists_of_categories/show/'.$child_category->child_id, $child_category->category_name) .'</li>'.$breadCrumbs;	
			$breadCrumbs  = self::generate_bread_crumbs($child_category->parent_id, $active_parent).$breadCrumbs;
		}

		return $breadCrumbs;
	}

}