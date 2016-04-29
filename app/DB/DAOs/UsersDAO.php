<?php
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM b_user ";
		if ($id != null)
			$sql .= "WHERE b_user.user_id=? ";
		$sql .= "ORDER BY b_user.user_id ";
		
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
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO b_user (username, email, passwd) ";
		$sql .= "VALUES (?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["passwd"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $userID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE b_user SET username = ?,email = ?, passwd = ? WHERE user_id = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["email"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["passwd"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $userID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		
		// check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function delete($userID) {
		$sql = "DELETE FROM b_user ";
		$sql .= "WHERE b_user.user_id = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $userID, $this->dbManager->INT_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM b_user ";
		$sql .= "WHERE b_user.username LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY b_user.username ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function getPostsByUser($userID) {
		//sql statement
		$sql = "SELECT b_user.user_id,b_user.username, b_post.post_id, b_post.title, b_post.content, b_post.posted_date ";
		$sql .= "FROM b_user JOIN b_post ON b_user.user_id = b_post.user_id ";
		$sql .= " WHERE b_user.user_id = ? ";
		$sql .= "ORDER BY b_post.post_id";
		//prepare sql
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $userID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );	
		return ($rows);
	}
	
	public function getCommentsByUser($userID) {
		//sql statement
		$sql = "SELECT b_user.user_id,b_user.username, b_post.title, b_comment.comment_id, b_comment.content, b_comment.commented_date ";
		$sql .= "FROM b_user JOIN b_comment JOIN b_post ON b_user.user_id = b_comment.user_id AND b_post.post_id = b_comment.post_id ";
		$sql .= " WHERE b_user.user_id = ? ";
		$sql .= "ORDER BY b_comment.comment_id";
		//prepare sql
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $userID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		return ($rows);
	}
}
?>
