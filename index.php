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
                    $user = new User();
                    if($user->isLoggedIn()) {
                        $author_id = $user->data()->id;
                ?>
                <?php 
                        if(Input::exist()) {
                            if(Token::check(Input::get('token'))) {
                                //echo "submitted";
                                //echo Input::get('name');

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
                                        $dateToday = date("Y-m-d");
                                        $excerpt = implode(' ', array_slice(explode(' ', input::get('message')), 0, 50));
                                        $post->create(array(
                                            'post_date' => $dateToday,
                                            'post_title' => input::get('title'),
                                            'post_content' => input::get('message'),
                                            'post_excerpt' => $excerpt,
                                            'author_id' => $author_id
                                        ));
                                    } catch (Exception $e) {
                                        die($e->getMessage());
                                    }

                                } else {
                ?>
                                    <div class="bg-danger validation-errors">
                                    <p>The following errors are encountered</p>
                                        <ul>
                <?php
                                            foreach($validation->errors() as $error) {
                                                echo '<li>', $error, '</li>';
                                            }
                ?>
                                        </ul>
                                    </div>
                <?php
                                }
                            }
                        }
                ?>
                        <form class="post-form" action="" method="POST">
                            <div class="form-group">
                                <p>Title</p>
                                <input type="text" class="form-control" name="title" maxlength="50" value="<?php if(isset($_SESSION['post_title_add'])) { echo $_SESSION['post_title_add']; } ?>" placeholder="Title Input">
                                <div class="clear"></div>
                            </div>
                          
                            <div class="form-group">
                                <p>Post</p>
                                <textarea class="form-control" name="message" rows="3" maxlenght="500" placeholder="Post Input"><?php if(isset($_SESSION['post_title_add'])) { echo $_SESSION['post_content_add']; } ?></textarea>
                                <div class="clear"></div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                                <button type="submit" class="btn btn-default">Post</button>
                            </div>                        
                        </form>
                <?php

                           
                        $post = DB::getInstance()->query("SELECT * FROM blog_post WHERE author_id = '$author_id' ORDER BY id DESC LIMIT 10");
                    
                        if(!$post->count()) {
                            echo 'No user';
                        } else {
                            //looping through the results
                            foreach($post->results() as $post) { 
                        ?>
                                <div class="entries-container">
                                <div class="title-date-container">
                                    <h5><?php echo $post->post_date; ?></h5>
                                    <h2><?php echo "<a href='single.php?id=".$post->id."'>".$post->post_title."</a> &nbsp;"; ?></h2>
                                </div>
                                <div class="post-content-container">
                                    <p><?php echo $post->post_excerpt; ?></p>
                                        <?php
                                            echo "<a href='update.php?id=".$post->id."'>Edit</a> &nbsp;";
                                            echo "<a href='delete.php?id=".$post->id."'>Delete</a>";
                                        ?>
                                    </div>  
                                    <h2 class="devider"></h2>
                                </div> 
                <?php
                            }

                        } 
                    } else {
                        $post = DB::getInstance()->query("SELECT * FROM blog_post ORDER BY id DESC LIMIT 10");

                        if(!$post->count()) {
                            echo 'No user';
                        } else {
                            //echo 'OK!';
                            //looping through the results
                            foreach($post->results() as $post) {
                ?>
                                <div class="entries-container">
                                <div class="title-date-container">
                                    <h5><?php echo $post->post_date; ?></h5>
                                    <h2><?php echo "<a href='single.php?id=".$post->id."'>".$post->post_title."</a> &nbsp;"; ?></h2>
                                </div>
                                <div class="post-content-container">
                                    <p><?php echo $post->post_excerpt; ?></p>
                                    </div>  
                                    <h2 class="devider"></h2>
                                </div> 
                <?php
                            }
                        } 
                    }
                ?>
            
                
                    <?php if(isset($_SESSION['myemail'])) { ?>
                     
                        <?php if((isset($_SESSION['title_Err_Add'])) or (isset($_SESSION['message_Err_Add']))) { ?>
                            <div class="bg-danger validation-errors">
                            <p>The following errors are encountered</p>
                                <ul>
                                    <?php if ($_SESSION['title_Err_Add'] != ''){ ?>
                                        <li> <?php echo $_SESSION['title_Err_Add']; ?> </li>
                                    <?php } ?>
                                    <?php if ($_SESSION['message_Err_Add'] != ''){ ?>
                                        <li> <?php echo $_SESSION['message_Err_Add']; ?> </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                        <?php if((isset($_SESSION['title_Err_Edit'])) or (isset($_SESSION['message_Err_Edit']))) { ?>
                            <div class="bg-danger validation-errors">
                            <p>The following errors are encountered</p>
                                <ul>
                                    <?php if ($_SESSION['title_Err_Edit'] != ''){ ?>
                                        <li> <?php echo $_SESSION['title_Err_Edit']; ?> </li>
                                    <?php } ?>
                                    <?php if ($_SESSION['message_Err_Edit'] != ''){ ?>
                                        <li> <?php echo $_SESSION['message_Err_Edit']; ?> </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                        <?php if(isset($_SESSION['edit_checker'])) { ?>

                            <?php //unset($_SESSION['edit_checker']);?>
                            <form class="post-form" action="edit-post.php" method="POST">
                                <div class="form-group">
                                    <p>Title</p>
                                    <input type="text" class="form-control" name="title" maxlength="50" value="<?php echo $_SESSION['post_title']; ?>" placeholder="Title Input">
                                    <div class="clear"></div>
                                </div>
                              
                                <div class="form-group">
                                    <p>Post</p>
                                    <textarea class="form-control" name="message" rows="3" maxlenght="500" placeholder="Post Content"><?php echo $_SESSION['post_content']; ?></textarea>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Update Post</button>
                                </div>                        
                            </form>

                        <?php } else { ?>
                           

                            <form class="post-form" action="add-post.php" method="POST">
                                <div class="form-group">
                                    <p>Title</p>
                                    <input type="text" class="form-control" name="title" maxlength="50" value="<?php if(isset($_SESSION['post_title_add'])) { echo $_SESSION['post_title_add']; } ?>" placeholder="Title Input">
                                    <div class="clear"></div>
                                </div>
                              
                                <div class="form-group">
                                    <p>Post</p>
                                    <textarea class="form-control" name="message" rows="3" maxlenght="500" placeholder="Post Input"><?php if(isset($_SESSION['post_title_add'])) { echo $_SESSION['post_content_add']; } ?></textarea>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Post</button>
                                </div>                        
                            </form>

                        <?php } ?>

                    <?php } ?>

                    <?php 

                    $per_page = 3;
                    if(isset($_SESSION['myemail'])) {
                        $author_id = $_SESSION['author_id'];
                        $pages_query = ("SELECT * FROM blog_post WHERE author_id = '$author_id'");
                    } else {
                        $pages_query = ("SELECT * FROM blog_post");
                    }
                    $run_pages_query = mysqli_query($con, $pages_query);
                    $data_count = mysqli_num_rows($run_pages_query);
                    $pages = ceil($data_count / $per_page);

                    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $per_page;


                        if(isset($_SESSION['myemail'])) {
                            $author_id = $_SESSION['author_id'];
                            //$sql = "SELECT * FROM blog_post WHERE author_id = '$author_id' ORDER BY id DESC LIMIT 10";
                            $sql = "SELECT * FROM blog_post WHERE author_id = '$author_id' ORDER BY id DESC LIMIT $start, $per_page";
                            $run_sql_query = mysqli_query($con, $sql);

                        } else {
                            //$sql = "SELECT * FROM blog_post ORDER BY id DESC LIMIT 10";
                            $sql = "SELECT * FROM blog_post ORDER BY id DESC LIMIT $start, $per_page";
                            $run_sql_query = mysqli_query($con, $sql);
                            
                        }

                        while($query2 = mysqli_fetch_array($run_sql_query)) {
                    ?>

                            <div class="entries-container">
                                <div class="title-date-container">
                                    <h5><?php echo $query2['post_date']; ?></h5>
                                    <h2><?php echo "<a href='single.php?id=".$query2['id']."'>".$query2['post_title']."</a> &nbsp;"; ?></h2>
                                </div>
                                <div class="post-content-container">
                                    <p><?php echo $query2['post_excerpt']; ?></p>
                                    <?php 
                                        if(isset($_SESSION['myemail'])) { 
                                            echo "<a href='edit-post.php?id=".$query2['id']."'>Edit</a> &nbsp;";
                                            echo "<a href='delete-post.php?id=".$query2['id']."'>Delete</a>";
                                        }
                                    ?>
                                </div>  
                                <h2 class="devider"></h2>
                            </div> 

                    <?php } ?>

                    <?php
                        $prev = $page - 1;
                        $next = $page + 1;
                        echo '<ul class="pager">';
                        //Prev Pagination
                        if (!($page <= 1)){
                              echo "<li class='previous'><a href='blog-home.php?page=$prev'>&larr; Older</a></li>";
                        }

                        if($pages >= 1){
                            for($x=1; $x<=$pages; $x++){                                  
                                if ($x == $page) {
                                    $active_page = $x;
                                }
                            }
                        }
                       

                        //Next Pagination
                        if (!($page >= $pages)){

                              echo "<li class='next'><a href='blog-home.php?page=$next'>Newer &rarr;</a></li>"; 
                        }
                        echo '</ul>';

                        echo  "<h1 class='page-number'>Page ".$active_page." of ".$pages."</h1>";

                        
                    ?>

            

                </div>
            </div>
        </div>  
    </div>
</div>


<?php include_once('includes/partials/footer.php'); ?>