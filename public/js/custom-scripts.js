/* 
* custom scripts
*/

$(document).ready(function() {

	// admin page - users table
	$('#userstable1').DataTable()

	// admin page - create new user form
	var chk1 = $("input[type='checkbox'][name='admin'][value='true']");
	var chk2 = $("input[type='checkbox'][name='actuator'][value='true']");
	chk1.on('change', function(){
	  chk2.prop('checked',this.checked);
	});

	// admin page - reset psw form
	var inpt1 = "<input type='password' name='password' placeholder='Nuova password'>",
		inpt2 = "<input type='password' name='password_confirmation' placeholder='Reimmetti password'>";	
	function isEmpty(el){
      return !$.trim(el.html())
  	}	
	$("div[id^='reset-psw-']").click(function(){
		if(!isEmpty($(this).next())) {	
			$(".rst-psw>input[name='password']").remove();
			$(".rst-psw>input[name='password_confirmation']").remove();
		} else {
			$(this).next().html(inpt1+inpt2); 
		}
	});
	
	// toggle widgets top-right button
	$('#widgets-list').click(function () {
		if($('#widgets-list a i').hasClass('fa-chevron-left')) {
			$('#widgets-list a i').removeClass('fa-chevron-left');
			$('#widgets-list a i').addClass('fa-chevron-right'); 
		} else {      
			$('#widgets-list a i').removeClass('fa-chevron-right');
			$('#widgets-list a i').addClass('fa-chevron-left'); 
		}
	}); 

	// admin page - change logo form
	$("input[id^='input-logo-']").hide();
	$("button[id^='change-logo-']").click( function(e){	
		e.preventDefault();
		$("input[id^='input-logo-']").toggle();
	});

									

});