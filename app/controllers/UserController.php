<?php
/**
 * @author Kaiqiang Huang
 *
 * 	User controller
 *
 */
class UserController {
	private $slimApp;
	private $model;
	private $requestBody;
	
	//construction method
	public function __construct($model, $action = null, $slimApp, $parameteres = null) {
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new user

		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];

			switch ($action) {
				case ACTION_GET_USER :
					$this->getUser ( $id );
					break;
				case ACTION_GET_USERS :
					$this->getUsers ();
					break;
				case ACTION_UPDATE_USER :
					$this->updateUser ( $id, $this->requestBody );
					break;
				case ACTION_CREATE_USER :
					$this->createNewUser ( $this->requestBody );
					break;
				case ACTION_DELETE_USER :
					$this->deleteUser ( $id );
					break;
				case ACTION_SEARCH_USERS :
					$string = $parameteres ["username"];
					$this->searchUsers ( $string );
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
	
	private function getUsers() {
		//call get user method from user model
		$answer = $this->model->get();
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
	
	private function getUser($userID) {
		//call get user with id method from user model
		$answer = $this->model->getUser ( $userID );
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
	
	private function createNewUser($newUser) {
		//call create new user method from user model
		if ($newID = $this->model->createNewUser ( $newUser )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
					"user_id" => "$newID"
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
	
	private function deleteUser($userId) {
		//call delete user method from user model
		if ($this->model->deleteUser ( $userId )) {
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
	
	private function searchUsers($string) {
		//call search user method from user model
		$answer = $this->model->searchUsers ( $string );
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
	
	private function updateUser($userId, $userDetails) {
		//call update user method from user model
		if ($this->model->updateUser ( $userId, $userDetails )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
					"updatedID" => "$userId"
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
}
?>