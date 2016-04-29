<?php
/**
 * @author Kaiqiang Huang
 * 
 * 	Comment controller
 * 
 */
class CommentController {
	
	private $slimApp;
	private $model;
	private $requestBody;
	
	//construction methods
	public function __construct($model, $action = null, $slimApp, $parameteres = null) {
		$this->model = $model;
		$this->slimApp = $slimApp;
		// this must contain the representation of the new user
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); 

		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];

			switch ($action) {
				case ACTION_GET_COMMENT :
					$this->getComment ( $id );
					break;
				case ACTION_GET_COMMENTS :
					$this->getComments ();
					break;
				case ACTION_UPDATE_COMMENT :
					$this->updateComment ( $id, $this->requestBody );
					break;
				case ACTION_CREATE_COMMENT :
					$this->createNewComment ( $this->requestBody );
					break;
				case ACTION_DELETE_COMMENT :
					$this->deleteComment ( $id );
					break;
				case ACTION_SEARCH_COMMENTS :
					$string = $parameteres ["content"];
					$this->searchComments( $string );
					break;
				case ACTION_SEARCH_COMMENTBYUSER :
					$this->getCommentsByUser($id);
					break;
				case ACTION_SEARCH_COMMENTBYPOST :
					$this->getCommentsByPost($id);
					break;
				case null :
					$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
					$Message = array (
							GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
					);
					$this->model->apiResponse = $Message;
					break;
			}
	}
	
	private function getComments() {
		//call get comment method from commentmodel
		$answer = $this->model->getComments();
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function getComment($commentID) {
		//call get comment with its id method from commentmodel
		$answer = $this->model->getComment ( $commentID );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
				
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function createNewComment($newComment) {
		//call create new comment method from commentmodel
		if ($newID = $this->model->createNewComment ( $newComment )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
					"COMMENT_id" => "$newID"
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function updateComment($commentId, $commentDetails) {
		//call update comment method from commentmodel
		if ($this->model->updateComment ( $commentId, $commentDetails )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
					"updatedID" => "$commentId"
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function deleteComment($commentID) {
		//call delete comment method from commentmodel
		if ($this->model->deleteComment( $commentID )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_ERROR_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function searchComments($string) {
		//call search comment method from commentmodel
		$answer = $this->model->searchCommentsByContent ( $string );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			//give response message
			$this->model->apiResponse = $Message;
		}
	}
	
	private function getCommentsByUser($userID) {
		//call get comment by user id method from commentmodel
		$answer = $this->model->getCommentsByUser( $userID );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function getCommentsByPost($postID) {
		//call get comment by post id method from commentmodel
		$answer = $this->model->getCommentsByPost( $postID );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
}
?>