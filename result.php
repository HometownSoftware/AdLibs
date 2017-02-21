<!DOCTYPE HTML>  
<html>
<head>
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title><!--TITLE--></title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//var_dump($_POST);
	$data = $_POST;
	$filestr = '';
	$text = '';
	$title = "Adlibs";
	$places = [];
	foreach($data as $key => $value){
		$keymatch = strpos($key, '_//') !== false && strpos($key, '_json') !== false;
		if($keymatch !== false){
			$filestr = $key;
		}
		else{
			if($value == ''){
				$places[] = '__________';
			}
			else{
				$places[] = "<b>$value</b>";
			}
		}
		//var_dump($keymatch);
	}
	$filename = str_replace('_','.',$filestr);
	$json_file = json_decode(file_get_contents($filename));
	if($json_file !== null){
		if(array_key_exists('text', $json_file)){
			$text = $json_file->{'text'};
		}
		if(array_key_exists('title', $json_file)){
			$title = $json_file->{'title'};
		}
	}
	// title replacement
	$pageContents = ob_get_contents ();
	ob_end_clean (); //clear page before getting title
	echo str_replace ('<!--TITLE-->', $title, $pageContents);
	// replace those words
	$count = count($places);
	for($i = 0; $i < $count; $i++){
		$pos = "/\{$i\}/";
		$text = preg_replace($pos, $places[$i], $text);
	}
	
	$paragraphs = preg_split('/\n+/', $text);
	//for redo
	$dir = './';
	$path = "$dir/$filename";
}
else{
	$title = "No story";
	$text = 'No story here...';
	$pageContents = ob_get_contents ();
	ob_end_clean (); //clear page before getting title
	echo str_replace ('<!--TITLE-->', $title, $pageContents);
}
?>
<div class="container">
  <div class="jumbotron" align = "center">
    <h1><?php echo $title; ?></h1>
    <p><?php
	if(isset($paragraphs)){
		foreach($paragraphs as $p)
		{
			if(strlen($p) > 0){
				echo "<p align=\"left\">$p</p>";
			}
		} 
	}
	else{
		echo $text; 
	}
	?>
	</p>
  </div>
	<div class="form-group" align="center" id="mainList">
		<?php
			if(isset($path)){
		?>
		<form name="story" action="adlib.php" align="center" method='POST'>
			<input type="submit" class="btn btn-info" id = "back" name="<?php echo $path;?>" value= "Redo" align="center">
		</form>
		<?php
			}
		?>
		<form name="back" action="index.php" align="center" method='POST'>
			<input type="submit" class="btn btn-info" id = "home" value= "Pick another story" align="center">
		</form>
	</div>
</div>

</body>
</html>