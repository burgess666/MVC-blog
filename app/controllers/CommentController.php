<?php
class CommentController
{
	private $model;

	public function __construct($model) {
		$this->model = $model;
	}
}