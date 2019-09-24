<?php 
	session_start();
	include "../include/include_allfunc.php";


	$buttoninq = Globalfunc::filter($_POST['ab']);
	$name = Globalfunc::filter($_POST['name']);
	$contact = Globalfunc::filter($_POST['contact']);
	$address = Globalfunc::filter($_POST['addr']);
	$ptype = Globalfunc::filter($_POST['ptype']);
	$email = Globalfunc::filter($_POST['email']);
	$details = Globalfunc::filter($_POST['details']);
	$siteid = Globalfunc::filter($_POST['siteid']);
	$ip = Globalfunc::filter(getenv('REMOTE_ADDR'));

	if($name == '' || $email == '' || $details == '' ||  $contact == '' || $address == '' || $ptype == ''){
		echo "Please fill all blank fields to the comment section.";
	}else{
		Globalfunc::insertinquiry($name, $email, $details, $buttoninq, $contact, $address, $ptype, $siteid, $ip);
			//echo Globalfunc::notify(1, "Thank you! Just wait for a call or message within 24 hours to confirm your inquiry.");
		echo  "Thank you! Just wait for a call or message from us within 24 hours to confirm your inquiry.";
		
		//echo Globalfunc::header_type('./');
	}

 ?>