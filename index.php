<!DOCTYPE HTML>  
<html>
<head>
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title> Adlibs </title>
</head>
<body> 
<?php
	$dir = './';
	$story_lst = [];
	if($handle = opendir($dir)){
		while (false !== ($entry = readdir($handle))) {
			$file_parts = pathinfo($entry);
			if(array_key_exists('extension', $file_parts) && $file_parts['extension'] === 'json'){
				$full_path = "$dir/$entry";
				$story_txt = file_get_contents($full_path);
				$json_file = json_decode($story_txt);
				if($json_file !== null && array_key_exists('title', $json_file)){
					$title = $json_file->{'title'};
					$story["title"] = $title;
					$story["path"] = $full_path;
					$story_lst[] = $story;
				}
			}
		}
		closedir($handle);
	}
?>
<div class="page-header" align="center">
  <h1>Adlibs</h1>
  <h6>Note: in no way related to Madlibs</h6>
</div>
<form id="stories" action="adlib.php", method='POST'>
<?php
	$num = count($story_lst);
	for($i = 0; $i < $num; $i++){
		$title = $story_lst[$i]["title"];
		$path = $story_lst[$i]["path"];
?>
	<div class="form-group" align="center" id="mainList">
     <input type="submit" class="btn btn-info" id = "btn<?php echo $i;?>" name="<?php echo $path;?>" value="<?php echo $title;?>" >
	</div>
<?php
    }
?>
</form>
</body>
</html>