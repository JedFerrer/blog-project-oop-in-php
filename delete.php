<?php 
	require_once 'core/init.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];

		
		$post = new Post();
		try {
	        $post->delete(array('id', '=', $id));
	        // echo 'boom delete';
	        header('location:index.php');
	    } catch (Exception $e) {
	        die($e->getMessage());
	    }
	}

?>