<?php 
	session_start();
	include "../include/include_allfunc.php";

	$type = $_GET['t'];
	$ip = $glob->filter(getenv('REMOTE_ADDR'));

	if($type == 'employees'){

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
		$id_edit_employees = $_POST['id_edit_employees'];


		//get id of employee
		$emp_id = $glob->acknowledger('users_id' , 'employees', $id_edit_employees, 'settings_id');


		//image upload
		if($_FILES['profile_img']['error'] !== 4){
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
			$newname = $glob->acknowledger('image' , 'employees', $id_edit_employees, 'settings_id');
			
		}



		// echo  "<pre>";
		// var_dump($newname);
		
		// echo  "</pre>";
		// die();

		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//insert to db 
		$db->update('settings', 'settings = "'.$fname.' '.$lname.'",type="'.$st.'"', 'WHERE id='.$id_edit_employees);
		
		//create user login with id return
		 $db->update('tbl_users', 'uname="'.$uname.'",pass="'.$pword.'",address="'.$addr.'",contact="'.$contact.'",fullname="'.$fname.' '.$lname.'",dob="'.$bday.'",gender="'.$gender.'",company="'.$company.'",usertype="'.$position.'"', 'WHERE id='.$emp_id );

		$db = $db->update('employees', 'fname="'.$fname.'", mname="'.$mname.'" ,lname="'.$lname.'",bday="'.$bday.'",age="'.$age.'",started_date="'.$sdate.'",complete_add="'.$addr.'",email="'.$email.'",contact="'.$contact.'",hired_date="'.$hdate.'",date_left="'.$dleft.'",gender="'.$gender.'",in_case_em="'.$icoe.'",image="'.$newname.'"', 'WHERE settings_id='.$id_edit_employees);




		if($db == '1'){
			echo $glob->notify(1,'Nice! '.$fname.' has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Updated employee with name of '.$fname.' '.$mname.' '.$lname.'.');
			echo $glob->header_type('settings?t=emp');
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}elseif($type == 'defect'){

		$date_def = $_POST['date_def'];
		$room = $_POST['room'];
		$defect_reported = $_POST['defect_reported'];
		$staff_reported = $_POST['staff_reported'];
		$designated = $_POST['designated'];
		$date_fx = $_POST['date_fx'];
		$personnel_fx = $_POST['personnel_fx'];
		$header = $_POST['header'];
		$id_edit_defect = $_POST['id_edit_defect'];

		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		}

		//insert to db 
		$db = $db->update('defect', 'date_reported="'.$date_def.'",room="'.$room.'",defect_reported="'.$defect_reported.'",staff_reported="'.$staff_reported.'",designated="'.$designated.'",date_fixed="'.$date_fx.'",personnel_fixed="'.$personnel_fx.'"', "WHERE id=".$id_edit_defect);

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$defect_reported.'has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Updated defect report with a room number of '.$room.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}elseif($type == 'cleaning'){	

		$room = $_POST['room'];
		$schedule = $_POST['schedule'];
		$cleaner = $_POST['cleaner'];
		$header = $_POST['header'];
		$id_edit_cleaning = $_POST['id_edit_cleaning'];


		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//insert to db 
		$db = $db->update('cleaning_schedule', 'room="'.$room.'",user_cleaner="'.$cleaner.'",schedule_to_clean="'.$schedule.'"', 'WHERE id='.$id_edit_cleaning);

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$room.' has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Updated cleaning shcedule with room number of '.$room.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}elseif($type == 'menu'){	

		$name = $_POST['menu_name'];
		$price = $_POST['menu_price'];
		$header = $_POST['header'];
		$id_edit_menu = $_POST['id_edit_menu'];

		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 

		//insert to db
		$db = $db->update('menu', 'menu_name="'.$name.'",price="'.$price.'"', 'WHERE id='.$id_edit_menu);

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$name.' menu has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Update a menu with a name of '.$name.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}elseif($type == 'purchase-expenses'){	

		$item_exp_pur = $_POST['item_exp_pur'];
		$company_exp_pur = $_POST['company_exp_pur'];
		$total_exp_pur = $_POST['total_exp_pur'];
		$header = $_POST['header'];
		$id_edit_exp_pur = $_POST['id_edit_exp_pur'];
		
		// var_dump($_POST);
		// die();

		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 

		//update to db 
		$db = $db->update('canteen_pur_exp', 'items_list="'.$item_exp_pur.'",total="'.$total_exp_pur.'",company="'.$company_exp_pur.'"','WHERE id='.$id_edit_exp_pur);


		if($db == 1){
			echo $glob->notify(1,'Nice! '.$item_exp_pur.'has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Update a canteen purchase and expenses report with a name of '.$item_exp_pur.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}
		
		

	}elseif($type == 'accounting_reports'){

		$subject = $_POST['subject'];
			$transaction_number = $_POST['transaction_number'];
			$paid_to = $_POST['paid_to'];
			$payment_type = $_POST['payment_type'];
			$paid_by = $_POST['paid_by'];
			$datetime_payment = $_POST['datetime_payment'];
			$pay_type = $_POST['pay_type'];
			$company = $_POST['company'];
			$pay_type_others = $_POST['pay_type_others'];
			$amount = $_POST['amount'];
			$account = $_POST['account'];
			$notes = $_POST['notes'];
			$header = $_POST['header'];
			$record_type = $_POST['record_type'];
		    $id_edit_item = $_POST['id_edit_'.$record_type];


		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//insert to db 
		$db = $db->update('accounting_reports', 'subject="'.$subject.'",cnt_num="'.$transaction_number.'",paid_to="'.$paid_to.'",payment_type="'.$payment_type.'",paid_by="'.$paid_by.'",date_time="'.$datetime_payment.'",pay_type="'.$pay_type.'",pay_type_others="'.$pay_type_others.'",amount="'.$amount.'",account="'.$account.'",notes="'.$notes.'",record_type="'.$record_type.'",company="'.$company.'",date_updated= now() ', 'WHERE id='.$id_edit_item);

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$transaction_number.' has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Updated report details with room number of '.$transaction_number.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}else{ //for company edit

		$sn = $_POST['s_name'];
		$st = $_POST['s_type'];
		$id_edit_company = $_POST['id_edit_company'];
		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//insert to db 
		$db = $db->update('settings', 'settings = "'.$sn.'",type="'.$st.'"', 'WHERE id='.$id_edit_company);

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$sn.'has been upadated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Updated company with name of '.$sn.'.');
			// echo $glob->header_type('settings');
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}

 ?>