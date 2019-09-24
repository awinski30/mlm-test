<?php 
		session_start();
	include "../include/include_allfunc.php";

	$location = Globalfunc::filter($_POST['location']);
	$ptype = Globalfunc::filter($_POST['ptype']);
	$price = Globalfunc::filter($_POST['price']);
	$pname = Globalfunc::filter($_POST['pname']);



	Globalfunc::searchlisting($location, $ptype, $price, $pname);
	// if($ptype == '' AND $price == '' AND $pname == ''){

	// }elseif($location == '' AND $price == '' AND $pname == ''){

	// }elseif($location == '' AND $ptype == '' AND $pname == '')
 ?>