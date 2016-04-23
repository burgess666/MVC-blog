<?php
/**
 * @author 	Kaiqiang Huang
 * @desc	This model handles for comment.
 *
 */
require_once "DB/pdoDbManager.php";
require_once "DB/DAOs/CommentsDAO.php";

class CommentsModel {
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
		return ($this->CommentsDAO -> getComments());
	}
	public function getComments($comment_id) {
		if (is_numeric ( $comment_id ))
			return ($this->CommentsDAO-> getComment($comment_id));
		
		return false;
	}
	/**
	 *
	 * @param array $CommentRepresentation:
	 *        	an associative array containing the detail of the new comment
	 */
	public function createComment($newComment) {
		// validation of the values of the new comment
		
		// compulsory values
		if (! empty ( $newComment ["commented_date"] ) && ! empty ( $newComment ["content"])) {
			/*
			 * the model knows the representation of a comment in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
				if ($newCommentId = $this->CommentsDAO->insertComment( $newComment ))
					return ($newCommentId);
			}
		}
		
	public function searchCommentByContent($content) {
		if (! empty ( $content )) {
			$resultSet = $this->CommentsDAO-> searchCommentsByContent( $content );
			return $resultSet;
		}
		return false;
	}
	
	public function deleteComment($commentID) {
		if (is_numeric ( $commentID )) {
			$deletedRows = $this->CommentsDAO-> deleteComment( $commentID );
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	public function updateComment($commentID, $commentNewRepresentation) {
		if (! empty ( $commentID ) && is_numeric ( $commentID )) {
			// compulsory values
			if (! empty ( $commentNewRepresentation ["commented_date"] ) 
					&& ! empty ( $commentNewRepresentation ["content"] )) {
						
					$updatedRows = $this->CommentsDAO-> updateComment( $commentID, $commentNewRepresentation );
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