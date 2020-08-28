<?php 

class BreadCrumb extends Eloquent {

	protected $fillable = [];


	public static function generateBreadCrumbs($active_page)
	{
		return "<ol class='breadcrumb'> 
					<li> " .link_to('lists_of_categories','Categories'). "</li>"
					.ListOfCategory::generate_bread_crumbs($active_page, $active_page).
				"</ol>";	
	}

}