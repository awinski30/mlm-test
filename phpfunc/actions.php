<?php 
	session_start();
	include "../include/include_allfunc.php";

	$action = $glob->filter($_GET['ac']);


	if($action == 'register'){
		$uname = $glob->filter($_POST['uname']);
		$email = $glob->filter($_POST['email']);
		$cnum = $glob->filter($_POST['cnum']);
		$pass = $glob->filter($_POST['pass']);
		$cpass = $glob->filter($_POST['cpass']);
		$country = $glob->filter($_POST['coutry']);
		$im_18 = $glob->filter($_POST['im_18']);


		// var_dump($_POST);

		if($uname == '' || $email == '' || $cnum == '' || $pass == '' || $cpass == '' || $country == ''){
			echo $glob->notify(2, 'Please fill all blank fields');
			die();
		}

		if($im_18 == ''){
			echo $glob->notify(2, 'You need to be 18 to play and use our system.');
			die();
		}

		if($pass != $cpass){
			echo $glob->notify(2, 'Password do not match.');
			die();
		}

		//password filtration
		$len = strlen($pass);

		if($len < 4){
        	echo $glob->notify(2, 'Password is too short, Minimum of 5 characters');
			die();
	    }
	    elseif($len >= 10){
	       echo $glob->notify(2, 'Password is too long, maximum of 10 characters');
			die();
	    }

	    //check email is already in our database
	    if($glob->acknowledger('email' , 'tbl_users', $email , 'email') == $email){
	    	echo $glob->notify(2, 'Email is already in used. Try another one.');
			die();
	    }

	    //check username is already exist
	    if($glob->acknowledger('uname' , 'tbl_users', $uname , 'uname') == $uname){
	    	echo $glob->notify(2, 'Username is already in used. Try another one.');
			die();
	    }

	    $code = rand(11111,99999999).'-bac-'.date('Y-m-d');

	    //registration process
	    $db = $db->insert('tbl_users','uname,pass, email,usertype,date_input,status,country,contact,ip,on_off,last_login,credit,reg_confirmation',"'$uname','$pass','$email', '1',now(), '0', '$country', '$cnum', '$ip','0',now(),'90','".$code."'");

	    if($db == 1){

	    	$mess = "
	    		<html>
	    			<body>
	    				<img src='http://localhost/betacoin/assets/img/logo.png' style='display: block; margin-left: auto; margin-right: auto; width: 50%;'>
	    				<h4>Thank you for registering in 'betacoin.com' you need to click the link below to confirm your account and recieve Php 90.00 worth of 5 game cards. Earn as much as you can and enjoy!</h4>

	    				<br>
	    				<a href='http://localhost/betacoin/phpfunc/actions.php?ac=confirmation&cd=".$code."&uname=".$uname."'>Confirm My Account</a>
	    			</body>
	    		</html>


	    	";

	    	$m = $glob->mailer($email, 'Registration Confirmation', $mess); //to , subject , mess

	    	if($m == 1){
	    		echo $glob->notify(1, 'Thank you! You are now registered to our system you just need to confirm your account that we sent to your email.');

	    		echo header_type('./');
	    	}else{
	    		echo $m;
	    	}

	    }

	}elseif($action == 'confirmation'){
		
		$cd = $glob->filter($_GET['cd']);
		$uname = $glob->filter($_GET['uname']);

		if($cd == '' || $uname == ''){
			echo $glob->notify(2, 'Invalid Code.');
			die();
		}

		//activate his/her account 
		$code = $glob->acknowledger('reg_confirmation' , 'tbl_users', $uname , 'uname');
	    	
	    

		if($cd == $code){

			//activate the user
			$st = $db->update('tbl_users', 'status="1"' , "WHERE uname='".$uname."'");
			echo $glob->notify(1, 'Account activated. Login now to your account!');
			echo header_type('./');


		}else{
			echo $glob->notify(2, 'Invalid Code.');
			die();
		}

	}elseif($action == 'buycredit'){

		$amount = $glob->filter($_POST['amount']);
		$ptype = $glob->filter($_POST['ptype']);
		$uid = $glob->filter($_POST['uid']);

		$email = $glob->uinfo($uid, 'email');

		$rand_cntl = rand(111,9999).'-bc-'.date('Y-m-d');


		$mess = "
	    		<html>
	    			<body>
	    				<img src='http://localhost/betacoin/assets/img/logo.png' style='display: block; margin-left: auto; margin-right: auto; width: 50%;'>
	    				<h4>Thank you for purchasing credit with amount of Php ".number_format($amount, 2)." to us. your transaction control number will be '".$rand_cntl."'</h4>
	    				<hr>
	    				<h4>Instruction after paying your credits</h4>
	    				<ul>
	    					<li>Pay credits to designated payment method (".$ptype.")</li>
	    					<li>Send your payment info here <a href='https://www.facebook.com/messages/t/betacoin'>Send Payment Info</a></li>
	    				</ul>

	    				<h5>Info Format</h5>
	    				<ul>
	    					<li>Transaction Control Number</li>
	    					<li>Fullname</li>
	    					<li>Payment Method</li>
	    					<li>Control Number</li>
	    					<li>Image of Reciept</li>
	    				</ul>


	    				<p>Note: Credit Amount will be charge 10% for processing fee.</p>
	    			</body>
	    		</html>


	    	";

	    	//insert to the database
	    	$db = $db->insert('load_request','uid,mode_payment, amount,status,date_registered,dmn_response_id,cntrl_num',"'$uid','$ptype','$amount', '0',now(), '', '".$rand_cntl."'");

	    	if($db == 1){


	    		$glob->mailer($email, 'Credit Purchase Confirmation', $mess); //to , subject , mess
	    		echo $glob->notify(1, 'Credit Request has been added kindly check your email for purhcase confirmation.');
				echo header_type('./');

	    	}

	    	 
	}elseif($action == 'redeemcredit'){

		$amount = $glob->filter($_POST['amount']);
		$ptype = $glob->filter($_POST['ptype']);
		$uid = $glob->filter($_POST['uid']);
		$fullname = $glob->filter($_POST['fullname']);



		$email = $glob->uinfo($uid, 'email');

		$rand_cntl = rand(111,9999).'-rc-'.date('Y-m-d');


		$mess = "
	    		<html>
	    			<body>
	    				<img src='http://localhost/betacoin/assets/img/logo.png' style='display: block; margin-left: auto; margin-right: auto; width: 50%;'>
	    				<h4>Congratulations for redeeming credits with amount of Php ".number_format($amount, 2).". your transaction control number will be '".$rand_cntl."'</h4>
	    				<hr>
	    				<h4>Instruction after paying your credits</h4>
	    				<ul>
	    					<li>Wait for our call for your redeem confirmation</li>
	    					<li>Make sure all information that we need will be accurate to your details or else your request will be canceled.</li>
	    					<li>Send your payment info here <a href='https://www.facebook.com/messages/t/betacoin'>Send Payment Info</a></li>
	    				</ul>

	    				<h5>Info Format</h5>
	    				<ul>
	    					<li>Transaction Control Number</li>
	    					<li>Full Transaction Information (Ask by our representative)</li>
	    					<li>Payment Method</li>
	    					<li>Valid 2 Government Id</li>
	    				</ul>


	    				<p>Note: Credit Amount will be charge 15% for processing fee.</p>
	    			</body>
	    		</html>


	    	";

	    	//insert to the database
	    	$db = $db->insert('load_redeem','uid,mode_payment,fullname, amount,status,date_registered,dmn_response_id,cntrl_num',"'$uid','$ptype','$fullname','$amount', '0',now(), '', '".$rand_cntl."'");

	    	if($db == 1){


	    		$glob->mailer($email, 'Redeem Credit Confirmation', $mess); //to , subject , mess
	    		echo $glob->notify(1, 'Credit Request has been added kindly check your email for request confirmation.');
				echo header_type('./');

	    	}

	    	 


	}else{

	}
 ?>