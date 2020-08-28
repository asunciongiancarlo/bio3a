<?php 

class CategoryRef extends \Eloquent {

	protected $table    = 'category_ref';
	protected $fillable = ['parent_id','child_id'];
}