<?php
/**
 * @author Kaiqiang Huang
 *
 * 	XML View Component 
 *
 */
class xmlView {
	private $model, $controller, $slimApp;
	
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	
	//output method
	public function output() {
		// prepare json response
		$xmlResponse = xmlrpc_encode( $this->model->apiResponse );
		$this->slimApp->response->write ( $xmlResponse );
	}
}
?>