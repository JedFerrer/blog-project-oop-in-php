<?php 
	require_once 'core/init.php';

	$user = new User();
    if($user->isLoggedIn()) {

    	if ($_SERVER["REQUEST_METHOD"] == "POST") {

    		if(Input::exist()) {
                if(Token::check(Input::get('token'))) {
                    $validate = new validate();
                    $validation = $validate->check($_POST, array(
                        'title' => array(
                            'required' => true
                        ),
                        'message' => array(
                            'required' => true,
                        )
                    ));

                    if($validation->passed()) {
                        $post = new Post();
                        try {
                        	$id = Session::get('post_id');
                        	$excerpt = implode(' ', array_slice(explode(' ', input::get('message')), 0, 50));
                        	$post->update($id, array(
							'post_title' => input::get('title'),
							'post_content' => input::get('message'),
							'post_excerpt' => $excerpt
							));
							unset($_SESSION['edit_checker']);
							Redirect::to('index.php');
                        } catch (Exception $e) {
                             die($e->getMessage());
                        }
                        
                    } else {
						Redirect::to('index.php');
                    }
                }
            }

    	} else {

			if(isset($_GET['id'])) {
				$id = $_GET['id'];
				$post = new Post();
		        $search = $post->get($id);

		        if($search) { 
		        	Session::delete('post_title_add');
                    Session::delete('post_content_add'); 
		            Session::put('edit_checker', 'on');
		            Session::put('post_id', $id);
		            Session::put('post_title', $post->data()->post_title);
		            Session::put('post_content', $post->data()->post_content);
		            Redirect::to('index.php');
		        } else {
		            echo 'Doesnt Exist';
		        }
			}
		}

	} else {
		Redirect::to(404);
	}
?>