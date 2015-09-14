/************************** start of taskDetails.php ********************/
var mPageName  = "mFrontAjax.php";
var mAjaxFlag = 0;
//intial star rating plugin
$(".taskRating").rating({min:0, max:5, step:1,stars:5,size:'xs',glyphicon:false});

//script to confirm the rating
$(".taskRating").on('rating.change', function(event, value, caption){
	bootbox.confirm("Are you sure you want to give this task " + caption, function(result) {
		if(result) {
			var taskId = $("#mTaskId").val();
			var postData = {'taskId':taskId,'value':value,'action':'RateTask'};
			if(mAjaxFlag == 0){
				mAjaxFlag = 1;
				$.ajax({
					url:mPageName,
			        type:"POST",
			        data:postData,
			        scriptCharset:"application/x-www-form-urlencoded; charset=UTF-8",
			        success: function(result){
			        	mAjaxFlag = 0;
			        	if(result != 2){
			        		// $("input.taskRating").val();
			        		$(".mTmpRate").val(value);
			        		bootbox.alert("Rated successfully");
			        	}else{
			        		$('input.taskRating').rating('update', $(".mTmpRate").val());
			        		bootbox.alert("Failed to rate please try again later");
			        	}
			        },
			        error: function(){
			        	mAjaxFlag = 0;
			        }
				});
			}
		}else{
			$('input.taskRating').rating('update', $(".mTmpRate").val());
		}
	});
});

// script to clear the task rating
$('.taskRating').on('rating.clear', function(event) {
    bootbox.confirm("Are you sure you want to clear the rate", function(result) {
		if(result) {
			var taskId = $("#mTaskId").val();
			var postData = {'taskId':taskId,'value':null,'action':'RateTask'};
			if(mAjaxFlag == 0){
				mAjaxFlag = 1;
				$.ajax({
					url:mPageName,
			        type:"POST",
			        data:postData,
			        scriptCharset:"application/x-www-form-urlencoded; charset=UTF-8",
			        success: function(result){
			        	mAjaxFlag = 0;
			        	if(result != 2){
			        		$(".mTmpRate").val("");
			        		bootbox.alert("Cleared successfully");
			        	}else{
			        		$('input.taskRating').rating('update', "");
			        		bootbox.alert("Failed to clear the rate please try again later");
			        	}
			        },
			        error: function(){
			        	mAjaxFlag = 0;
			        }
				});
			}
		}else{
			$('input.taskRating').rating('update', $(".mTmpRate").val());
		}
	});
});

//script to view the attachments of the task
$("body").on("click",".mAttachs",function(){
	var attachId = $(this).attr("data-attach");
	var postData = {'attachId':attachId,'action':'showAttachs'};
	if(mAjaxFlag == 0){
		mAjaxFlag = 1;
		$.ajax({
			url:mPageName,
	        type:"POST",
	        data:postData,
	        scriptCharset:"application/x-www-form-urlencoded; charset=UTF-8",
	        success: function(result){
	        	mAjaxFlag = 0;
	        	if(result != ""){
	        		$("#mResDiv").html(result);
	        		$.subview({
					  content: "#mShowAttachs",
					  startFrom: "right",
					  onShow: function(){
					    $(".back-subviews").remove();
					  }
					});
	        	}else{
	        		alert("There is no attaches in this task");
	        	}
	        },
	        error: function(){
	        	mAjaxFlag = 0;
	        }
		});
	}
});
/*************************** end oftaskDetails.php **********************/