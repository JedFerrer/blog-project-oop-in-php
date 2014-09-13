<?php 
	require_once 'core/init.php';

	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];

	 //    $sql = "SELECT * FROM blog_post WHERE id = '$id'";
  //       $run_sql_query = mysqli_query($con, $sql);
  //     	while($row = mysqli_fetch_array($run_sql_query)) {
  //      		$post_title = $row['post_title'];
		// 	$post_content = $row['post_content'];
		// }
	
		// if($run_sql_query){
		// 	$_SESSION['post_id'] = $id;
		// 	$_SESSION['post_title'] = $post_title;
		// 	$_SESSION['post_content'] = $post_content;
		// 	$_SESSION['edit_checker'] = 'on';
		// 	header('location:blog-home.php');
		// }

		//$post = DB::getInstance()->get('blog_post', array('id', '=', $id));


		// $post = new Post();
		// //$post->get(array('id', '=', $id));
		// if(!$post->count()) {
		//  	echo 'No Data';
		// } else {
		// 	echo 'OK!';
			
		// 	//outputing a single result
		// 	//echo $user->first()->author_name;
		// }


		$post = new Post();
        $search = $post->get($id);

        if($search) {
            //Redirect::to('index.php');
            echo $post->data()->id, '</br>';
            echo $post->data()->post_title;

        } else {
            echo 'Doesnt Exist';
        }

	}

	

	//$user = DB::getInstance()->update('blog_post', 16, array(
	// 	'author_name' => 'NewOOPsample'
	// ));
?>