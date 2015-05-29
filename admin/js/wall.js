$(document).ready(function(){
	// Update Status
	$(".update_button").click(function(){
		var updateval = $("#update").val();
		var dataString = 'update='+ updateval;
		
		if(updateval=='')
		{
			alert("Por favor digite seu Post !!!");
		}
		else
		{
			$("#flash").show();
			$("#flash").fadeIn(400).html('Carregando Post...');
			$.ajax({
				type: "POST",
				url: "message_ajax.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#flash").fadeOut('slow');
					$("#content").prepend(html);
					$("#update").val('');	
					$("#update").focus();
					$("#stexpand").oembed(updateval);
				}
			});
		}
		return false;
	});
	
	//commment Submint
	$('.comment_button').live("click",function(){

		var ID = $(this).attr("id");

		var comment= $("#ctextarea"+ID).val();
		var dataString = 'comment='+ comment + '&msg_id=' + ID;

		if(comment==''){
			alert("Por favor digite seu Post !!!");
		}
		else{
			$.ajax({
				type: "POST",
				url: "comment_ajax.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#commentload"+ID).append(html);
					$("#ctextarea"+ID).val('');
					$("#ctextarea"+ID).focus();
				 }
			});
		}
		return false;
	});
	
	// commentopen 
	$('.commentopen').live("click",function(){
		var ID = $(this).attr("id");
		$("#commentbox"+ID).slideToggle('slow');
		return false;
	});	

	// delete comment
	$('.stcommentdelete').live("click",function(){
		var ID = $(this).attr("id");
		var dataString = 'com_id='+ ID;

		if(confirm("Tem certeza que deseja excluir este coment\u00e1rio?")){

			$.ajax({
				type: "POST",
				url: "delete_comment_ajax.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#stcommentbody"+ID).slideUp();
				}
			});
		}
		return false;
	});
	
	// delete update
	$('.stdelete').live("click",function(){
		var ID = $(this).attr("id");
		var dataString = 'msg_id='+ ID;

		if(confirm("Tem certeza que deseja excluir este post?")){

			$.ajax({
				type: "POST",
				url: "delete_message_ajax.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#stbody"+ID).slideUp();
				}
			});
		}
		return false;
	});
});
