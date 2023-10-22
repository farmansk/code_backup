<?php



// 임시로 저장된 정보(tmp_name)
$tempFile = $_FILES['Filedata']['tmp_name'];

// 파일타입 및 확장자 체크
$fileTypeExt = explode("/", $_FILES['Filedata']['type']);

// 파일 타입 
$fileType = $fileTypeExt[0];

// 파일 확장자
$fileExt = $fileTypeExt[1];

if ( $fileExt == "jpeg" ) {
  
 $fileExt = "jpg";

}
  
      
// 확장자 검사
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}




if($fileType == 'image'){

	if($extStatus){


  
		$resFile = "../../../uploads/{$_FILES['Filedata']['name']}";

    if( file_exists($resFile) ) {

      $FileName = substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], ".")) . date('mdYhisa', time()) . "." . $fileExt;
     
    }
    else {
      
      $FileName = substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], ".")) . "." . $fileExt;
      
    }  
    
		$resFile = "../../../uploads/".$FileName;
		
		$imageUpload = move_uploaded_file($tempFile, $resFile);
		

		if($imageUpload == true){

			echo "<img src='{$resFile}' width='100' />";
			
		}else{
		  

		  echo "<script>";  
	    echo "alert('파일 업로드에 실패하였습니다.');";  
	    echo "self.close();";  
	    echo "</script>";  
		  exit;
		  
		}
		
	}	
	
	else {
	  

	  
		echo "<script>";  
	  echo "alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.');";  
	  echo "self.close();";  
	  echo "</script>";  
	

	
		exit;
		
	}	
	
	
}

else {


  
 echo "<script>";
 echo "alert('이미지 파일이 아닙니다.');";
 echo "self.close();";
 echo "</script>";

 exit;
 
}



?>

<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />


<script>

var sHTML = "<img src='http://<?=$_SERVER[ "HTTP_HOST" ]?>/uploads/<?=$FileName?>' style='width:auto'>";
opener.nhn.husky.PopUpManager.setCallback(window,'PASTE_HTML',[sHTML]);
self.close() ;

</script>
