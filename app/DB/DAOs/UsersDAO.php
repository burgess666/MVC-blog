<?php
/**
 * @author Kaiqiang Huang
 *
 * 	User DAO
 *
 */
class UsersDAO {
	private $dbManager;
	
	//construction method
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	//select users by id or not
	public function get($id = null) {
		//select sql statment with id 
		$sql = "SELECT * ";
		$sql .= "FROM b_user ";
		if ($id != null)
			$sql .= "WHERE b_user.user_id=? ";
		$sql .= "ORDER BY b_user.user_id ";
		//prepare query and bind user id with ?
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		return ($rows);
	}
	
	public function getUser($uid, $pid) {
		$sql = "SELECT * FROM b_user ";
		$sql .= "WHERE username = ? AND passwd = ?";
	
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $uid, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $pid, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		return $this->dbManager->fetchResults ( $stmt );
	}
	
	//insert user
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO b_user (username, email, passwd) ";
		$sql .= "VALUES (?,?,?) ";
		//prepare stage and bind value
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["passwd"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		//return the lastest ID by insertion 
		return ($this->dbManager->getLastInsertedID ());
	}
	
	//update user
	public function update($parametersArray, $userID) {
		// /create an UPDATE sql statement 
		$sql = "UPDATE b_user SET username = ?,email = ?, passwd = ? WHERE user_id = ?";
		//$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["email"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["passwd"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $userID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	
	//delete user
	public function delete($userID) {
		//sql statement
		$sql = "DELETE FROM b_user ";
		$sql .= "WHERE b_user.user_id = ?";
		//prepare query and bind value with parameter
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $userID, $this->dbManager->INT_TYPE );
		//execute query
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	
	//search user by similar username
	public function search($str) {
		//sql statement
		$sql = "SELECT * ";
		$sql .= "FROM b_user ";
		$sql .= "WHERE b_user.username LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY b_user.username ";
		//prepare query and bind value with parameter
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		return ($rows);
	}
}
?>
