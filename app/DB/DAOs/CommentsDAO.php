<?php
class CommentsDAO {
	private $pdoDbManager;

	function CommentsDAO($DBMngr) {
		$this->pdoDbManager = $DBMngr;
		$this->pdoDbManager->openConnection();
	}

	function getComments() {
		$sql = "SELECT * ";
		$sql .= "FROM b_comment";
		$sql .= "ORDER BY b_comment.comment_id; ";

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->executeQuery ( $stmt );
		$arrayOfResults = $this->pdoDbManager->fetchResults ( $stmt );

		if (empty($arrayOfResults)) {
			return null;
		}

		return $arrayOfResults;
	}

	function getComment($id) {
		$sql = "SELECT * ";
		$sql .= "FROM b_comment";
		$sql .= "WHERE comment_id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery ( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery ( $stmt );

		$result = $this->pdoDbManager->getNextRow ( $stmt );

		return $result;
	}

	function insertComment($params) {
		//create an INSERT INTO sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)

		$commented_date = $params['commented_date'];
		$content = $params['content'];

		// preparing query
		$sql = "INSERT INTO b_content (commented_date, content) VALUES (?, ?)";
		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->bindValue($stmt, 1, $commented_date, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 2, $content, PDO::PARAM_STR);
		
		// execute the query
		$this->pdoDbManager->executeQuery($stmt);
	}

	function updateComment($id, $params) {
		$sql = "UPDATE b_comment ";
		$sql .= "SET commented_date = ?, content = ?";
		$sql .= "WHERE comment_id = ?";

		$commented_date = $params['commented_date'];
		$content = $params['content'];

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->BindValue($stmt, 1, $commented_date, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 2, $content, PDO::PARAM_STR);
		$this->pdoDbManager->executeQuery($stmt);
	}

	function deleteComment($id) {
		$sql = "DELETE FROM b_comment ";
		$sql .= "WHERE comment_id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery( $stmt );
	}

	
	function searchCommentsByContent($searchStr) {
		$sql = "SELECT * FROM b_comment WHERE content LIKE ? ; ";

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
