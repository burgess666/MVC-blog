<?php
/**
 * @author Kaiqiang Huang
 * definition of the User DAO (database access object)
 */
// Notice: the attribute of b_user table, user_id, has to be modified with auto_increment;
class UsersDAO {
	private $pdoDbManager;

	function UsersDAO($DBMngr) {
		$this->pdoDbManager = $DBMngr;
		$this->pdoDbManager->openConnection();
	}

	function getUsers() {
		$sql = "SELECT * ";
		$sql .= "FROM b_user";
		$sql .= "ORDER BY b_user.user_id; ";

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->executeQuery ( $stmt );
		$arrayOfResults = $this->pdoDbManager->fetchResults ( $stmt );

		if (empty($arrayOfResults)) {
			return null;
		}

		return $arrayOfResults;
	}

	function getUser($id) {
		$sql = "SELECT * ";
		$sql .= "FROM b_user";
		$sql .= "WHERE user_id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery ( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery ( $stmt );

		$result = $this->pdoDbManager->getNextRow ( $stmt );

		return $result;
	}

	function insertUser($params) {
		//create an INSERT INTO sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)

		$username = $params['username'];
		$email = $params['email'];
		$passwd = $params['passwd'];

		// preparing query
		$sql = "INSERT INTO b_user (username, email, passwd) VALUES (?, ?, ?)";
		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->bindValue($stmt, 1, $username, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 2, $email, PDO::PARAM_STR);
		$this->pdoDbManager->bindValue($stmt, 3, $passwd, PDO::PARAM_STR);

		// execute the query
		$this->pdoDbManager->executeQuery($stmt);
	}

	function updateUser($id, $params) {
		$sql = "UPDATE b_user ";
		$sql .= "SET username = ?, email = ?, passwd = ?";
		$sql .= "WHERE user_id = ?";

		$username = $params['username'];
		$email = $params['email'];
		$passwd = $params['passwd'];

		$stmt = $this->pdoDbManager->prepareQuery($sql);

		$this->pdoDbManager->BindValue($stmt, 1, $username, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 2, $email, PDO::PARAM_STR);
		$this->pdoDbManager->BindValue($stmt, 3, $passwd, PDO::PARAM_STR);

		$this->pdoDbManager->executeQuery($stmt);
	}

	function deleteUser($id) {
		$sql = "DELETE FROM b_user ";
		$sql .= "WHERE user_id = ?; ";

		$stmt = $this->pdoDbManager->prepareQuery( $sql );

		$this->pdoDbManager->bindValue($stmt, 1, $id, PDO::PARAM_INT);

		$this->pdoDbManager->executeQuery( $stmt );
	}

	
	function searchUsersByUserame($searchStr) {
		$sql = "SELECT * FROM b_user WHERE username LIKE ? ; ";

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
