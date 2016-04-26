<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "config/config.inc.php";

$app->map ( "/users(/:id)", function ($userID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($userID != null)
					$action = ACTION_GET_USER;
				else
					$action = ACTION_GET_USERS;
				break;
			case "POST" :
				$action = ACTION_CREATE_USER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_USER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_USER;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );


$app->map ( "/users/search(/:string)", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["username"] = $searchString; // prepare parameters to be passed to the controller (example: ID)
	if (($searchString == null) or is_string( $searchString )) {
		switch ($httpMethod) {
			case "GET" :
				$action = ACTION_SEARCH_USERS;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET");

$app->map ( "/posts(/:id)", function ($postID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $postID; // prepare parameters to be passed to the controller (example: ID)

	if (($postID == null) or is_numeric ( $postID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($postID != null)
					$action = ACTION_GET_POST;
					else
						$action = ACTION_GET_POSTS;
						break;
			case "POST" :
				$action = ACTION_CREATE_POST;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_POST;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_POST;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "PostModel", "PostController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/posts/search(/:string)", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["title"] = $searchString; // prepare parameters to be passed to the controller (example: ID)
	if (($searchString == null) or is_string( $searchString )) {
		switch ($httpMethod) {
			case "GET" :
				$action = ACTION_SEARCH_POSTS;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "PostModel", "PostController", "jsonView", $action, $app, $parameters );
} )->via ( "GET");

$app->map ( "/comments(/:id)", function ($commentID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $commentID; // prepare parameters to be passed to the controller (example: ID)

	if (($commentID == null) or is_numeric ( $commentID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($commentID != null)
					$action = ACTION_GET_COMMENT;
					else
						$action = ACTION_GET_COMMENTS;
						break;
			case "POST" :
				$action = ACTION_CREATE_COMMENT;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_COMMENT;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_COMMENT;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "CommentModel", "CommentController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/comments/search(/:string)", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["content"] = $searchString; // prepare parameters to be passed to the controller (example: ID)
	if (($searchString == null) or is_string( $searchString )) {
		switch ($httpMethod) {
			case "GET" :
				$action = ACTION_SEARCH_COMMENTS;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "CommentModel", "CommentController", "jsonView", $action, $app, $parameters );
} )->via ( "GET");
$app->run ();

class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName (); // common model
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app, $app->headers ); // common view
		$view->output (); // this returns the response to the requesting client
	}
}

?>