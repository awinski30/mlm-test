<?php 
	session_start();
	include "../include/include_allfunc.php";

	$name = Globalfunc::filter($_POST['name']);
	$email = Globalfunc::filter($_POST['email']);
	$comment = Globalfunc::filter($_POST['comment']);
	$ip = Globalfunc::filter(getenv('REMOTE_ADDR'));
	$site = Globalfunc::filter($_POST['site']);

	if($name == '' || $email == '' || $comment == '' ){
		echo "Please fill all blank fields to the comment section.";
	}else{
		Globalfunc::insertcomment($name, $email, $comment,$ip,$site);
		echo Globalfunc::notify(1, "Thank you for sharing your thoughts on us.");
		echo Globalfunc::header_type('./');
	}

 ?>