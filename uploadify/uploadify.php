<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$fileName = imgRename($_FILES['Filedata']['name']);
	$targetPath = "uploads/";
	$targetFile =  str_replace('//','/',$targetPath) . $fileName;
	if(!move_uploaded_file($tempFile,$targetFile))
	{
		echo "$(\"#message\").html($(\"#message\").html()+\"Upload To $targetFile UnSuccess  <br />\");";
	}else{
		echo "$(\"#message\").html(\"".$_POST['firstName']."\");";
	}
}

function imgRename($filename)
{
	$file = explode('.',$filename);
	$fileType = $file[count($file)-1];
	if($fileType=="gif"){
		return md5(date("U")).".gif";
	}else if($fileType=="jpg"){
		return md5(date("U")).".jpg";
	}else{
		return md5(date("U")).".png";
	}
}
?>