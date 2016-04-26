<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAOs/CommentsDAO.php";
require_once "Validation.php";

class CommentModel {
	private $CommentsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response

	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->CommentsDAO = new CommentsDAO( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getComments() {
		return ($this->CommentsDAO -> get());
	}
	public function getComment($comment_id) {
		if (is_numeric ( $comment_id ))
			return ($this->CommentsDAO-> get($comment_id));
		
		return false;
	}
	/**
	 *
	 * @param array $CommentRepresentation:
	 *        	an associative array containing the detail of the new comment
	 */
	public function createNewComment($newComment) {
		// validation of the values of the new comment
		
		// compulsory values
		if (! empty ( $newComment ["user_id"] ) && 
			! empty ( $newComment ["post_id"] ) &&
			! empty ( $newComment ["commented_date"] ) && ! empty ( $newComment ["content"])) {
			/*
			 * the model knows the representation of a comment in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
				if ($newCommentId = $this->CommentsDAO->insert( $newComment ))
					return ($newCommentId);
			}
		}
		
	public function searchCommentsByContent($content) {
		if (! empty ( $content )) {
			$resultSet = $this->CommentsDAO-> search( $content );
			return $resultSet;
		}
		return false;
	}
	
	public function deleteComment($commentID) {
		if (is_numeric ( $commentID )) {
			$deletedRows = $this->CommentsDAO-> delete( $commentID );
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	public function updateComment($commentID, $commentNewRepresentation) {
		if (! empty ( $commentID ) && is_numeric ( $commentID )) {
			// compulsory values
			if (! empty ( $commentNewRepresentation ["user_id"] ) 
					&& ! empty ( $commentNewRepresentation ["post_id"] ) 
					&& ! empty ( $commentNewRepresentation ["commented_date"] ) 
					&& ! empty ( $commentNewRepresentation ["content"] )) {
						
					$updatedRows = $this->CommentsDAO-> update($commentNewRepresentation,$commentID);
					if ($updatedRows > 0)
						return (true);
				}
			}
	}
	
	public function __destruct() {
		$this->CommentsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>