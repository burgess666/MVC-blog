<?php
/**
 * @author 	Kaiqiang Huang
* @desc	This controller handles all logic related to users.
*
*/
class UserController
{
	private $model;

	public function __construct($model) {
		$this-> model = $model;
	}
}