<?php
/**
 * @author Rich Murphy
 *
 * 	Post model
 *
 */
//require 
require_once "DB/pdoDbManager.php";
require_once "DB/DAOs/PostsDAO.php";
require_once "Validation.php";

class PostModel {
	private $PostsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response

	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->PostsDAO = new PostsDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	
	// get post
	public function get() {
		return ($this->PostsDAO -> get());
	}
	
	//get post with post id
	public function getPost($post_id) {
		if (is_numeric ( $post_id ))
			return ($this->PostsDAO->get( $post_id ));
		
		return false;
	}
	/**
	 *
	 * @param array $PostRepresentation:
	 *        	an associative array containing the detail of the new post
	 */
	//create new post
	public function createNewPost($newPost) {
		// validation of the values of the new post
		if (! empty ( $newPost ["user_id"] ) && ! empty ( $newPost ["posted_date"] ) 
			&& ! empty ( $newPost ["title"] ) 
			&& ! empty ( $newPost ["content"] )) {
				if ($newPostId = $this->PostsDAO->insert( $newPost ))
					return ($newPostId);
			}
		}
		
	//update post 
	public function updatePost($postID, $postNewRepresentation) {
			if (! empty ( $postID ) && is_numeric ( $postID )) {
				// compulsory values
				if (! empty ( $postNewRepresentation ["user_id"] )
						&&! empty ( $postNewRepresentation ["posted_date"] )
						&& ! empty ( $postNewRepresentation ["title"] )
						&& ! empty ( $postNewRepresentation ["content"] )) {
		
					$updatedRows = $this->PostsDAO-> update($postNewRepresentation, $postID);
					if ($updatedRows > 0)
						return (true);
					}
			}
		}
		
	// search post with sililar title
	public function searchPostsByTitle($post_title) {
		if (! empty ( $post_title )) {
			$resultSet = $this->PostsDAO-> search( $post_title );
			return $resultSet;
		}
		return false;
	}
	
	//delete post
	public function deletePost($postID) {
		if (is_numeric ( $postID )) {
			$deletedRows = $this->PostsDAO->delete( $postID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	//search post with related user id
	public function getPostByUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->PostsDAO->getPostsByUser( $userID ));
			return false;
	}
	
	public function __destruct() {
		$this->PostsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>