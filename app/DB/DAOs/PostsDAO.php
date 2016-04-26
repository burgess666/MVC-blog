<?php
class PostsDAO {
	private $dbManager;
	function PostsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM b_post ";
		if ($id != null)
			$sql .= "WHERE b_post.post_id=? ";
		$sql .= "ORDER BY b_post.post_id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO b_post (user_id, posted_date,title, content) ";
		$sql .= "VALUES (?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["posted_date"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["title"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray,$postID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE b_post SET b_post.user_id = ?,posted_date = ?, title = ?, content = ? WHERE b_post.post_id = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["posted_date"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["title"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 5, $postID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		
		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	public function delete($postID) {
		$sql = "DELETE FROM b_post ";
		$sql .= "WHERE b_post.post_id = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $postID, $this->dbManager->INT_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM b_post ";
		$sql .= "WHERE b_post.title LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY b_post.post_id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function getCommentsByPost($postID) {
		//sql statement
		$sql = "SELECT b_post.post_id,b_post.title, b_comment.comment_id, b_comment.content, b_comment.commented_date, b_comment.user_id ";
		$sql .= "FROM b_comment JOIN b_post ON b_comment.post_id = b_post.post_id ";
		$sql .= " WHERE b_post.post_id = ? ";
		$sql .= "ORDER BY b_comment.comment_id";
		//prepare sql
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $postID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		return ($rows);
	}
}
?>
