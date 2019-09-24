<?php 
	session_start();
	include "../include/include_allfunc.php";

	$id = $glob->filter($_POST['id']);
	$tbl = $glob->filter($_POST['tbl']);
	$head = $glob->filter($_POST['head']);


		echo $glob->removeobj($id, $tbl);
		echo $glob->notify(1, "Done! This object is now remove.");
		echo $glob->header_type($head);

 ?>
