<?php
/**
 * @author Rich Murphy
 * 
 * 	Unit tests for CommentsDAO.php
 * 
 */
require_once '../../simpletest/autorun.php';
class CommentsDAOTests extends UnitTestCase {
	private $pdoDbManager;
	private $commentsDAO;
	private $id;
	public function setUp() {
		
		require_once '../../app/DB/pdoDbManager.php';
		require_once '../../app/DB/DAOs/CommentsDAO.php';
		
		require_once '../../test/config/config.inc.php';
		
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
				"content" => "Comment ID: " . $this->id,
				"user_id" => "1",
				"post_id" => "1" 
		];
		
		$result = $this->commentsDAO->insert( $params );
		
		// asserting that 1 row has been affected by insertion
		$this->assertEqual ( $result, 1 );
	}
	
	/*
	 * Test to read comment
	 */
	public function testReadComment() {
		
		// get comment by ID
		$resultComment = $this->commentsDAO->get ( 6 );
		
		$result = $resultComment [0]["comment_id"] > 0 ? 1 : 0;
		
		$this->assertEqual ( $result, 1 );
	}
	
	/*
	 * Test to update comment
	 */
	public function testUpdateComment() {
		$params = [ 
				"commented_date" => "2012-01-02",
				"content" => "Updated content text. ID: " . $this->id,
				"user_id" => "1",
				"post_id" => "1"
		];
		
		$result = $this->commentsDAO->update (  $params, 6 );
		
		$this->assertEqual ( $result, 1 );
	}
	/*
	 * Test to delete comment
	 */
	public function testDeleteComment() {
		$result = $this->commentsDAO->delete ( 1 );
		
		// expect delete to delete 0 rows
		$this->assertEqual ( $result, 0 );
	}
	public function tearDown() {
		$this->pdoDbManager->closeConnection ();
		$this->commentsDAO = NULL;
	}
}