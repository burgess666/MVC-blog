<?php
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
	public function get() {
		return ($this->PostsDAO -> get());
	}
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
	public function createNewPost($newPost) {
		// validation of the values of the new post
		
		// compulsory values
		if (! empty ( $newPost ["user_id"] ) && ! empty ( $newPost ["posted_date"] ) && ! empty ( $newPost ["title"] ) && ! empty ( $newPost ["content"] )) {
			/*
			 * the model knows the representation of a post in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
				if ($newPostId = $this->PostsDAO->insert( $newPost ))
					return ($newPostId);
			}
		}
		
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
		
		
	public function searchPostsByTitle($post_title) {
		if (! empty ( $post_title )) {
			$resultSet = $this->PostsDAO-> search( $post_title );
			return $resultSet;
		}
		return false;
	}
	
	public function deletePost($postID) {
		if (is_numeric ( $postID )) {
			$deletedRows = $this->PostsDAO->delete( $postID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	public function getCommentsByPost($postID) {
		if (is_numeric ( $postID ))
			return ($this->PostsDAO->getCommentsByPost( $postID ));
			return false;
	}
	
	public function __destruct() {
		$this->PostsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>