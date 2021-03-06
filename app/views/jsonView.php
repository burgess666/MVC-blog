<?php
/**
 * @author Kaiqiang Huang
 *
 * 	JSON View Component 
 *
 */
class jsonView {
	private $model, $controller, $slimApp;
	
	//construction method
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	
	//output method
	public function output() {
		// prepare json response
		$jsonResponse = json_encode ( $this->model->apiResponse );
		$this->slimApp->response->write ( $jsonResponse );
	}
}
?>