<?php 
	session_start();
		include "phpfunc/globalfunc.php";
    include "db/auth.php";
    include "db/incDB.php";
    $glob = new Globalfunc();
    $db = new DB();
    if(!isset($_SESSION[SESUSER])){
			echo $glob->header_type('login');
		}
	
		if($db->update('tbl_users','on_off= "0"','WHERE id='.$_SESSION[SESUSER]) == 1){
			session_destroy();
			echo $glob->header_type('login');
		}
		
		// if($glob->logout($_SESSION[SESUSER])==1){
		// 	session_destroy();
		// 	echo $glob->header_type('login');
		// }
 ?>