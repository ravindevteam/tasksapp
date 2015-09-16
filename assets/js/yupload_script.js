// Variable to store your files
var files;

// Add events
$('input#yfile').on('change', prepareUpload);

// Grab the files and set them to our variable
function prepareUpload(event)
{
  files = event.target.files;
  $(this).submit();
}

$('input#yfile').on('submit', uploadFiles);

// Catch the form submit and upload the files
function uploadFiles(event)
{
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening
    var attach_id = $(".attach_id").val();
    // Create a formdata object and add the files
    var datax = new FormData();
    $.each(files, function(key, value)
    {
        datax.append(key, value);
    });
    $.ajax({
        url: 'ysubmit_upload.php?attach_id=' + attach_id,
        type: 'post',
        dataType:"JSON",
        data: datax,
        cache: false,
        processData: false, // Don't process the files
        contentType: false // Set content type to false as jQuery will tell the server its a query string request
    }).done(function(html){
        if(html.flag == 1){
            alert('Done');
            $(".attach_id").val(html.new_attach_id);
            $("#yAttachResults").html("");
            $("#yAttachResults").html(html.returnData);
        }else if(html.flag == 2){
            alert("failed to add");
        }else if(html.flag == 3){
            alert("failed to upload");
        }
    });
}