<?php
/**
 * @author Kaiqiang Huang
 *
 * 	Comment model
 *
 */

//require indeed files
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
	
	//get comments
	public function getComments() {
		return ($this->CommentsDAO -> get());
	}
	
	//get comments with comment id
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
	//create new comment
	public function createNewComment($newComment) {
		// validation of the values of the new comment

		if (! empty ( $newComment ["user_id"] ) && 
			! empty ( $newComment ["post_id"] ) &&
			! empty ( $newComment ["commented_date"] ) && ! empty ( $newComment ["content"])) {
				if ($newCommentId = $this->CommentsDAO->insert( $newComment ))
					return ($newCommentId);
			}
		}
		
	// search comment with similar content
	public function searchCommentsByContent($content) {
		if (! empty ( $content )) {
			$resultSet = $this->CommentsDAO-> search( $content );
			return $resultSet;
		}
		return false;
	}
	
	//delete comment
	public function deleteComment($commentID) {
		if (is_numeric ( $commentID )) {
			$deletedRows = $this->CommentsDAO-> delete( $commentID );
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	//update comment
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
	
	//get comment with related user id
	public function getCommentsByUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->CommentsDAO->getCommentsByUser( $userID ));
			return false;
	}
	
	//search comments with related post id
	public function getCommentsByPost($postID) {
		if (is_numeric ( $postID ))
			return ($this->CommentsDAO->getCommentsByPost( $postID ));
			return false;
	}
	
	public function __destruct() {
		$this->CommentsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>