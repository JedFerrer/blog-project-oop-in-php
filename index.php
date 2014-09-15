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
                    $paginate = new Pagination();

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
                                        Session::delete('post_title_add');
                                        Session::delete('post_content_add');
                                    } catch (Exception $e) {
                                        die($e->getMessage());
                                    }

                                } else {
?>
                                    <div class="bg-danger validation-errors">
                                    <p>The following errors are encountered</p>
                                        <ul>
<?php
                                            Session::put('post_title_add', Input::get('title'));
                                            Session::put('post_content_add', Input::get('message'));
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
                        <form class="post-form" action="<?php if(Session::exists('edit_checker')) { echo 'update.php'; } else { } ?>" method="POST">
                            <div class="form-group">
                                <p>Title</p>
                                <input type="text" class="form-control" name="title" maxlength="50" value="<?php if (Session::exists('edit_checker')) { echo (Session::exists('post_title')) ?  Session::get('post_title') : ''; } else { echo (Session::exists('post_title_add')) ?  Session::get('post_title_add') : '';  } ?>" placeholder="Title Input">
                                <div class="clear"></div>
                            </div>
                          
                            <div class="form-group">
                                <p>Post</p>
                                <textarea class="form-control" name="message" rows="3" maxlenght="500" placeholder="Post Input"><?php if (Session::exists('edit_checker')) { echo (Session::exists('post_content')) ?  Session::get('post_content') : ''; } else { echo (Session::exists('post_content_add')) ?  Session::get('post_content_add') : ''; } ?></textarea>
                                <div class="clear"></div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                                <button type="submit" class="btn btn-default"><?php if (Session::exists('edit_checker')) { echo 'Update'; } else { echo 'Post'; } ?></button>
                            </div>                        
                        </form>
<?php
                        $paginate->pagination('3', $author_id);
                        $start = $paginate->start();
                        $per_page = $paginate->perpage();
                        $pages = $paginate->pages();
                        $page = $paginate->page();

                        $post = DB::getInstance()->query("SELECT * FROM blog_post WHERE author_id = '$author_id' ORDER BY id DESC LIMIT $start, $per_page");

                    } else {

                        $paginate->pagination('3');
                        $start = $paginate->start();
                        $per_page = $paginate->perpage();
                        $pages = $paginate->pages();
                        $page = $paginate->page();

                        $post = DB::getInstance()->query("SELECT * FROM blog_post ORDER BY id DESC LIMIT $start, $per_page");
                    }

                    if(!$post->count()) {
                        //echo 'There are no posts to show';
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
                                    if($user->isLoggedIn()) {
                                        echo "<a href='update.php?id=".$post->id."'>Edit</a> &nbsp;";
                                        echo "<a href='delete.php?id=".$post->id."'>Delete</a>";
                                    }
?>
                                </div>  
                                <h2 class="devider"></h2>
                            </div> 
<?php
                        }
                    } 
                        $prev = $page - 1;
                        $next = $page + 1;
                        echo '<ul class="pager">';
                        //Prev Pagination
                        if (!($page <= 1)){
                              echo "<li class='previous'><a href='index.php?page=$prev'>&larr; Newer</a></li>";
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
                              echo "<li class='next'><a href='index.php?page=$next'>Older &rarr;</a></li>"; 
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