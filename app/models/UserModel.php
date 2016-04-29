<?php
/**
 * @author Kaiqiang Huang
 *
 * 	user model
 *
 */
//require inside files
require_once "DB/pdoDbManager.php";
require_once "DB/DAOs/UsersDAO.php";
require_once "Validation.php";

// user model class
class UserModel {
	private $UsersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	//construction method
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->UsersDAO = new UsersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	// get method
	public function get() {
		return ($this->UsersDAO->get ());
	}
	
	//get user with id
	public function getUser($userID) {
		if (is_numeric ($userID))
			return ($this->UsersDAO->get ( $userID ));
		return false;
	}
	
	// authenticate user
	public function authUser($uname, $pid) {
		// is alphanumeric username
		if (ctype_alnum( $uname )) {
			return ($this->UsersDAO->getUser ( $uname, $pid ));
		}
		return false;
	}
	/**
	 * @param array $UserRepresentation:
	 *        	an associative array containing the detail of the new user
	 */
	// the function of create new user
	public function createNewUser($newUser) {
		// validation of the values of the new user: username, email, passwd
		if (! empty ( $newUser ["username"] ) && ! empty ( $newUser ["email"] ) && ! empty ( $newUser ["passwd"] )) {
			if (($this->validationSuite->isLengthStringValid ( $newUser ["username"], TABLE_USER_SURNAME_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $newUser ["email"], TABLE_USER_EMAIL_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $newUser ["passwd"], TABLE_USER_PASSWORD_LENGTH ))) {
				if ($newId = $this->UsersDAO->insert ( $newUser ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	
	// the function of search user with user id
	public function searchUsers($string) {
		if (! empty ( $string )) {
			$resultSet = $this->UsersDAO->search ( $string );
			return $resultSet;
		}
		return false;
	}
	
	//the function of delete user id
	public function deleteUser($userID) {
		if (is_numeric ( $userID )) {
			$deletedRows = $this->UsersDAO->delete ( $userID );
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	
	//the function of update user
	public function updateUser($userID, $userNewRepresentation) {
		if (! empty ( $userID ) && is_numeric ( $userID )) {
			// compulsory values
			if (! empty ( $userNewRepresentation ["username"] ) && 
				! empty ( $userNewRepresentation ["email"] ) && 
				! empty ( $userNewRepresentation ["passwd"] )) {
				if (($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["username"], TABLE_USER_SURNAME_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["passwd"], TABLE_USER_PASSWORD_LENGTH ))) {
					$updatedRows = $this->UsersDAO->update ( $userNewRepresentation, $userID );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	
	//the function of search post
	public function getPostByUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->UsersDAO->getPostsByUser( $userID ));
			return false;
	}
	
	public function getCommentsByUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->UsersDAO->getCommentsByUser( $userID ));
			return false;
	}
	
	public function __destruct() {
		$this->UsersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>