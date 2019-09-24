<?php 
	session_start();
	include "../include/include_allfunc.php";

	$type = $glob->filter($_GET['t']);
	$ip = $glob->filter(getenv('REMOTE_ADDR'));


	if($type == 'employees'){

		$data = $_POST['data'];

		$datas = $db->select('*', 'employees','WHERE settings_id='.$data.' ',2);


		//now user info need to merge in json_encode
		$data2 = $db->select('*', 'tbl_users', 'WHERE id='.$datas[0]['users_id'], 2);

		
		$result = array_merge($datas, $data2);

		

		

		$encode = json_encode($result);

		// var_dump($encode);
		// die();

		echo $encode;


	}else if($type == 'defect'){


		$data = $_POST['data'];

		$datas = $db->select('*', 'defect','WHERE id='.$data.' ',2);

		
		$encode = json_encode($datas);

		echo $encode;

	}else if($type == 'cleaning'){


		$data = $_POST['data'];

		$datas = $db->select('*', 'cleaning_schedule','WHERE id='.$data.' ',2);

		$encode = json_encode($datas);

		echo $encode;

	}else if($type == 'purchase-expenses'){


		$data = $_POST['data'];

		$datas = $db->select('*', 'canteen_pur_exp','WHERE id='.$data.' ',2);

		$encode = json_encode($datas);

		echo $encode;

	}else if($type == 'items'){


		$data = $_POST['data'];

		$datas = $db->select('*', 'menu','WHERE id='.$data.' ',2);

		$encode = json_encode($datas);

		echo $encode;

	}else if($type == 'accounting_reports'){


		$data = $_POST['data'];

		$datas = $db->select('*', 'accounting_reports','WHERE id='.$data.' ',2);

		foreach ($datas as $key => $value) {
			$newformat = $value['date_time'];
		}
		
		$ndate = date_create($newformat);
		$ndate = date_format($ndate, "Y-m-d\TH:i");

		foreach ($datas as $key => $value) {
			$datas[$key]['date_time'] = $ndate;
		}

		$encode = json_encode($datas);

		

		echo $encode;


	}else{
		$data = $_POST['data'];

		$datas = $db->select('*', 'settings','WHERE id='.$data.' ',2);

		$encode = json_encode($datas);
		echo $encode;
	}

 ?>