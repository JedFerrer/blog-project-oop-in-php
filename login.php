<?php
	require_once 'core/init.php';
	// Header.php 
	include_once('includes/partials/header.php');
	
	$user = new User();
    if($user->isLoggedIn()) {
    	Redirect::to('index.php');
    }	
?>



<div class="content-container">
	<div class="main-content-centered">
		<div class="form-container">

			<form method="post"  role="form" action="">

				<?php if(Session::exists('home')) { ?>
					<div class="alert alert-success" role="alert">
						<?php echo '<p>' . Session::flash('home') . '</p>' ; ?>
					</div>
				<?php } ?>

				 <div class="form-header-top-container">
				 	<h2><strong>User Login</strong></h2>
				 </div>

<?php 
				 if(Input::exist()) {
			    	if(Token::check(Input::get('token'))) {
			    		$validate = new validate();
			            $validation = $validate->check($_POST, array(
			                'email' => array('required' => true),
			                'pass' => array('required' => true)
			            ));

			            if($validation->passed()) {
			                $user = new User();
			                $login = $user->login(Input::get('email'), Input::get('pass'));

			                if($login) {
			                    Redirect::to('index.php');
			                } else {
			                    //failed
			                    echo '<div class="bg-danger validation-errors">';
						        echo '<p>The following errors are encountered</p>';
						        echo '<ul>';
			                    echo '<li> Login In failed </li>';
			                    echo '</ul>';
								echo '</div>';
			                }

			            } else {
			            	echo '<div class="bg-danger validation-errors">';
					        echo '<p>The following errors are encountered</p>';
					        echo '<ul>';
				            	foreach($validation->errors() as $error) {
				                    echo '<li>', $error, '</li>';
				                }
			                echo '</ul>';
							echo '</div>';
			            }
			    	}
			    }
?>
				 
				 <div class="form-group">
				 	<label for="exampleInputEmail1">Email address</label>
				    	<input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?php echo escape(Input::get('email')); ?>" placeholder="Enter your Email" >
				 </div>
				 <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" >
				 </div>
				 <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
				 <button type="submit" class="btn btn-primary btn-block">Sign In</button>
				 </br> 
			</form>
		</div>

	</div>
</div>



<!-- Footer -->
<?php include_once('includes/partials/footer.php'); ?>