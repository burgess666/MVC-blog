<?php
/**
 * @author 	Kaiqiang Huang
* @desc	This controller handles all logic related to comment.
*
*/
class CommentController
{
	private $model;

	public function __construct($model) {
		$this->model = $model;
	}
}