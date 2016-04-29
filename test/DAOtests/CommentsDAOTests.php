<?php
/**
 * @author Rich Murphy
 * 
 * 	Unit tests for CommentsDAO.php
 * 
 */
class CommentsDAOTests extends UnitTestCase {
	private $pdoDbManager;
	private $commentsDAO;
	public function setUp() {
		require_once '../app/DB/pdoDbManager.php';
		require_once '../app/DB/DAOs/CommentsDAO.php';
		
		$this->pdoDbManager = new pdoDbManager ();
		$this->pdoDbManager->openConnection ();
		
		$this->commentsDAO = new CommentsDAO ( $this->pdoDbManager );
	}
	
	/*
	 * Test to create new comment
	 *
	 * eval: 1 new row should be created
	 */
	public function testCreateComment() {
		$params = [ 

				"commented_date" => "2002-01-02",
				"content" => "Some content here.",
				"commented_date" => "2016-01-02",
				"content" => "Connent here",
				"user_id" => "1",
				"post_id" => "1" 
		];
		
		$id = $this->commentsDAO->insert ( $params );
		
		$this->assertNotEqual ( $id, 0 );
		
		$this->commentsDAO->delete ( $id );
	}
	
	/*
	 * Test to read comment
	 */
	public function testReadComment() {
		$params = [ 
				"commented_date" => "2002-01-02",
				"content" => "Some content here",
				"content" => "comment here",
				"user_id" => "1",
				"post_id" => "1" 
		];
		
		$id = $this->commentsDAO->insert ( $params );
		
		// get comment by ID
		$resultComment = $this->commentsDAO->get ( $id );
		
		$result = $resultComment [0] ["comment_id"];
		
		$this->assertEqual ( $result, $id );
		
		$this->commentsDAO->delete ( $id );
	}
	
	/*
	 * Test to update comment
	 */
	public function testUpdateComment() {
		$userParams = [ 
				"user_id" => "1",
				"post_id" => "1",
				"commented_date" => "2013-01-04",
				"content" => "Firetrucks are better than tirefrucks." 
		];
		
		$id = $this->commentsDAO->insert ( $userParams );
		
		$params = [ 
				"commented_date" => "2012-01-02",
				"content" => "Updated content text again",
				"user_id" => "1",
				"post_id" => "1" 
		];
		
		$result = $this->commentsDAO->update ( $params, $id );
		
		$this->assertEqual ( $result, 1 );
		
		$this->commentsDAO->delete ( $id );
	}
	/*
	 * Test to delete comment
	 */
	public function testDeleteComment() {
		$userParams = [ 
				"user_id" => "1",
				"post_id" => "1",
				"commented_date" => "2013-01-04",
				"content" => "Firetrucks are better than tirefrucks." 
		];
		
		$id = $this->commentsDAO->insert ( $userParams );
		
		$result = $this->commentsDAO->delete ( $id );
		
		// expect delete to delete 0 rows
		$this->assertEqual ( $result, 1 );
	}
	public function tearDown() {
		$this->pdoDbManager->closeConnection ();
		$this->commentsDAO = NULL;
	}
}