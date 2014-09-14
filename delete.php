<?php 
	require_once 'core/init.php';

	$user = new User();
    if($user->isLoggedIn()) {

		if(isset($_GET['id'])){
			$id = $_GET['id'];

			$post = new Post();
			try {
		        $post->delete(array('id', '=', $id));
		        //echo 'boom delete';
		    	Redirect::to('index.php');
		    } catch (Exception $e) {
		        die($e->getMessage());
		    }
		}
	} else {
		Redirect::to(404);
	}
?>