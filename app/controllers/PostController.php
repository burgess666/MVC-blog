<?php
/**
 * @author 	Richard Murphy
 * @desc	This controller handles all logic related to posts.
 * 
 */
class PostController
{
	private $model;
	
	public function __construct($model) {
		$this->model = $model;
	}
}