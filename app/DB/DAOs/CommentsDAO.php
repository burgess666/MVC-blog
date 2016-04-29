<?php
/**
 * @author Kaiqiang Huang
 *
 * 	Comment DAO
 *
 */
class CommentsDAO {
	private $dbManager;
	
	//construction method
	function CommentsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	//select comments with id
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM b_comment ";
		if ($id != null)
		$sql .= "WHERE b_comment.comment_id=? "; 
		$sql .= "ORDER BY b_comment.comment_id ";
		//prepare query
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	//insert comment
	public function insert($parametersArray) {
		// insert sql created
		$sql = "INSERT INTO b_comment (user_id, post_id,commented_date, content) ";
		$sql .= "VALUES (?,?,?,?) ";
		//prepare query
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["post_id"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["commented_date"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], $this->dbManager->STRING_TYPE );
		//execute
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		
		return $this->dbManager->getLastInsertedID();
	}
	
	//update comment
	public function update($parametersArray,$commentID) {
		// update sql statement 
		$sql = "UPDATE b_comment SET user_id = ?,post_id = ?, commented_date = ?, content = ? WHERE b_comment.comment_id = ?";
		//prepare query		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["user_id"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["post_id"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["commented_date"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["content"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 5, $commentID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		//return the number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	
	//delete sql
	public function delete($commentID) {
		//sql
		$sql = "DELETE FROM b_comment ";
		$sql .= "WHERE b_comment.comment_id = ?";
		//prepare and bind value
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $commentID, $this->dbManager->INT_TYPE );
		//execute query
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	
	//search comment with similar content
	public function search($str) {
		//sql statement
		$sql = "SELECT * ";
		$sql .= "FROM b_comment ";
		$sql .= "WHERE b_comment.content LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY b_comment.comment_id ";
		//prepare and bind value
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		//execute
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		//return results by row
		return ($rows);
	}
	
	//search comments by specific user
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
	
	//search comments by specific post
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
		//fetch result
		$rows = $this->dbManager->fetchResults ( $stmt );
		return ($rows);
	}
}
?>
