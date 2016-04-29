<?php
class CommentsDAO {
	private $dbManager;
	function CommentsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM b_comment ";
		if ($id != null)
		$sql .= "WHERE b_comment.comment_id=? "; 
		$sql .= "ORDER BY b_comment.comment_id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO b_comment (user_id, post_id,commented_date, content) ";
		$sql .= "VALUES (?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["post_id"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["commented_date"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		
		return $rowCount;
	}
	
	public function update($parametersArray,$commentID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE b_comment SET user_id = ?,post_id = ?, commented_date = ?, content = ? WHERE b_comment.comment_id = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["post_id"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["commented_date"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 5, $commentID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		
		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	public function delete($commentID) {
		$sql = "DELETE FROM b_comment ";
		$sql .= "WHERE b_comment.comment_id = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $commentID, $this->dbManager->INT_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM b_comment ";
		$sql .= "WHERE b_comment.content LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY b_comment.comment_id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
}
?>
