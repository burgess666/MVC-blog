<?php
/**
 * @author Rich Murphy
 * definition of the Artist DAO (database access object)
 */
class PostsDAO {
	private $pdoDbManager;

	function PostsDAO($DBMngr) {
		$this->pdoDbManager = $DBMngr;
		$this->pdoDbManager->openConnection();
	}

	function getPosts() {
		$sql = "SELECT * ";
		$sql .= "FROM posts ";
		$sql .= "ORDER BY post.posted_on; ";

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->executeQuery ( $stmt );
		$arrayOfResults = $this->pdoDbManager->fetchResults ( $stmt );

		if (empty($arrayOfResults)) {
			return null;
		}

		return $arrayOfResults;
	}

	function getPost($id) {
		$sql = "SELECT * ";
		$sql .= "FROM posts ";
		$sql .= "WHERE id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery ( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery ( $stmt );

		$result = $this->pdoDbManager->getNextRow ( $stmt );

		return $result;
	}

	function insertPost($params) {
		//create an INSERT INTO sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)

		$author = $params['author'];
		$title = $params['title'];
		$content = $params['content'];
		$posted_on = $params['posted_on'];

		// preparing query
		$sql = "INSERT INTO posts (author, title, content, posted_on) VALUES (?, ?, ?, ?)";

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->bindValue($stmt, 1, $author, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 2, $title, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 3, $content, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 4, $posted_on, PDO::PARAM_STR);

		// execute the query
		$this->pdoDbManager->executeQuery($stmt);
	}

	function updatePost($id, $params) {
		$sql = "UPDATE posts ";
		$sql .= "SET author = ?, title = ?, content = ?, posted_on = ?";
		$sql .= "WHERE id = ?";

		
		$author = $params['author'];
		$title = $params['title'];
		$content = $params['content'];
		$posted_on = $params['posted_on'];

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->BindValue($stmt, 1, $author, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 2, $title, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 3, $content, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 4, $posted_on, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 5, $id, PDO::PARAM_INT);
		

		$this->pdoDbManager->executeQuery($stmt);
	}

	function deletePost($id) {
		$sql = "DELETE FROM posts ";
		$sql .= "WHERE id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery( $stmt );
	}

	function searchPostsByTitle($searchStr) {
		$sql = "SELECT * FROM posts WHERE title LIKE ? ; ";

		$stmt = $this->pdoDbManager->prepareQuery( $sql );
		
		$searchStr = "%" . $searchStr . "%";
		
		$this->pdoDbManager->bindValue($stmt, 1, $searchStr, PDO::PARAM_STR);

		$this->pdoDbManager->executeQuery( $stmt );

		$arrayOfResults = $this->pdoDbManager->fetchResults ( $stmt );

		if (empty($arrayOfResults)) {
			return null;
		}

		return $arrayOfResults;


	}
	
	function searchPostsByAuthor($searchStr) {
		$sql = "SELECT * FROM posts WHERE author LIKE ? ; ";

		$stmt = $this->pdoDbManager->prepareQuery( $sql );
		
		$searchStr = "%" . $searchStr . "%";
		
		$this->pdoDbManager->bindValue($stmt, 1, $searchStr, PDO::PARAM_STR);

		$this->pdoDbManager->executeQuery( $stmt );

		$arrayOfResults = $this->pdoDbManager->fetchResults ( $stmt );

		if (empty($arrayOfResults)) {
			return null;
		}

		return $arrayOfResults;


	}
}
?>
