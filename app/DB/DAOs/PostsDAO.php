<?php
/**
 * @author Rich Murphy
 *
 * 	Post DAO
 *
 */
class PostsDAO {
	private $dbManager;
	
	//construction method
	function PostsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	//select posts from b_post by post_id or not
	public function get($id = null) {
		//sql statement
		$sql = "SELECT * ";
		$sql .= "FROM b_post ";
		if ($id != null)
			$sql .= "WHERE b_post.post_id=? ";
		$sql .= "ORDER BY b_post.post_id ";
		//prepare and bind value
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	//insert post
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
		//return lastest ID
		return ($this->dbManager->getLastInsertedID ());
	}
	
	//update post
	public function update($parametersArray,$postID) {
		// update sql statement
		$sql = "UPDATE b_post SET b_post.user_id = ?,posted_date = ?, title = ?, content = ? WHERE b_post.post_id = ?";
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
	
	//delete post
	public function delete($postID) {
		//sql staement
		$sql = "DELETE FROM b_post ";
		$sql .= "WHERE b_post.post_id = ?";
		//prepare and bind
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $postID, $this->dbManager->INT_TYPE );
		//execute sql
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	
	//search post with similar title
	public function search($str) {
		//sql
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
	
	//select post by user id
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
}
?>
