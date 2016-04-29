<?php
/**
 * @author Rich Murphy
 *
 * 	Unit tests for CommentsDAO.php
 *
 */
class UserControllerTests extends UnitTestCase {
	public $userController;
	public $userModel;
	
	
	public function setUp() {
		require_once '../app/models/UserModel.php';
		require_once '../app/controllers/UserController.php';
		
		$this->userModel = new UserModel();
		$this->userController = new UserController($userModel, $slimApp);
	}
	
	public function testAuthenticateUser() {
		$result = $this->userController->authenticateUser("rich", "rich");
		$this->assertTrue($result);
	}
	
	public function tearDown() {
		
	}
	
}