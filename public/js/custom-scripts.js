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
	// ...


});