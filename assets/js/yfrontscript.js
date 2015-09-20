var yPageName  = "yFrontAjax.php";
//****************Creat task page*******************//
//script to get employees names
$("#selJob").select2("val").on('change', function(){
	var jobId  = $("#selJob").select2("val");
	if (jobId != "") {
		$.ajax({
			url: yPageName,
			data: {"action": "getEmployees", "jobId": jobId}
		}).done(function(html) {
			$("#selEmps").html("");
			$("#selEmps").html(html);
		});
	}
});
//script to get task type
$('input.type-callback').on('ifChecked', function(event) {
	var value = $(this).val();
	if(value == 1){
		$(".repeated").show();
		$(".normal").hide();
		$("#taskDate").removeAttr("name");
		$(".repeatedType").each(function(){
			$(this).attr('name','period');
		});
		$(".date-range").val();
	}else if (value == 2){
		$(".repeated").hide();
		$(".normal").show();
		$("#taskDate").attr('name', 'taskDate');
		$(".repeatedType").each(function(){
			$(this).removeAttr("name");
		});
		$('input:radio[name="period"]').removeClass("active");
	}
});
//script to view the attachments of the task
$("body").on("click",".yUpload",function(){
	$.subview({
      content: "#yfileUpload",
      startFrom: "right",
      onShow: function(){
        $(".back-subviews").remove();
      },
      onClose: function(){
        $.hideSubview();
      }
    });
});