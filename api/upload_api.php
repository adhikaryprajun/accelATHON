<?php
    
    // TODO Check Hash
    $hash_value=$_POST['session_hash'];
	if(isset($_POST['session_hash'])){
		
		$sql="SELECT * FROM sessions WHERE session_hash ='".$hash_value."';";
		$result=$mysqli->query($sql);
		if($result->num_rows >0){
			while($row=$result->fetch_assoc()){
				$user_id=row['user_id'];
			}
			
			// TODO Upload Image
			if(isset($_POST['description']) && isset($_POST['type']) && isset($_FILES['picture'])) {
				$descrpition=$_POST['description'];
				$type=$_POST['type'];
				$currentDir = getcwd();
				$uploadDirectory = "/uploads/";

				$errors = []; // Store all foreseen and unforseen errors here

				$fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
				 
				$fileName = $_FILES['picture']['name'];
				$fileSize = $_FILES['picture']['size'];
				$fileTmpName  = $_FILES['picture']['tmp_name'];
				$fileType = $_FILES['picture']['type'];
				$fileExploded = explode('.',$fileName);
				$fileExtension = end($fileExploded);

				$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
				//echo $uploadPath;

				//if (isset($_POST['submit'])) {

					if (! in_array($fileExtension,$fileExtensions)) {
						$errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
						$json->code="400";
						$json->message="ERROR:This file extension is not allowed. Please upload a JPEG or PNG file";
					}

					if ($fileSize > 2000000) {
						$errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
						$json->code="400";
						$json->message="ERROR:This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
					}

					if (empty($errors)) {
						$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

						if ($didUpload) {
							//echo "The file " . basename($fileName) . " has been uploaded";
							$json->code="200";
							$json->message="The file " . basename($fileName) . " has been uploaded";
							$description=$_POST['description'];
							$type=$_POST['type'];
							$address=$_POST['address'];
							$insertsql="INSERT INTO uploads(user_id,description,address,picture,type) VALUES(".$user_id.",'".$description."','".$address."','".$fileName."',".$type.");";
							$res=$mysqli->query($insertsql);
								if($res->num_rows == 0){
									$json->code="400";
									$json->message="EROR:database was not updated";
								}
						} else {
							//echo "An error occurred somewhere. Try again or contact the admin";
							$json->code="400";
							$json->message="ERROR:An error occurred somewhere. Try again or contact the admin";
						}
					} else {
						$json->code="400";
						$json->message=$errors;
						//foreach ($errors as $error) {
							//echo $error . "These are the errors" . "\n";
						//}
					}
				//}
			}else{
				$json->code="400";
				$json->message="ERROR:Invalid request";
			}
		}else{
			$json->code="400";
			$json->message="ERROR:hash value not found";
		}
	}else{
		$json->code="400";
		$json->message="ERROR:hash value invalid";
	}

print_r(json_encode($json));	
    


?>