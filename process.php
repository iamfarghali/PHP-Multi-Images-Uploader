<?php
	include('connection.php');

	const DS = DIRECTORY_SEPARATOR;
	if ( !empty($_POST['submit']) ):
		if ( $_FILES['image']['error'][0] == 4 ):
			echo 'There Is No File To Upload! <br/><hr/>';
		else:
			$data = $_FILES;
			// echo "<pre>";
			// 	print_r($data);
			// echo "</pre>";	
			$imagesName 	= $data['image']['name'];
			$imagesType 	= $data['image']['type'];
			$imagesTmpName 	= $data['image']['tmp_name'];
			$imagesError 	= $data['image']['error'];
			$imagesSize 	= $data['image']['size'];
			$allowedImageTypes = ['jpeg', 'png', 'jpg', 'gif'];
			$errors = [];

			// Store every error for every image in $errors array
			foreach ($imagesError as $key => $errorCode) {
				switch ($errorCode) {
					case 1:
					case 2:
						$errors[$key] = '<div>The Size of '. $imagesName[$key] .' should be 2MB or less.</div>';
						break;
					case 3:
						$errors[$key] = '<div>Please try to upload this file '. $imagesName[$key] .' again.</div>';
						break;
				}
			}

			if (empty($errors)):

				// Store error message for every file has invalid extension in $errors array
				foreach ($imagesName as $key => $imageName) {
					$tmp = explode('.', $imageName);
					$img_extension = end($tmp);
					if ( !in_array($img_extension, $allowedImageTypes) ) {
						$errors[$key] = '<div>This file '. $imageName .' has invalid extension.</div>';
					}
				}

				// If extension of all files is valid
				if (empty($errors)):
					foreach ($imagesName as $key => $imageName) {
						$tmp = explode('.', $imageName);
						$imgNewName = rand(0, 9999999).time().'.'.end($tmp);
						$imgPath = realpath(dirname(__FILE__)).DS.'uploaded'.DS.$imgNewName;
						move_uploaded_file($imagesTmpName[$key], $imgPath);
						// Insert to database
						$query = 'INSERT INTO image SET image_name = :name';
						$stmt = $conn->prepare($query);
						$stmt->execute([
							':name'=>$imgNewName
						]);
						
					}
					header('Location:index.php');
				else:
					foreach ($errors as $error) {
					echo $error;
					}
				endif;
			else:
				foreach ($errors as $error) {
					echo $error;
				}
			endif;
		endif;
	endif;
?>