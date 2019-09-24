<?php 
	session_start();
	include "../include/include_allfunc.php";

	$uname = $glob->filter($_POST['uname']);
	$pass = $glob->filter($_POST['pass']);
	$ip = $glob->filter(getenv('REMOTE_ADDR'));
	
	if ($uname == '' || $pass == '') {
		echo $glob->notify(2,"Please insert your username and password to proceed.");
		die();
	}

	//check user
	if($db->counter('uname','tbl_users',"WHERE uname='".$uname."'")==1){
		//check password if match
			if($glob->acknowledger('pass' , 'tbl_users', $uname , 'uname')==$pass){
				//check if user is already activated
				if($glob->acknowledger('status' , 'tbl_users', $uname , 'uname')== 1){
					//update all info of this user
					$db->update('tbl_users','on_off="1", last_login= now(), ip="'.$ip.'"', 'WHERE id='.$glob->acknowledger('id', 'tbl_users', $uname, 'uname'));
					//set all session like id and type
					echo $glob->set_usercredential($glob->acknowledger('id', 'tbl_users', $uname, 'uname'),$glob->acknowledger('usertype', 'tbl_users', $uname, 'uname'));
					
					echo $glob->notify(1,"Access Granted!");

					//header now to the dashboard
					echo $glob->header_type('dashboard');


				}else{
					echo $glob->notify(2,"This user is inactive you need to activate first to continue.");	
				}
			}else{
				echo $glob->notify(2,"Username and password doesn't match.");	
			}
	}else{
		echo $glob->notify(2,"Sorry this user doesn't exist.");
	}
 ?>