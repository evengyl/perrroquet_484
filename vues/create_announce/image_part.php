<div class="col-xs-12 panel panel-default" style="margin-top:15px; background:url(<?= $slides; ?>) no-repeat center;">
	<div class="panel-heading" role="tab" id="headingOne" style="margin-top:15px;">
		<h4>Ajouter dès à présent vos photos / images (10 Max)<br>
		<small class="text-muted thin">(La première sera utilisée comme images principale de votre annonce)</small>
		<small class="text-muted thin">(Format supporté : Jpg, Png, Gif)</small></h4>
	</div>
	<div class="panel-body">
		<div class="col-xs-12 dropzone" id="dropzone_img_upload"></div>
	    <hr>
		<div class="row col-xs-12" id="list_image_uploaded"></div>
	</div>
</div>


<script>

var url_uploads = "/ajax/controller/upload_image_annonces.php";
var accept = ".png,.jpg,.jpeg,.bnp,.gif,.tif";
Dropzone.autoDiscover = false;



// Dropzone class:
var myDropzone = new Dropzone("#dropzone_img_upload",
{
	url: "/ajax/controller/upload_image_annonces.php",
	paramName: "file",
    acceptedFiles: accept,
    createImageThumbnails: true,
    addRemoveLinks: true,
    maxFiles: 10,
    clickable: true,
    success: function(data){
    	list_preview();
    }

});

$(document).ready(function()
{
	list_preview();
});


function list_preview()
{
	$.ajax({
		url: url_uploads,
		type: 'GET',
		data: "option=preview_img",
		dataType: "html",
		success:function(data){
			$('#list_image_uploaded').html(data);

			$("button[data-option='delete_img']").on('click', function(event){
				delete_img($(this).data("id-img"))
			});
		}
	});
}

function delete_img(id)
{
 	$.ajax({
		url: url_uploads,
		type: 'GET',
		data: "option=delete_img&id_img="+id+"",
		dataType: "html",
		success:function(data){
			list_preview();
		}
	});
}

</script>