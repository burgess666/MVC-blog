<?php
/**
 * @author Rich Murphy
 * 
 * 	Unit tests for UsersDAO.php
 * 
 */
class UsersDAOTests extends UnitTestCase {
	private $pdoDbManager;
	private $usersDAO;
	public function setUp() {
		require_once '../app/DB/pdoDbManager.php';
		require_once '../app/DB/DAOs/UsersDAO.php';
		
		$this->pdoDbManager = new pdoDbManager ();
		$this->pdoDbManager->openConnection ();
		
		$this->usersDAO = new UsersDAO ( $this->pdoDbManager );
	}
	
	/*
	 * Test to create new comment
	 *
	 * eval: 1 new row should be created
	 */
	public function testCreateUser() {
		$params = [ 
				"username" => "kai_test",
				"email" => " kai_test@gmail.com",
				"passwd" => "test",
		];
		
		$id = $this->usersDAO->insert ( $params );
		
		$this->assertNotEqual ( $id, 0 );
		
		$this->usersDAO->delete ( $id );
	}
	
	/*
	 * Test to read comment
	 */
	public function testReadUser() {
		$params = [ 
				"username" => "kai_test",
				"email" => " kai_test@gmail.com",
				"passwd" => "test",
		];
		
		$id = $this->usersDAO->insert ( $params );
		
		// get comment by ID
		$resultComment = $this->usersDAO->get ( $id );
		
		$result = $resultComment [0] ["user_id"];
		
		$this->assertEqual ( $result, $id );
		
		$this->usersDAO->delete ( $id );
	}
	
	/*
	 * Test to update comment
	 */
	public function testUpdateUser() {
		$userParams = [ 
				"username" => "kaiqiang-test",
				"email" => "kaiqiang-test@gmail.com",
				"passwd" => "testtest" 
		];
		
		$id = $this->usersDAO->insert ( $userParams );
		
		$params = [ 
				"username" => "kaiqiang-test",
				"email" => "kaiqiang-test@gmail.com",
				"passwd" => "update passwd"
		];
		
		$result = $this->usersDAO->update ( $params, $id );
		
		$this->assertEqual ( $result, 1 );
		
		$this->usersDAO->delete ( $id );
	}
	/*
	 * Test to delete comment
	 */
	public function testDeleteComment() {
		$userParams = [ 
				"username" => "kaiqiang-test",
				"email" => "kaiqiang-test@gmail.com",
				"passwd" => "test-delete"
		];
		
		$id = $this->usersDAO->insert ( $userParams );
		
		$result = $this->usersDAO->delete ( $id );
		
		// expect delete to delete 0 rows
		$this->assertEqual ( $result, 1 );
	}
	public function tearDown() {
		$this->pdoDbManager->closeConnection ();
		$this->usersDAO = NULL;
	}
}