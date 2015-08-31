/*************************** start of taskDetails.php ********************/
//intial star rating plugin
$(".taskRating").rating({min:0, max:5, step:1,stars:5,size:'xs',glyphicon:false});

//script to confirm the rating
$(".taskRating").on('rating.change', function(event, value, caption){
	if(confirm("Are you sure you want to give this task " + value + " starts as a rating")){
		alert("done");
	}
});
/*************************** end oftaskDetails.php ***********************/