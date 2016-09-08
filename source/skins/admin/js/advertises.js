$(document).ready(function(){
	$("#change-block").change(function(){
		var id_block = $(this).val();
		if(_reset == 0){
			$("#change-page").prop('disabled', true);
			_reset = 1;
			$.ajax({
				url:base_url+"admin/advertises/get_page",
				type:"post",
				dataType:"json",
				data:{"id":id_block},
				success:function(data){
					var html = "";
					if(data["success"] == "success"){
						html ='<option value="">----chọn page----</option>';
						$.each(data["page"],function(key,value){
							html +='<option value="'+value["ID"]+'">'+value["Page"]+'</option>';
						});
						$("#change-page").html(html);
						$("#change-page").prop('disabled', false);
					}

					_reset = 0;
				},
				error:function(){
					_reset = 0;
				}
			});
		}
	});
});