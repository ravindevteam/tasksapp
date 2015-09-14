/************************** start of taskDetails.php ********************/
var mPageName  = "mFrontAjax.php";
var mAjaxFlag = 0;
//intial star rating plugin
$(".taskRating").rating({min:0, max:5, step:1,stars:5,size:'xs',glyphicon:false});

//script to confirm the rating
$(".taskRating").on('rating.change', function(event, value, caption){
	$(".mRate").attr("data-value",value);
	$(".rate-config").click();
});
$("body").on("click",".mRate",function(){
	var taskId = $("#mTaskId").val();
	var value  = $(this).attr("data-value");
	$(".confirmRate").html("Are you sure you want to rate this task with (" + value + ") stars");
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
	        		alert("Rated successfully");
	        		$(".mRate").attr("data-value","");
	        		$(".mCancel").click();
	        	}else{
	        		alert("Failed to rate please try again later");
	        		$(".mRate").attr("data-value","");
	        		$(".mCancel").click();
	        	}
	        },
	        error: function(){
	        	mAjaxFlag = 0;
	        }
		});
	}
});

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