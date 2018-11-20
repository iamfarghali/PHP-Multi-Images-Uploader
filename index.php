<!DOCTYPE html>
<html>
<head>
	<title>PHP Uploader</title>
</head>
<body>
	<form action="process.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<span>Select Images :</span>
		<input type="file" name="image[]" multiple> <br/><hr>
		<input type="submit" name="submit" value="Upload">
	</form>	
</body>
</html>