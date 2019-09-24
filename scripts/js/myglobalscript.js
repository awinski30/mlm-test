//login script
$('#loginbtn').click(function(){
	var uname = $('#uname').val();
	var pass = $('#pass').val();

	if(uname == '' || pass == ''){
		
		$('.status').html('<br> <?php echo $glob->notify(2,"Please insert your username and password to proceed."); ?>');
	}

	$.post('phpfunc/loginscript.php',{uname:uname, pass:pass},function(data){
		// $('#statusmod').html(data);

		// $('#statusmodal').modal('toggle');

		// //hide after 5secs
		// setTimeout(function(){
		//     $('#statusmodal').close();
		// }, 10000);

		$('.status').html(data);
	});
});


//email verificartion
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}


//buy points script
$(document).on('click', '#buycred', function(){
	$.post('phpfunc/actions.php?ac=buycredit', $('#data-form-buycredits').serialize() ,function(data){
		
			$('#statusmod').html(data);

			$('#statusmodal').modal('toggle');

			//hide after 5secs
			setTimeout(function(){
			    $('#statusmodal').close();
			}, 5000);

	});
})



$(document).on('click', '#redeemcred', function(){
	$.post('phpfunc/actions.php?ac=redeemcredit', $('#data-form-withdrawcredits').serialize() ,function(data){
		
			$('#statusmod').html(data);

			$('#statusmodal').modal('toggle');

			//hide after 5secs
			setTimeout(function(){
			    $('#statusmodal').close();
			}, 5000);

	});
})



//registration script
$(document).on('click', '.reg', function(){
	var pass = $('#signpass').val();
	var cpass = $('#cpass').val();
	var email = $('#email').val();

	// console.log(isEmail(email));

	if(isEmail(email) == false){
		$('#statusmod').html('Email is not valid.');

			$('#statusmodal').modal('toggle');

			//hide after 5secs
			setTimeout(function(){
			    $('#statusmodal').close();
			}, 5000);

				
	}else if(pass == cpass){
		$.post('phpfunc/actions.php?ac=register', $('#form-data-reg').serialize() ,function(data){
		
			$('#statusmod').html(data);

			$('#statusmodal').modal('toggle');

			//hide after 5secs
			setTimeout(function(){
			    $('#statusmodal').close();
			}, 5000);

		});
	}else{

		$('#statusmod').html('Password do not match.');

		$('#statusmodal').modal('toggle');

			//hide after 5secs
			setTimeout(function(){
			    $('#statusmodal').close();
			}, 3000);

	}


	
});