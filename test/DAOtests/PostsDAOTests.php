<?php
/**
 * @author Rich Murphy
 * 
 * 	Unit tests for PostsDAO.php
 * 
 */
class PostsDAOTests extends UnitTestCase {
	private $pdoDbManager;
	private $postsDAO;
	public function setUp() {
		require_once '../app/DB/pdoDbManager.php';
		require_once '../app/DB/DAOs/PostsDAO.php';
		
		$this->pdoDbManager = new pdoDbManager ();
		$this->pdoDbManager->openConnection ();
		
		$this->postsDAO = new PostsDAO ( $this->pdoDbManager );
	}
	
	/*
	 * Test to create new comment
	 *
	 * eval: 1 new row should be created
	 */
	public function testCreateComment() {
		$params = [ 
				"user_id" => "1",
				"post_id" => "1",
				"posted_date" => "2012-01-05",
				"title" => "New post",
				"content" => "This is a very insightful post."
		];
		
		$id = $this->postsDAO->insert ( $params );
		
		$this->assertNotEqual ( $id, 0 );
		
		$this->postsDAO->delete ( $id );
	}
	
	/*
	 * Test to read comment
	 */
	public function testReadComment() {
		$params = [ 
				"user_id" => "1",
				"post_id" => "1",
				"posted_date" => "2012-01-05",
				"title" => "New post",
				"content" => "This is a very insightful post."
		];
		
		$id = $this->postsDAO->insert ( $params );
		
		// get comment by ID
		$resultPost = $this->postsDAO->get ( $id );
		
		$result = $resultPost [0] ["post_id"];
		
		$this->assertEqual ( $result, $id );
		
		$this->postsDAO->delete ( $id );
	}
	
	/*
	 * Test to update comment
	 */
	public function testUpdateComment() {
		$postParams = [ 
				"user_id" => "1",
				"post_id" => "1",
				"posted_date" => "2012-01-05",
				"title" => "New post",
				"content" => "This is a very insightful post."
		];
		
		$id = $this->postsDAO->insert ( $postParams );
		
		$params = [ 
				"user_id" => "1",
				"post_id" => "1",
				"posted_date" => "2012-01-05",
				"title" => "New post",
				"content" => "This is a very insightful post and it's updated too!"
		];
		
		$result = $this->postsDAO->update ( $params, $id );
		
		$this->assertEqual ( $result, 1 );
		
		$this->postsDAO->delete ( $id );
	}
	/*
	 * Test to delete comment
	 */
	public function testDeleteComment() {
		$userParams = [ 
				"user_id" => "1",
				"post_id" => "1",
				"posted_date" => "2012-01-05",
				"title" => "New post",
				"content" => "This is a very insightful post."
		];
		
		$id = $this->postsDAO->insert ( $userParams );
		
		$result = $this->postsDAO->delete ( $id );
		
		// expect delete to delete 0 rows
		$this->assertEqual ( $result, 1 );
	}
	public function tearDown() {
		$this->pdoDbManager->closeConnection ();
		$this->postsDAO = NULL;
	}
}