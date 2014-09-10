<?php
	session_start();

	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'db' => 'blog-sample'
		),
		'session' => array(
			'session_name' => 'user',
			'token_name' => 'token'
		)
	);

	//autoloods the class that is used
	spl_autoload_register(function($class) {
		require_once 'classes/' . $class . '.php';
	});

	//loads sanitize.php
	require_once 'functions/sanitize.php';
?>

