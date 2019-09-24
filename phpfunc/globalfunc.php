<?php 
// error_reporting(0);

Class Globalfunc {
	
	// function for notifictaion
	// PARAMS
	// type of notification (1 - success, 2 - warning, 3- danger, 4-info)
	// outputmessage

	function notify($type, $mess){
		
		if($type == 1){
			$d = "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>Success!</strong> ".$mess.".
</div>";
		}elseif($type == 2){
			$d = "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>Warning!</strong> ".$mess.".
</div>";
		}elseif($type == 3){
			$d = "<div class='alert alert-danger alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>Danger!</strong> ".$mess.".
</div>";
		}elseif($type == 4){
			$d = "<div class='alert alert-primary alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>Info!</strong> ".$mess.".
</div>";
		}else{
			$d = "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>Warning!</strong> ".$mess.".
</div>";
		}
		return $d;
	}

	//filter data
	function filter($data){
		$db = new DB();
		$db = $db->connect();
		$data = mysqli_escape_string($db, $data);
		$data = htmlentities($data);
		$data = stripslashes($data);
		return $data;
	}

	//dynamic acknowledger
	//params ff
	//output
	//table search
	//data
	//row that your looking
	function acknowledger($product , $tbl, $data , $row){
	$db = new DB();
	$db = $db->connect();
	$q = mysqli_query($db, "SELECT * FROM ".$tbl." WHERE ".$row."='".$data."' ") or die (mysqli_error($db));
	$r = mysqli_fetch_assoc($q);
    $count = mysqli_num_rows($q);
	$data = $r[$product];
	return $data;
	} 

	// dynamic redirect 
	function header_type($url){
		$area = "<script>setTimeout(function(){
					window.location='".$url."'
				},2000);</script>";
		return $area;
	}

	function reload($time){
	return "<script>
				setTimeout(function(){
					location.reload();
				},".$time.");
				</script>";
}

	//dynamic user session handler
	function session_handler(){
		if(isset($_SESSION[SESUSER])){
			return $_SESSION[SESUSER];
		}

	}

	

	//--------------------------------------

	//login functionality

	//-------------------------------------

	// ..checking of existance of the user
	function user_checker($uname){
		$db = new DB();
		$db = $db->counter('uname','tbl_user','uname='.$uname);
		
		if($c > 0){
			return 1;
		}else{
			return 0;
		}
	}

	function set_usercredential($uid,$type){
		$_SESSION[UTYPE] = $type;
		$_SESSION[SESUSER] = $uid;
	}

	function out_status($uid){
		$s= self::acknowledger('on_off', 'tbl_users', $uid , 'id');
		if($s == 1){
			$d = '<span style="color:yellowgreen;">Online</span>';
		}else{
			$d = '<span style="color:red;">Offline</span>';
		}
		return $d;
	}

	function out_usertype($uid){
		$s= self::acknowledger('usertype', 'tbl_users', $uid , 'id');
		if($s == 1){
			$d = '<b>Lender</b>';
		}elseif($s == 2){
			$d = '<b>Borrower</b>';
		}else{
			$d = '<b>Admin</b>';
		}
		return $d;
	}

	function activity_log($uid, $activity){
		$db = new DB();
		$q = $db->insert('logs', 'uid,activity,date_registered', "'".$uid."','".$activity."', now()");
	}

	function status_id($st){
		if($st == 0){
			$d = "<button class='btn btn-sm btn-primary' disabled>Pending</button>";
		}elseif($st == 1){
			$d = "<button class='btn btn-sm btn-success' disabled>Active</button>";
		}elseif($st == 2){
			$d = "<button class='btn btn-sm btn-warning' disabled>Notice</button>";
		}elseif($st == 3){
			$d = "<button class='btn btn-sm btn-danger' disabled>Removed</button>";
		}else{
			$d = "undefined";
		}
		return $d;
	}

	function out_announcement(){
		$db = new DB();
		$q = $db->select('*', 'announcement','WHERE status="1" ',2);

		$d ='';
		foreach ($q as $key => $value) {
			$d .='<b>'.$value['mess'].'</b>'; 
		}
		return $d;


	}

//finding the referal code
	function checkrefcode($code){
		$db = new DB();
		$s = $db->select('refferal_code', 'tbl_users','WHERE refferal_code="'.$code.'"',1);

		

		if(!empty($s)){
			return 1;

			// var_dump($s);
		}
	}

	//output all downline
	function output_downline($uid, $type, $outputtype){
		$db = new DB();
		$s='';
		$parentmain = self::acknowledger('parent_main' , 'tbl_users', $uid , 'id');

		// if($type == 'direct' AND $outputtype == 'count'){

		// $s = $db->operate_select('COUNT(id) as total ', 'total', 'tbl_users','WHERE parent_1="'.$uid.'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ');

		// }elseif($type == '2ndgen' AND $outputtype == 'count'){

		// }elseif($type == '3rdgen' AND $outputtype == 'count'){

		// }else
		if($type == 'direct' AND $outputtype == 'output'){

		$d = $db->select('*', 'tbl_users','WHERE parent_1="'.$uid.'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);

		foreach ($d as $key => $value) {
			$s .= '
			
			<div class="col-xs-4 col-sm-6">
                    <div class="card">
                        <div class="body">
			<h4>Fullname: <small>'.$value['fullname'].'</small><br>
					Refferal Used: <small>'.self::uinfo(self::uinfo($uid, 'parent_1'), 'refferal_code').'</small><br>
					Date Registered: <small>'.self::uinfo($uid, 'date_input').'</small><br>
					Generated Refferal Code: <small>'.self::uinfo($value['id'], 'refferal_code').'</small><br>
			</h4>
			</div>
			</div>
			</div>

			';
		}
			
		}elseif($type == '2ndgen' AND $outputtype == 'output'){

			$d = $db->select('*', 'tbl_users','WHERE parent_1="'.$uid.'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);


			foreach ($d as $key => $value) {
				
				$ds = $db->select('*', 'tbl_users','WHERE parent_1="'.$value['id'].'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);
				
				foreach ($ds as $key => $value2) {
					$s .= '
			
					<div class="col-xs-4 col-sm-6">
		                    <div class="card">
		                        <div class="body">
					<h4>Fullname: <small>'.$value2['fullname'].'</small><br>
							Refferal Used: <small>'.self::uinfo(self::uinfo($value2['id'], 'parent_1'), 'refferal_code').'</small><br>
							Date Registered: <small>'.self::uinfo($uid, 'date_input').'</small><br>
							Generated Refferal Code: <small>'.self::uinfo($value2['id'], 'refferal_code').'</small><br>
					</h4>
					</div>
					</div>
					</div>

					';
				}

			}
			
		}elseif($type == '3rdgen' AND $outputtype == 'output'){

			$d = $db->select('*', 'tbl_users','WHERE parent_1="'.$uid.'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);
			
			foreach ($d as $key => $value) {
				
				$ds = $db->select('*', 'tbl_users','WHERE parent_1="'.$value['id'].'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);
				
				foreach ($ds as $key => $value2) {
					
					$dss = $db->select('*', 'tbl_users','WHERE parent_1="'.$value2['id'].'" AND  parent_main="'.$parentmain.'" AND usertype <> "0" ',2);
				
					foreach ($dss as $key => $value3) {
						
						$s .= '
			
							<div class="col-xs-4 col-sm-6">
				                    <div class="card">
				                        <div class="body">
							<h4>Fullname: <small>'.$value3['fullname'].'</small><br>
									Refferal Used: <small>'.self::uinfo(self::uinfo($value3['id'], 'parent_1'), 'refferal_code').'</small><br>
									Date Registered: <small>'.self::uinfo($uid, 'date_input').'</small><br>
									Generated Refferal Code: <small>'.self::uinfo($value3['id'], 'refferal_code').'</small><br>
							</h4>
							</div>
							</div>
							</div>

							';
						
					}


				}

			}


		}




		return $s;
			// var_dump($s);
		// die();



	}

	function mailer($to, $subject, $mess){
		$to = $to;
			$subject = $subject;
			$txt = $mess;
			$headers = "From: support@awindev.com";

			$mail = mail($to,$subject,$txt,$headers);

			if($mail){
				return 1;
			}else{
				return 'mail_error';
			}
	}

	function searchoption($t){
		if($t == 'location'){

			$db = new DB();
		$db = $db->select('*', 'erp_listing','WHERE status="1" group by location',2);
			
			$d ='';
			foreach($q as $val){
				
				$d .= "<option value='".$val['location']."'>".$val['location']."</option>";
			
			}
			return $d;

		}elseif($t == 'proptype'){

			$db = new DB();
		$db = $db->select('*', 'erp_listing','WHERE status="1" group by prop_type',2);

			$d ='';
			foreach($q as $val){
				
				$d .= "<option value='".$val['prop_type']."'>".self::gettypelisiting($val['prop_type'])."</option>";
			
			}
			return $d;

		}else{
			return 'none';
		}
	}

	function uinfo($id, $find){
		$db = new DB();
		return $db->select($find, 'tbl_users', "WHERE id=".$id, 1);
	}

	function iteminfo($id, $find){
		$db = new DB();
		return $db->select($find, 'menu', "WHERE id=".$id, 1);
	}

	function ucompany($id, $find){
		$db = new DB();
		return $db->select($find, 'settings', "WHERE id=".$id, 1);
	}

	function emplyeesinfo($id, $find){
		$db = new DB();
		return $db->select($find, 'blog', "WHERE id=".$id, 1);
	}



	function nl2br2($string) { 
		$string = str_replace(array("rn", "\r", "\n"), "<br />", $string); 
		return $string; 
	} 

	function outlisting3($times='', $g=''){
		if($g != ''){
			$ext = 'AND prop_type='.$g;
		}else{
			$ext = '';
		}
		$db = new DB();
		$q = $db->select('*', 'erp_listing','WHERE status="1" '.$ext.' ORDER BY date_input DESC LIMIT '.$times,2);

		$d='';


		foreach ($q as $val) {
			//".self::outimage($chunkimg[0],$val['prop_name'])."
			$img = $val['img'];

			if($img == ''){
				$imgs ='assets/images/demo-content/property-1.jpg';	
			}else{
				$img = json_decode($img, true);
				// var_dump($img);
				// 	die();
				foreach ($img as  $chunkimg) { 

					$imgs = self::outimage($chunkimg, $val['prop_name']);
				}
			}
			
			$d .="
				<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3'>
    <div class='ct-itemProducts ct-u-marginBottom30 ct-hover'>
        <label class='control-label sale'>
             ".self::status_property($val['status_prop'])."
        </label>
        <a href='product-single.php?pid=".$val['id']."'>
            <div class='ct-main-content'>
                <div class='ct-imageBox' style='max-height:148px;'>
                    <img src='".$imgs."' alt='><i class='fa fa-eye'></i>
                </div>
                <div class='ct-main-text'>
                    <div class='ct-product--tilte'>
                        ".self::string_limiter($val['complete_address'], 20)."
                    </div>
                    <div class='ct-product--price'>
                        <span>Php ".number_format($val['price'])."</span>
                    </div>
                    <div class='ct-product--description'>
                        ".self::string_limiter(self::nl2br2($val['description']),50)."
                    </div>
                </div>
            </div>
            <div class='ct-product--meta'>
                <div class='ct-icons'>
                                    <span>
                                        <i class='fa fa-bed'></i> ".$val['bedroom']."
                                    </span>
                </div>
                <div class='ct-text'>
                   
                </div>
            </div>
        </a>
    </div>
</div>
			";
		

		}
		return $d;
	}

	function string_limiter($x, $length)
	{
	  if(strlen($x)<= $length)
	  {
	    return $x;
	  }
	  else
	  {
	    $y=substr($x,0,$length) . '...';
	    return $y;
	  }
	}

	function outallbloglist($id){
		$db = new DB();
		$q = $db->select('*', 'blog','WHERE status="1" AND site_id="'.$id.'" ORDER BY date_input DESC LIMIT 4',2);
		$c = $db->counter('id','blog',"WHERE site_id=".$id);
		$d='';
		if($c > 0){
			
		

		foreach ($q as $value) {
			$dateinput  = strtotime($value['date_input']);
		$d .="
			<div class='ct-articleBox ct-articleBox--list'>
                        <div class='ct-calendar--day text-center'>
                            <div class='ct-day'>
                                <span>".date("d", $dateinput)."</span>
                            </div>
                            <div class='ct-month'>
                                <span class='text-uppercase'>".date("M", $dateinput)."</span>
                            </div>
                        </div>
                        <div class='ct-articleBox-media'>
                            <img src='http://awindev.com/dmn/img/blog/".$value['title']."/".$value['img']."' alt=''>
                        </div>
                        <div class='ct-articleBox-titleBox text-uppercase'>

                            <a href='blog-single.php?b=".$value['id']."'>".$value['title']."</a>
                            <div class='ct-articleBox-meta'>
                                <span>Posted on ".date("M", $dateinput)." ".date("d", $dateinput).", ".date("Y", $dateinput)." In ".self::btype($value['category'])."</span>
                            </div>

                        </div>
                        <div class='clearfix'></div>
                    </div>
		";
		}

		}else{
			$d = self::notify(2,"Sorry we don't have any news yet.");
		}
		return $d;
	}

	function date_modifier($id, $find, $ty){
		$p = self::bloginfo($id, $find);
		
		$dateinput  = strtotime($p);
		
		return date($ty, $dateinput);
	}

	function out_blogImg($id){
		$bname = self::bloginfo($id, 'title');
		$img = self::bloginfo($id, 'img');

		if($img != ''){
			$d = "<img src='http://awindev.com/dmn/img/blog/".$bname."/".$img."' alt=''>";
		}else{
			$d ='';
		}

		return $d;
		
	}


	function output_allblog($id){
		$db = new DB();
		$q = $db->select('*', 'blog','WHERE status="1" AND site_id="'.$id.'" ORDER BY date_input DESC',2);
		$c = $db->counter('id','blog',"WHERE site_id=".$id);
		$d = "";
		
		if($c > 0){
			foreach ($q as $value){
				if($value['cover_type'] == '1'){
					$t = '<div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/pCyKtGC3nIk"></iframe>
                        </div>';
				}else{
					$t = '<img width="100px" src="http://awindev.com/dmn/img/blog/'.$value['title'].'/'.$value['img'].'" alt="">';
				}
				$dateinput  = strtotime($value['date_input']);
				if($value['img'] != ""){
					$d .='<div class="ct-articleBox ct-u-marginBottom80 ct-articleBox--noImage">
                    <div class="ct-articleBox-media ct-u-marginBottom30">
                        <div class="ct-calendar--day text-center ct-calendar--mini hidden-lg">
                            <div class="ct-day">
                                <span>'.date("d", $dateinput).'</span>
                            </div>
                            <div class="ct-month">
                                <span class="text-uppercase">'.date("M", $dateinput).'</span>
                            </div>
                        </div>
                        '.$t.'
                    </div>
                    <div class="ct-articleBox--body">
                        <div class="ct-u-displayTableVertical">
                            <div class="ct-calendar--day text-center ct-u-displayTableCell visible-lg-inline-block">
                                <div class="ct-day">
                                    <span>'.date("d", $dateinput).'</span>
                                </div>
                                <div class="ct-month">
                                    <span class="text-uppercase">'.date("M", $dateinput).'</span>
                                </div>
                            </div>
                            <div class="ct-articleBox-titleBox text-uppercase ct-u-displayTableCell">

                                <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">
                                '.$value['title'].'
                                </a>
                                <div class="ct-articleBox-meta">
                                    <span>Posted on '.date("M", $dateinput).' '.date("d", $dateinput).', '.date("Y", $dateinput).' In '.self::btype($value['category']).', Real Estate</span>
                                </div>
                            </div>
                        </div>

                        <div class="ct-divider ct-u-marginTop10 ct-u-marginBottom20"></div>
                        <div class="ct-articleBox-description">
                            '.self::string_limiter($value['message'], 250).'
                            <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">Read more.</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>';
				}else{
					$d .='<div class="ct-articleBox ct-u-marginBottom80 ct-articleBox--noImage">
                    <div class="ct-articleBox-media ct-u-marginBottom30">
                        <div class="ct-calendar--day text-center ct-calendar--mini hidden-lg">
                            <div class="ct-day">
                                <span>'.date("d", $dateinput).'</span>
                            </div>
                            <div class="ct-month">
                                <span class="text-uppercase">'.date("M", $dateinput).'</span>
                            </div>
                        </div>
                    </div>
                    <div class="ct-articleBox--body">
                        <div class="ct-u-displayTableVertical">
                            <div class="ct-calendar--day text-center ct-u-displayTableCell visible-lg-inline-block">
                                <div class="ct-day">
                                    <span>'.date("d", $dateinput).'</span>
                                </div>
                                <div class="ct-month">
                                    <span class="text-uppercase">'.date("M", $dateinput).'</span>
                                </div>
                            </div>
                            <div class="ct-articleBox-titleBox text-uppercase ct-u-displayTableCell">

                                <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">'.$value['title'].'</a>
                                <div class="ct-articleBox-meta">
                                    <span>Posted on '.date("M", $dateinput).' '.date("d", $dateinput).', '.date("Y", $dateinput).' In '.self::btype($value['category']).', Real Estate</span>
                                </div>
                            </div>
                        </div>

                        <div class="ct-divider ct-u-marginTop10 ct-u-marginBottom20"></div>
                        <div class="ct-articleBox-description">
                            '.self::string_limiter($value['message'], 250).'
                            <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">Read more.</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>';
				}

	        }  
        }else{
        	$d = self::notify(2,"Sorry we don't have any news yet.");
        }

        return $d;
	}


	function outlist_blogwidget($id){
		$db = new DB();
		$q = $db->select('*', 'blog','WHERE status="1" AND site_id="'.$id.'" LIMIT 4',2);
		$c = $db->counter('id','blog',"WHERE status= '1' AND site_id='".$id."'");
		$d = "";
		
		if($c > 0){
			foreach ($q as $value){
				if($value['img'] != ""){
					$d .='<li>
	                                <div class="widget-latest-posts-left">
	                                    <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">
	                                        <img width="100px" src="http://awindev.com/dmn/img/blog/'.$value['title'].'/'.$value['img'].'" alt="">
	                                    </a>
	                                </div>
	                                <div class="widget-latest-posts-content">
	                                    <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">
	                                        '.$value['title'].'
	                                    </a>
	                                    <span class="text-uppercase">Posted on '.self::date_modifier($value['id'], 'date_input', "M d, Y").'</span>
	                                </div>
	                            </li>';
				}else{
					$d .='<li>
	                                <div class="widget-latest-posts-content">
	                                    <a href="http://eliterealtyph.com/blog-single.php?b='.$value['id'].'">
	                                         '.$value['title'].'
	                                    </a>
	                                    <span class="text-uppercase">Posted on '.self::date_modifier($value['id'], 'date_input', "M d, Y").'</span>
	                                </div>
	                            </li>';
				}

	        }  
        }else{
        	$d = self::notify(2,"Sorry we don't have any news yet.");
        }

        return $d;
	}

	function outlisting($times=''){
		$db = new DB();
		$q = $db->select('*', 'erp_listing','WHERE status="1" ORDER BY date_input DESC LIMIT '.$times,2);
		$d='';

		foreach($q as $val){
			
			$img = $val['img'];

			if($img == ''){
				$imgs ='assets/images/demo-content/property-1.jpg';	
			}else{
				$img = json_decode($img, true);
				
				foreach ($img as  $chunkimg) { 

					$imgs = self::outimage($chunkimg, $val['prop_name']);
				}
			}

			$d .= "
					<div class='col-sm-6 col-md-6 col-lg-4'>
                        <div class='ct-itemProducts ct-u-marginBottom30 ct-hover'>
                                <label class='control-label sale'>
                                    ".self::status_property($val['status_prop'])."
                                </label>
                                <a href='product-single.php?pid=".$val['id']." '>
                                    <div class='ct-main-content'>
                                        <div class='ct-imageBox'>
                                           <img src='".$imgs."' alt='><i class='fa fa-eye'></i>
                                        </div>
                                        <div class='ct-main-text'>
                                            <div class='ct-product--tilte'>
                                                ".self::string_limiter($val['complete_address'], 25)."
                                            </div>
                                            <div class='ct-product--price'>
                                                <span>Php ".number_format($val['price'])."</span>
                                            </div>
                                            <div class='ct-product--description'>
                                                ".self::string_limiter(self::nl2br2($val['description']),50)."
                                            </div>
                                        </div>
                                    </div>
                                    <div class='ct-product--meta'>
                                        <div class='ct-icons'>
                                            <span>
                                                <i class='fa fa-bed'></i> ".$val['bedroom']."
                                            </span>
                                        </div>
                                        <div class='ct-text'>
                                            
                                        </div>
                                    </div>
                                </a>
                       	</div>
                    </div>
			";
						
			}

			return $d;
	}

	function status_info($t){
		if($t == 1){
			return "<button class='btn btn-success btn-sm btn-block'>Active</button>";
		}elseif($t == 2){
			return "<button class='btn btn-warning btn-sm btn-block'>Inactive</button>";
		}elseif($t == 3){

		}elseif($t == 4){

		}elseif($t == 5){

		}
	}

	function outsettings($type){
		$db = new DB();
		$d='';
		if($type == 'menu'){
			$q = $db->select('*', 'menu','WHERE type="menu"',2);

			if(count($q) > 0){
			
			//table output
			foreach ($q as  $value) {
				$d .= "<tr>
					<td>".$value['id']."</td>
					<td>".$value['menu_name']."</td>
					<td>".$value['price']."</td>
					<td>".$value['date_registered']."</td>
					<td><button class='btn btn-warning btn-sm edit-".$type."' type='button' data-toggle='modal' data-target='#modal-".$type."' data-value='".$value['id']."'>Edit / View</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
				</tr>";
			}

			}else{
				$d='';
			}


		}elseif($type == 'raw'){
				$q = $db->select('*', 'menu','WHERE type="raw"',2);

			if(count($q) > 0){
			//table output
			foreach ($q as  $value) {
				$d .= "<tr>
					<td>".$value['id']."</td>
					<td>".$value['menu_name']."</td>
					<td>".$value['date_registered']."</td>
					<td><button class='btn btn-warning btn-sm edit-".$type."' type='button' data-toggle='modal' data-target='#modal-".$type."' data-value='".$value['id']."'>Edit / View</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
				</tr>";
			}

			}else{
				$d='';
			}
		}else{
			$q = $db->select('*', 'settings','WHERE status="1" AND type="'.$type.'" ORDER BY date_registered DESC ',2);

			if(count($q) > 0){
			
			//table output
			foreach ($q as  $value) {
				$d .= "<tr>
					<td>".$value['id']."</td>
					<td>".$value['settings']."</td>
					<td>".self::status_info($value['status'])."</td>
					<td>".$value['date_registered']."</td>
					<td><button class='btn btn-warning btn-sm edit-".$type."' type='button' data-toggle='modal' data-target='#modal-".$type."' data-value='".$value['id']."'>Edit / View</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
				</tr>";
			}

			}else{
				$d='';
			}
		}
		
		
		


		
		

		return $d;
		

	}

	function outdefect($utype){

		$db = new DB();
		if($utype == '0'){ //admin 
			
			$q = $db->select('*', 'defect',' ORDER BY date_registered DESC ',2);
		}else{ 
			$q = $db->select('*', 'defect','WHERE staff_reported = "'.$_SESSION[SESUSER].'" ORDER BY date_registered DESC ',2);
		}


		$d='';

		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<tr>
				<td>".$value['id']."</td>
				<td>".$value['room']."</td>
				<td>".$value['defect_reported']."</td>
				<td>".$value['date_reported']."</td>
                <td>".self::uinfo($value['staff_reported'], 'fullname')."</td>
                <td>".$value['designated']."</td>
                <td>".$value['date_fixed']."</td>
                <td>".$value['personnel_fixed']."</td>
				<td>".$value['date_registered']."</td>
				<td><button class='btn btn-warning btn-sm edit-defect' type='button' data-toggle='modal' data-target='#modal-defect' data-value='".$value['id']."'>Edit</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
			</tr>";
		}

		}else{
			$d='';
		}
		return $d;
		

	}

	function outcleaning($type){
		$d='';
		$db = new DB();

		//date today
		$today = date('Y-m-d');
		
		

		//type output
		if($type == 'schedule'){
			$ext = 'WHERE schedule_to_clean >= "'.$today.'"';
		}else{
			$ext = 'WHERE status="Cleaned"';
		}


		if($_SESSION[UTYPE] == '0'){ //admin 
			$q = $db->select('*', 'cleaning_schedule',$ext.' ORDER BY date_registered DESC ',2);
		}else{ 

			if($type == 'record'){
				$ext1 = 'AND status="Cleaned"';
			}else{
				$ext1 = 'AND schedule_to_clean >= "'.$today.'"';
			}

			$q = $db->select('*', 'cleaning_schedule','WHERE user_cleaner = "'.$_SESSION[SESUSER].'" '.$ext1.' ORDER BY date_registered DESC ',2);
		}



		if($type == 'record'){

			if(count($q) > 0){
			
			//table output
			foreach ($q as  $value) {

				if($value['status'] == 'Cleaned'){
					$statusbtn = "<button class='btn btn-block btn-success btn-sm' >Cleaned</button>";
				}else{
					$statusbtn = "<button type='button' class='btn btn-block btn-warning btn-sm set-status' data-value='".$value['id']."'>Set As Done</button>";
				}

				$d .= "<tr>
					<td>".$value['id']."</td>
					<td>".$value['room']."</td>
					<td>".$value['date_cleaned']."</td>
	                <td>".self::uinfo($value['user_cleaner'], 'fullname')."</td>
	                <td>".$value['schedule_to_clean']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$statusbtn."</td>
					<td><!--<button class='btn btn-warning btn-sm edit-cleaning' type='button' data-toggle='modal' data-target='#modal-schedule' data-value='".$value['id']."'>Edit</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button>--></td>
				</tr>";
			}

			}else{
				$d='';
			}


		}else{

			if(count($q) > 0){
			
			//table output
			foreach ($q as  $value) {

				if($value['status'] == 'Cleaned'){
					$statusbtn = "<button class='btn btn-block btn-success btn-sm' >Cleaned</button>";
				}else{
					$statusbtn = "<button type='button' class='btn btn-block btn-warning btn-sm set-status' data-value='".$value['id']."'>Set As Done</button>";
				}

				$d .= "<tr>
					<td>".$value['id']."</td>
					<td>".$value['room']."</td>
					<td>".$value['date_cleaned']."</td>
	                <td>".self::uinfo($value['user_cleaner'], 'fullname')."</td>
	                <td>".$value['schedule_to_clean']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$statusbtn."</td>
					<td><button class='btn btn-warning btn-sm edit-cleaning' type='button' data-toggle='modal' data-target='#modal-schedule' data-value='".$value['id']."'>Edit</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
				</tr>";
			}

			}else{
				$d='';
			}

		}


		

		
		return $d;

	}


	function today($date=''){
		if($date != ''){
			$d = date($date);
		}else{
			$d = date('Y-m-d');
		}

		return $d;
	}


	function selectuser(){
		$db = new DB();
		$q = $db->select('*', 'tbl_users','WHERE usertype IN ("2","3","1") ',2);

		$d='';

		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<option value='".$value['id']."'>".$value['fullname']."</option>";
		}

		}else{
			$d='';
		}
		return $d;
	}

	function selectcompany(){
		$db = new DB();
		$q = $db->select('*', 'settings','WHERE type="company" ',2);

		$d='';

		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<option value='".$value['id']."'>".$value['settings']."</option>";
		}

		}else{
			$d='';
		}
		return $d;
	}

	function selectmenu(){
		$db = new DB();
		$q = $db->select('*', 'menu','WHERE type="menu"',2);

		$d='';

		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<option value='".$value['id']."'>".$value['menu_name']."</option>";
		}

		}else{
			$d='';
		}
		return $d;
	}

	function selectraw(){
		$db = new DB();
		$q = $db->select('*', 'menu','WHERE type="raw"',2);

		$d='';

		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<option value='".$value['id']."'>".$value['menu_name']."</option>";
		}

		}else{
			$d='';
		}
		return $d;
	}

	function ouputcompany(){
		$db = new DB();
		$q = $db->select('*', 'settings','WHERE type="company" ',2);
		$d='';
		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<option value='".$value['id']."'>".$value['settings']."</option>";
		}

		}else{
			$d ='';
		}

		return $d;
	}



	function outreports($type, $date_range='',$company =''){
		$db = new DB();
		
		// var_dump($date_range);

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_time >= "'.$start.'" AND date_time <= "'.$end.'"';
		}else{
			$m = '';
		}






		if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}



			$q = $db->select('*', 'accounting_reports','WHERE record_type="'.$type.'" '.$ext.$m.' ORDER BY date_registered DESC ',2);
		}else{ 
			$q = $db->select('*', 'accounting_reports','WHERE user_id_register= "'.$_SESSION[SESUSER].'" '.$m.' AND record_type="'.$type.'" ORDER BY date_registered DESC ',2);
		
}
		
		
		$d='';


		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {
			$d .= "<tr>
				<td>".$value['id']."</td>
				<td>".$value['cnt_num']."</td>
				<td>".$value['subject']."</td>
				<td>".$value['paid_to']."</td>
				<td>".$value['payment_type']."</td>
				<td>".self::uinfo($value['paid_by'], 'fullname')."</td>
				<td>".$value['date_time']."</td>
				<td>".number_format($value['amount'], 2)."</td>
				<td>".$value['pay_type']."</td>
				<td>".self::ucompany($value['company'], 'settings')."</td>
				<td>".$value['date_registered']."</td>
				<td><button class='btn btn-warning btn-sm edit-".$type."' type='button' data-toggle='modal' data-target='#modal-".$type."' data-value='".$value['id']."'>Edit / View</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
			</tr>";
		}

		}else{
			$d='';
		}
		

		return $d;
		

	}



	function outtotal($type, $date_range='',$company =''){
		$db = new DB();
		
		// var_dump($date_range);

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_time >= "'.$start.'" AND date_time <= "'.$end.'"';
		}else{
			$m = '';
		}






		if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}



			$d = $db->operate_select('SUM(amount) as total', 'total', 'accounting_reports','WHERE record_type="'.$type.'" '.$ext.$m);
		}else{ 
			$d = $db->operate_select('SUM(amount) as total', 'total', 'accounting_reports','WHERE user_id_register= "'.$_SESSION[SESUSER].'" '.$m.' AND record_type="'.$type.'"');
		
}

	if($d == '' || $d == 0){
		$d = 'Php 0.00';
	}else{
		$d = number_format($d,2);
	}
		
		return 'Php '.$d;
		

	}

	function outpurchase_expense($date_range='',$company =''){
		$db = new DB();
		
		// var_dump($date_range);

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_registered >= "'.$start.'" AND date_registered <= "'.$end.'"';
		}else{
			$m = '';
		}





		if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}



			$q = $db->select('*', 'canteen_pur_exp','WHERE total <> "0.00" '.$ext. $m .' ORDER BY date_registered DESC ',2);
		}else{ 
			$q = $db->select('*', 'canteen_pur_exp','WHERE user_inserted= "'.$_SESSION[SESUSER].'" '.$m.' ORDER BY date_registered DESC ',2);

		}
		
		
		$d='';


		if(count($q) > 0){
			
			//table output
		foreach ($q as  $value) {


			$d .= "<tr>
				<td>".$value['date_registered']."</td>
				<td>".self::iteminfo($value['items_list'], 'menu_name')."</td>
				<td>".number_format($value['total'],2)."</td>
				<td>".self::uinfo($value['user_inserted'], 'fullname')."</td>
				<td>".self::ucompany($value['company'], 'settings')."</td>
				
				<td><button class='btn btn-warning btn-sm edit-purchase-expenses' type='button' data-toggle='modal' data-target='#modal-purchase-expenses' data-value='".$value['id']."'>Edit / View</button> <button class='btn btn-danger btn-sm btn-remove' type='button' data-value='".$value['id']."'>Remove</button></td>
			</tr>";
		}

		}else{
			$d='';
		}
		

		return $d;
		

	}

	function outtotal_purhcaseexp_canteen($date_range='',$company =''){
		$db = new DB();
		
		// var_dump($date_range);

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_time >= "'.$start.'" AND date_time <= "'.$end.'"';
		}else{
			$m = '';
		}



		if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

			$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  total <> "0.00" '.$ext.$m);
		}else{ 
			$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE user_id_register= "'.$_SESSION[SESUSER].'" '.$m.' AND record_type="'.$type.'"');
		
		}

		if($d == '' || $d == 0){
			$d = 'Php 0.00';
		}else{
			$d = 'Php '.number_format($d,2);
		}
		
		return $d;	

	}


	function outmatrix_sales($date, $company){
		// ini_set('display_errors', 1);

		$db = new DB();



			if($company != ''){
				$ext = 'company="'.$company.'" AND';
			}else{
				$ext = '';
			}

		//sales
			if($_SESSION[UTYPE] == '0'){ //admin 
				$sales = $db->operate_select(' SUM(total) as total ','total', 'canteen_orderslip','WHERE '.$ext.'  date_registered LIKE "%'.$date.'%" ');
			}else{  
				$sales = $db->operate_select(' SUM(total) as total ', 'total', 'canteen_orderslip','WHERE '.$ext.' user_inserted= "'.$_SESSION[SESUSER].'" AND company="'.$company.'" AND date_registered LIKE "%'.$date.'%" ');
			
			}

			      // var_dump($sales);

			if($sales == 0 AND $sales == NULL){
				$sales = 0.00;
			}

			return $sales;


	}

	function outmatrix_meat($date, $company){
		$db = new DB();



			if($company != ''){
				$ext = 'company="'.$company.'" AND';
			}else{
				$ext = '';
			}

		//sales
			if($_SESSION[UTYPE] == '0'){ //admin 
				$meat = $db->operate_select(' SUM(total) as total ','total', 'canteen_pur_exp','WHERE items_list = "12" AND '.$ext.'  date_registered LIKE "%'.$date.'%" ');
			}else{  
				$meat = $db->operate_select(' SUM(total) as total ', 'total', 'canteen_pur_exp','WHERE items_list = "12" '.$ext.' user_id_register= "'.$_SESSION[SESUSER].'" AND company="'.$company.'" AND date_registered LIKE "%'.$date.'%" ');
			
			}

			      // var_dump($sales);

			if($meat == 0 AND $meat == NULL){
				$meat = 0.00;
			}

			return $meat;


	}



	function outmatrix($date_range, $company){
		$db = new DB();
		$d = '';

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_time >= "'.$start.'" AND date_time <= "'.$end.'"';
		}else{
			$m = '';
		}

			if($company != ''){
				$company_s = $company;
			}else{
				$company_s = '';
			}

		//pur_exp
			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$pur_exp = $db->select(' SUM(total) as total, date_registered, company', 'canteen_pur_exp','WHERE  items_list <> "12" '.$ext.$m.' GROUP BY DATE(canteen_pur_exp.date_registered)',2);
			}else{ 
				$pur_exp = $db->select(' SUM(total) as total, date_registered ,company', 'canteen_pur_exp','WHERE  items_list <> "12" AND user_id_register= "'.$_SESSION[SESUSER].'" '.$m.' GROUP BY DATE(date_registered)',2);
			
			}

				
				foreach ($pur_exp as $key => $valuepurexp) {
					
					// if($valuepurexp['date_registered'] == $valuemeat['date_registered'] AND $valuemeat['date_registered'] == $valuesales['date_registered']){
					


					$date_create = date_create($valuepurexp['date_registered']);
					$date_create = date_format($date_create, 'Y-m-d');

					 // echo self::outmatrix_sales($date_create, $company_s);
					
					$totalall = self::outmatrix_sales($date_create, $company_s) - self::outmatrix_meat($date_create, $company_s)+ $valuepurexp['total'];
					// self::outmatrix_meat($date_create, $company_s) +
					// number_format(self::outmatrix_meat($date_create, $company_s),2)

					$d .= "
						<tr>
							<td>".$date_create."</td>
							<td>".number_format(self::outmatrix_sales($date_create, $company_s), 2)."</td>
							<td>".number_format(self::outmatrix_meat($date_create, $company_s),2)."</td>
							<td>".$valuepurexp['total']."</td>
							<td>".self::ucompany($valuepurexp['company'],'settings')."</td>
							<td>".number_format($totalall, 2)."</td>
						</tr>
					";
					}
				



		  return $d;

	}



	function totalmatrix($date_range='',$company ='', $type){
		$db = new DB();
		
		// var_dump($date_range);

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_time >= "'.$start.'" AND date_time <= "'.$end.'"';
		}else{
			$m = '';
		}


		if($type == 'overall'){

			//pur_exp
			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$d1 = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  total <> "0.00" AND items_list <> "12" '.$ext.$m);
			}else{ 
				$d1 = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  items_list <> "12" AND user_id_register= "'.$_SESSION[SESUSER].'" '.$m);
			
			}

			//meat
			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$meat = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  total <> "0.00" AND items_list = "12" '.$ext.$m);
			}else{ 
				$meat = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  items_list = "12" AND user_id_register= "'.$_SESSION[SESUSER].'" '.$m);
			
			}


			//sales
			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$d2 = $db->operate_select('SUM(total) as total', 'total', 'canteen_orderslip','WHERE  total <> "0.00" '.$ext.$m);
			}else{ 
				$d2 = $db->operate_select('SUM(total) as total', 'total', 'canteen_orderslip','WHERE user_inserted= "'.$_SESSION[SESUSER].'" '.$m);
			
			}

			 

			$d = $d2 - $meat + $d1 ;

			// var_dump($d2);



		}elseif($type == 'purchase_exp'){

			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  items_list <> "12" '.$ext.$m);
			}else{ 
				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  items_list <> "12" AND user_id_register= "'.$_SESSION[SESUSER].'" '.$m);
			
			}

		}elseif($type == 'kings_meat'){


			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE items_list = "12" '.$ext.$m);
			}else{ 
				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_pur_exp','WHERE  items_list = "12" AND user_id_register= "'.$_SESSION[SESUSER].'" '.$m);
			
			}


		}elseif($type == 'sales'){

			if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}

				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_orderslip','WHERE  total <> "0.00" '.$ext.$m);
			}else{ 
				$d = $db->operate_select('SUM(total) as total', 'total', 'canteen_orderslip','WHERE user_inserted= "'.$_SESSION[SESUSER].'" '.$m);
			
			}

		}


	

		if($d == '' || $d == 0){
			$d = 'Php 0.00';
		}else{
			$d = 'Php '.number_format($d,2);
		}
		
		return $d;	

	}


	function outorderslip($date_range='',$company =''){
		$db = new DB();

		if($date_range != '' AND $date_range != 'undefined'){

			$start = substr($date_range, 0,10);
            $end = substr($date_range, 12,23);


			$m = ' AND date_registered >= "'.$start.'" AND date_registered <= "'.$end.'"';
		}else{
			$m = '';
		}





		if($_SESSION[UTYPE] == '0'){ //admin 
			
			if($company != ''){
				$ext = ' AND company='.$company;
			}else{
				$ext = '';
			}



			$q = $db->select('*', 'canteen_orderslip','WHERE total <> "0.00" '.$ext. $m .' ORDER BY date_registered DESC ',2);
		}else{ 
			$q = $db->select('*', 'canteen_orderslip','WHERE user_inserted= "'.$_SESSION[SESUSER].'" '.$m.' ORDER BY date_registered DESC ',2);

		}


		if(count($q) < 1 AND empty($q)){
			$d =  "<h3 class='text-center'>We don't have any records now.</h3>";
		}else{
			
			foreach ($q as $key => $value) {
				
				$items = json_decode($value['order_list'], true);
				$items ='';
				foreach ($items as $key2 => $value2) {
					$items .= "<tr>
						<td>".$value2['qty']."</td>
						<td>".$value2['description']."</td>
						<td>".$value2['amount']."</td>
					</tr>";
				}



				$d .= "
					<div class='col-md-3'>
						<div class='card'>
							<div class='card-header'>
								<h6>Order Number: ".$value['id']." <br><small>".$value['date_registered']." / company: ".self::ucompany($value['company'], 'settings')."</small></h6>
							</div>
							<div class='card-body'>
								<table>
									<thead>
										<th>Qty</th>
										<th>Description</th>
										<th>Amount</th>
									</thead>
									<tbody>
										".$items."
									</tbody>
									<tfooter>
										<th></th>
										<th>Total</th>
										<th>".$value['total']."</th>
									</tfooter>
								</table>
							</div>
						</div>
					</div>
				";	
			}
			
		}

		return $d;
	}

	//remove items
	function removeobj($id, $tbl){
		$db = new DB();
		$db->delete($tbl, 'WHERE id="'.$id.'"');

	}


	//blank input checker
	function checkblank($data){

		foreach ($data as $key => $value) {
			
			if($value == ''){
				return self::notify(2,'Please fill all blank fields '.$value);
				 die();
			}
		}
	}

	function searchlisting($location, $ptype, $price, $pname){
		if($location != ''){
			$loc = "AND location='".$location."'";
		}else{
			$loc = '';
		}


		if($ptype != ''){
			$ptype = "AND prop_type='".$ptype."'";
		}else{
			$ptype = '';
		}

		if($price != ''){
			
			if($price == 'less2m'){
				$price = "AND price <= '2000000'";
			}elseif($price == '2_3'){
				$price = "AND price BETWEEN 2000000 AND 3000000";
			}elseif($price == '3_5'){
				$price = "AND price BETWEEN 3000000 AND 5000000";
			}elseif($price == '5_10'){
				$price = "AND price BETWEEN 5000000 AND 10000000";
			}else{
				$price = "AND price >= '10000000'";
			}
		}else{
			$price = '';
		}

		if($pname != ''){
			$pname = "AND prop_name='".$pname."'";
		}else{
			$pname = '';
		}

		$d = "";
		$db = new DB();
		$q = $db->select('*', 'erp_listing','WHERE status="1" '.$loc.' '.$ptype.' '.$price.''.$pname.'',2);
		
		// if(!empty($q)){

			foreach($q as $val){
				
			$img = $val['img'];

			if($img == ''){
				$imgs ='assets/images/demo-content/property-1.jpg';	
			}else{
				$img = json_decode($img, true);
				
				foreach ($img as  $chunkimg) { 

					$imgs = self::outimage($chunkimg, $val['prop_name']);
				}
			}

			$d .= "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3'>
			    <div class='ct-itemProducts ct-u-marginBottom30 ct-hover'>
			        <label class='control-label sale'>
			            ".self::status_property($val['status_prop'])."
			        </label>
			        <a href='product-single.php?pid=".$val['id']." '>
			            <div class='ct-main-content'>
			                <div class='ct-imageBox'>
			                    <img src='".$imgs."' alt='><i class='fa fa-eye'></i>
			                </div>
			                <div class='ct-main-text'>
			                    <div class='ct-product--tilte'>
			                        ".$val['complete_address']."
			                    </div>
			                    <div class='ct-product--price'>
			                        <!-- <span class='ct-price--Old'>$ 450,000</span> -->
			                        <span>Php ".number_format($val['price'])."</span>
			                    </div>
			                    <div class='ct-product--description'>
			                        ".self::string_limiter(self::nl2br2($val['description']),50)."
			                    </div>
			                </div>
			            </div>
			            <div class='ct-product--meta'>
			                
			            </div>
			        </a>
			    </div>
			</div>";
						
			}
		// }else{
		// 	$d = self::notify(2,"Their is no result for your search.");
		// }

		return $d;

	}
}

 ?>