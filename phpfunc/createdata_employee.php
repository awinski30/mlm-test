<?php 
	session_start();
	include "../include/include_allfunc.php";

	$type = 'emp';
	$ip = $glob->filter(getenv('REMOTE_ADDR'));

	if($type == 'emp'){

		$st = $_POST['s_type'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$bday = $_POST['bday'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$icoe = $_POST['icoe'];
		$addr = $_POST['addr'];
		$hdate = $_POST['hdate'];
		$sdate = $_POST['sdate'];
		$dleft = $_POST['dleft'];

		//account details 
		$uname = $_POST['uname'];
		$pword = $_POST['pword'];
		$company = $_POST['company'];
		$position = $_POST['position'];




		//image upload
		if(!empty($_FILES)){
		//uploadfiles for temporary view only
	 	
		         			$target= '../upload_img/profile/';
		     				

                             
                              //Get the temp file path
                              $tmpFilePath = $_FILES['profile_img']['tmp_name'];

                              //save the filename
                              $shortname = $_FILES['profile_img']['name'];

                              //save the url and the file
                              $filePath = $target.''. date('d-m-Y-H-i-s').'-'.$_FILES['profile_img']['name'];
                              // var_dump($filePath);
                              $newname = date('d-m-Y-H-i-s').'-'.$_FILES['profile_img']['name'];
                              //Upload the file into the temp dir
                              move_uploaded_file($tmpFilePath, $filePath);
 
	
		}else{
			echo $glob->notify(2, "Upload his profile picture first.");
			die();
		}

// echo  "<pre>";
// 		var_dump($_POST);
// 		die();
// 		echo  "</pre>";


		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//insert to db 
		$returnid = $db->insert('settings', 'settings,type,status,date_registered', '"'.$fname.' '.$lname.'","'.$st.'","1",now()', 1 );
		
		//create user login with id return
		$usersid = $db->insert('tbl_users', 'uname,pass,address,contact,fullname,dob,gender,company,usertype,status,date_input', '"'.$uname.'", "'.$pword.'", "'.$addr.'", "'.$contact.'", "'.$fname.' '.$lname.'", "'.$bday.'","'.$gender.'", "'.$company.'", "'.$position.'", "1",now()', 1 );

		$db = $db->insert('employees', 'fname,mname,lname,bday,age,started_date,complete_add,email,contact,hired_date,date_left,gender,in_case_em,image,status,date_registered,settings_id,users_id', '"'.$fname.'","'.$mname.'","'.$lname.'","'.$bday.'","'.$age.'","'.$sdate.'","'.$addr.'","'.$email.'","'.$contact.'","'.$hdate.'","'.$dleft.'","'.$gender.'","'.$icoe.'","'.$newname.'","1", now(), "'.$returnid.'", "'.$usersid.'"');




		if($db == '1'){
			echo $glob->notify(1,'Nice! '.$fname.' has been registered to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Registered Employee with name of '.$fname.' '.$mname.' '.$lname.'.');
			echo $glob->header_type('settings?t=emp');
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}
	}

 ?>