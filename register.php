<?php
	require_once 'core/init.php';
	// Header.php 
	include_once('includes/partials/header.php');
?>

	<div class="content-container">
	    <div class="main-content-centered">
	        <div class="form-fit-container">

	            <form method="post" role="form" action="">
	               
	                 <div class="form-header-top-container">
	                    <h2><strong>Sign Up</strong></h2>
	                 </div>
<?php 
						if(Input::exist()) {
							if(Token::check(Input::get('token'))) {
							    //echo "submitted";
							    //echo Input::get('name');

							    $validate = new validate();
							    $validation = $validate->check($_POST, array(
							        'name' => array(
							            'required' => true
							        ),
							        'email' => array(
							            'required' => true,
							            'valid' => true,
							            'unique' => 'blog_users'
							        ),
							        'pass' => array(
							            'required' => true
							        ),
							        'rpass' => array(
							            'required' => true,
							            'matches' => 'pass'
							        )
							    ));

							    if($validation->passed()) {
							        //echo 'passed';
							        $user = new User();

							        try {

							            $user->create(array(
							                'author_name' => input::get('name'),
							                'user_email' => input::get('email'),
							                'user_pass' => md5(input::get('pass'))
							            ));

							            session::flash('home', 'You have been registered and can now log in!');
							            
							            Redirect::to('login.php');
							        } catch (Exception $e) {
							            die($e->getMessage());
							        }
							    } else {
							        //print_r($validation->errors());
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
	                    <label for="yourName">Name<span class="required">*</span>:</label>
	                    <input type="text" name="name" class="form-control" id="yourName" value="<?php echo escape(Input::get('name')); ?>" placeholder="Enter your Name" maxlength="50" >
	                 </div>
	                 <div class="form-group">
	                    <label for="exampleInputEmail1">Email address<span class="required">*</span>:</label>
	                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?php echo escape(Input::get('email')); ?>" placeholder="Enter your Email" maxlength="50" >
	                 </div>
	                 <div class="form-group">
	                    <label for="exampleInputPassword1">Password<span class="required">*</span>:</label>
	                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" maxlength="50" >
	                 </div>
	                  <div class="form-group">
	                    <label for="repeatPassword">Re-enter Password<span class="required">*</span>:</label>
	                    <input type="password" name="rpass" class="form-control" id="repeatPassword" placeholder="Repeat Password" maxlength="50" >
	                 </div>
	                 
	                 <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	                 <button type="submit" class="btn btn-primary btn-block">Sign Up</button>

	                 </br>	 
	            </form>

	        </div>
	    </div>
	</div>  

<!-- Footer -->
<?php include_once('includes/partials/footer.php'); ?>