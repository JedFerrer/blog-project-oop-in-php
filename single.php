<?php 
    require_once 'core/init.php';
    //Header
    include_once('includes/partials/header.php'); 
?>
	<div class="content-container">
	    <div class="main-content-centered">
	        <div class="blog-container">
	            <div>
	                <div class="textbox-wrapper">
<?php 
	                    if(isset($_GET['id'])) {
	                    	Session::delete('post_title_add');
                            Session::delete('post_content_add');
                            Session::delete('edit_checker');
                            

	                        $id = $_GET['id'];
	                        $post = DB::getInstance()->query("SELECT * FROM blog_post WHERE id = '$id'");
	                        if(!$post->count()) {
                            	echo 'There are No Post';
	                        } else {
	                            //looping through the results
	                            foreach($post->results() as $post) { 
?>
	                                <div class="entries-container">
	                                	<?php echo '<a href="index.php" class="sign-up">&larr; Back to Home</a>';?>
		                                <div class="title-date-container">
		                                    <h5><?php echo $post->post_date; ?></h5>
		                                    <h2 class="singles-title"><?php echo $post->post_title; ?></h2>
		                                </div>
		                                <div class="post-content-container">
		                                    <p class="singles-post-content"><?php echo $post->post_content; ?></p>
<?php
	                                        $user = new User();
                							if($user->isLoggedIn()) {
	                                            echo "<a href='update.php?id=".$post->id."'>Edit</a> &nbsp;";
	                                            echo "<a href='delete.php?id=".$post->id."'>Delete</a>";
	                                        }
?>
		                                </div>  
	                                </div> 
<?php
	                            }
	                        } 
	                    }    
?>
	                </div>
	            </div>
	        </div>  
	    </div>
	</div>

<!-- footer -->
<?php include_once('includes/partials/footer.php'); ?>