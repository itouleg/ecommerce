<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="uploadify.css" />
<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript" src="jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'  : 'uploadify.swf',
    'script'    : 'uploadify.php',
    'cancelImg' : 'cancel.png',
    'folder'    : '/uploads',
	'multi'          : true,
    'auto'      : false,
	'fileExt'        : '*.jpg;*.gif;*.png',
	'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
	'sizeLimit'   : 10240000,
	'removeCompleted': false,
	'buttonText'  : 'SELECT FILES',
	//'buttonImg' : 'Upload-Folder-icon.png',
	'method' : 'post',
	'wmode'       : 'transparent',
  	'hideButton'  : false,
	//'scriptData'  : {'firstName':'Ronnie','age':30},
	'onComplete'  : function(event, ID, fileObj, response, data) {
       eval(response);
    },
	'onAllComplete' : function(event,data){
		//data.filesUploaded
		//data.errors
		//data.allBytesLoaded
		//data.speed
		//send Form Data
		//alert(data.allBytesLoaded+$("#frm").serialize());
	},
	//'queueID'        : 'custom-queue',
	//'queueSizeLimit' : 3,
	//'simUploadLimit' : 3,
	/*'onDialogClose'   : function(queue) {

      $('#status-message').text(queue.filesQueued + ' files have been added to the queue.');

    },
	'onQueueComplete'  : function(stats) {

      $('#status-message').text(stats.successful_uploads + ' files uploaded, ' + stats.upload_errors + ' errors.');

    }*/
  });
  $("#btupload").click(function(){
		$('#file_upload').uploadifySettings('scriptData',{'firstName':$("#data").val(),'age':30});
		$('#file_upload').uploadifyUpload();
	});
});
</script>
</head>

<body>
<div id="message"></div>
<form id="frm">Data <input id="data" type="text" name="data" /><br /></form>
<input id="file_upload" type="file" name="Filedata" />
<input type="button" id="btupload" value="Upload" />
</body>
</html>