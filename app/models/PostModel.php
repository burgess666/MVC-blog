<?php
/**
 * @author 	Kaiqiang Huang
 * @desc	This model handles for post.
 *
 */
require_once "DB/pdoDbManager.php";
require_once "DB/DAOs/PostsDAO.php";

class PostsModel {
	private $PostsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response

	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->PostsDAO = new PostsDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getPosts() {
		return ($this->PostsDAO -> getPosts());
	}
	public function getPost($post_id) {
		if (is_numeric ( $post_id ))
			return ($this->PostsDAO->getPost( $post_id ));
		
		return false;
	}
	/**
	 *
	 * @param array $PostRepresentation:
	 *        	an associative array containing the detail of the new post
	 */
	public function createPost($newPost) {
		// validation of the values of the new post
		
		// compulsory values
		if (! empty ( $newPost ["posted_date"] ) && ! empty ( $newPost ["title"] ) && ! empty ( $newPost ["content"] )) {
			/*
			 * the model knows the representation of a post in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
				if ($newPostId = $this->PostsDAO->insertPost( $newPost ))
					return ($newPostId);
			}
		}
		
	public function searchPostsByTitle($post_title) {
		if (! empty ( $post_title )) {
			$resultSet = $this->PostsDAO-> searchPostsByTitle( $post_title );
			return $resultSet;
		}
		return false;
	}
	
	public function deletePost($postID) {
		if (is_numeric ( $postID )) {
			$deletedRows = $this->PostsDAO-> deletePost( $postID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	public function updatePost($postID, $postNewRepresentation) {
		if (! empty ( $postID ) && is_numeric ( $postID )) {
			// compulsory values
			if (! empty ( $postNewRepresentation ["posted_date"] ) 
					&& ! empty ( $postNewRepresentation ["title"] ) 
					&& ! empty ( $postNewRepresentation ["content"] )) {
						
					$updatedRows = $this->PostsDAO-> updatePost( $postID, $postNewRepresentation );
					if ($updatedRows > 0)
						return (true);
				}
			}
	}
	
	public function __destruct() {
		$this->PostsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>