/************************** start of taskDetails.php ********************/
var mPageName  = "mFrontAjax.php";
var mAjaxFlag = 0;
//intial star rating plugin
$(".taskRating").rating({min:0, max:5, step:1,stars:5,size:'xs',glyphicon:false});

//script to confirm the rating
$(".taskRating").on('rating.change', function(event, value, caption){
	bootbox.confirm("Are you sure you want to give this task " + caption, function(result) {
		if(result) {
			var taskId   = $("#mTaskId").val();
			var assignee = $("#assignee").val();
			var postData = {'taskId':taskId,'assignee':assignee,'value':value,'action':'RateTask'};
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
			        	bootbox.alert("The server is not responding, please try again later");
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
			var taskId   = $("#mTaskId").val();
			var assignee = $("#assignee").val();
			var postData = {'taskId':taskId,'assignee':assignee,'value':null,'action':'RateTask'};
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
			        	bootbox.alert("The server is not responding, please try again later");
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
	        	bootbox.alert("The server is not responding, please try again later");
	        }
		});
	}
});

//script to comment on the task
$("body").on("click","#addcom",function(){
	var commentFlag = $(".commentFlag").val();
	var commentarea = $("#commentarea").val();
	var attach_id   = $("#attach_id").val();
	var usr         = $("#usr").val();
	var task        = $("#mTaskId").val();
	var commentors  = new Array();
	$(".commentor").each(function(){
		commentors.push($(this).val());
	});
	var postData    = {'commentarea':commentarea,'commentors':commentors,'attach_id':attach_id,'usr':usr,'task':task,'action':'commentOnTask'};
	if(commentarea != "" || attach_id != "e"){
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
		       			$("#commentarea").val("");
		       			$("#attach_id").val("e");
		        		$("#ulComment").html(result);
		        		$(".mTaskUploadFile").val("");
		        	}else{
		        		bootbox.alert("Failed to comment, please try again later");
		        	}
		        },
		        error: function(){
		        	mAjaxFlag = 0;
		        	bootbox.alert("The server is not responding, please try again later");
		        }
			});
		}
	}
});

//code to upload attachments without refreshing the page
var files;

// Add events
$('input.mTaskUploadFile').on('change', fixedPrepareUpload);

// Grab the files and set them to our variable
function fixedPrepareUpload(event)
{
files = event.target.files;
$(this).submit();
}

$('input.mTaskUploadFile').on('submit', fixedUploadFiles);
// Catch the form submit and upload the files
function fixedUploadFiles(event)
{
  event.stopPropagation(); // Stop stuff happening
  event.preventDefault(); // Totally stop stuff happening

  // Create a formdata object and add the files
  var datax = new FormData();
  var aid   = $("#attach_id").val();
  $.each(files, function(key, value)
  {
      datax.append(key, value);
  });

  $.ajax({
      url: mPageName + '?aid=' + aid,
      type: 'POST',
      data: datax,
      cache: false,
      dataType: 'json',
      processData: false, // Don't process the files
      contentType: false // Set content type to false as jQuery will tell the server its a query string request
  }).done(function(html){
      $("#attach_id").val(html.naid);
      if(html.status != ""){
      	bootbox.alert(html.status);
      }
  });
}

//script to dispute
$("body").on("click","#dispute",function(){
	var task     = $("#mTaskId").val();
	var creator  = $("#creator").val();
	var postData = {'task':task,'creator':creator,'action':'disputAction'};
	if(mAjaxFlag == 0){
		mAjaxFlag = 1;
		$.ajax({
			url:mPageName,
	        type:"POST",
	        data:postData,
	        scriptCharset:"application/x-www-form-urlencoded; charset=UTF-8",
	        success: function(result){
	        	mAjaxFlag = 0;
	        	if(result == 1){
	        		bootbox.alert("The task creator manager is called to this task");
	        	}else if(result == 2){
	        		bootbox.alert("The task creator don't have manager");
	        	}else if(result == 3){
	        		bootbox.alert("Failed to dispute, please try again later");
	        	}else{
	        		bootbox.alert("The server is not responding, please try again later");
	        	}
	        },
	        error: function(){
	        	mAjaxFlag = 0;
	        	bootbox.alert("The server is not responding, please try again later");
	        }
		});
	}
});
/*************************** end oftaskDetails.php **********************/
/*************************** header scripts *****************************/
$("body").on("click", ".logout", function(e){
	e.preventDefault();
	var postData = {'action':'logoutAction'};
	if(mAjaxFlag == 0){
		mAjaxFlag = 1;
		$.ajax({
			url:mPageName,
	        type:"POST",
	        data:postData,
	        scriptCharset:"application/x-www-form-urlencoded; charset=UTF-8",
	        success: function(result){
	        	mAjaxFlag = 0;
	        	window.location.href="index.php";
	        },
	        error: function(){
	        	mAjaxFlag = 0;
	        	bootbox.alert("The server is not responding, please try again later");
	        }
		});
	}
});
/*************************** end header scripts *************************/