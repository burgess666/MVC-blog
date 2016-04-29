<?php
require_once ('../simpletest/autorun.php');

class BlogTestSuite extends TestSuite {
	public $slimApp;
	function __construct() {
		// execute parent ( TestSuite ) constructor
		parent::__construct ();
		
		require_once "../Slim/Slim.php";
		Slim\Slim::registerAutoloader ();
		$this->slimApp = new \Slim\Slim (); // slim run-time object
		require_once "config/config.inc.php";
				
		$this->addFile ( 'DAOtests/CommentsDAOTests.php' );
		$this->addFile ( 'DAOtests/PostsDAOTests.php' );
	}
}
?>