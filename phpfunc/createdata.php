

 <?php 
	session_start();
	include "../include/include_allfunc.php";

	$type = $glob->filter($_GET['t']);
	$ip = $glob->filter(getenv('REMOTE_ADDR'));

	if($type == 'register'){

		$uname = $_POST['uname'];
		$fname = $_POST['fname'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$ref_code = $_POST['ref_code'];

		$modemail = substr($email, 0, 2);
		$date_today = date("mdy");
		$maxid = $db->select('LPAD(max(id + 1), "5", "0")', 'tbl_users','',1)  ;
		

		// var_dump($maxid);
		// die();

		$ref_code_new = $modemail.$date_today.$maxid;
		
		
		//blank checker
		$check_blank = $glob->checkblank($_POST);
		if(!empty($check_blank)){
			echo $check_blank;
			die();
		} 


		//check ref_code is available of not
		$verify_code = $glob->checkrefcode($ref_code);
		if($verify_code != 1){
			echo $glob->notify(2,'Sorry refferal code with number '.$ref_code.' is not valid please ask your upline for the correct code.');
			die();
		}
		
		$parentmain = $glob->acknowledger('parent_main' , 'tbl_users', $ref_code , 'refferal_code');
		$parent = $glob->acknowledger('id' , 'tbl_users', $ref_code , 'refferal_code');

		//insert to db 
		$db = $db->insert('tbl_users', 'uname,pass,refferal_code,date_input,fullname,email,status,parent_main,parent_1', '"'.$uname.'","'.$pass.'","'.$ref_code_new.'",now(),"'.$fname.'","'.$email.'","1","'.$parentmain.'","'.$parent.'"');

		if($db == 1){
			echo $glob->notify(1,'Nice! '.$fname.' has been registered to our system.');
			echo $glob->header_type('login');
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}
	}

 ?>