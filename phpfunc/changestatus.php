<?php 
	session_start();
	include "../include/include_allfunc.php";

	$type = $glob->filter($_POST['tbl']);
	$ip = $glob->filter(getenv('REMOTE_ADDR'));



	if($type == 'cleaning_schedule'){

		$data = $_POST['id'];
		$header = $_POST['header'];
		 
		// echo ;

		// die();

		$update = $db->update('cleaning_schedule', 'date_cleaned="'.$glob->today().'", status="Cleaned"','WHERE id='.$data);



		
		if($update == 1){
			echo $glob->notify(1,'Nice! Schedule has been updated to our database.');
			$glob->activity_log($_SESSION[SESUSER], 'Cleaning schadule status has been change with an id of '.$data.'.');
			echo $glob->header_type($header);
		}else{
			echo $glob->notify(2,'Ops! Something wen\'t wrong kindly check your data before submiting.');
		}

	}

 ?>