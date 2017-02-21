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
	$data = $_POST;
	$title = '';
	$terms_lst = [];
	// should only be one key
	foreach($data as $key => $value){
		$filestr = $key;
		break;
	}
	$filename = str_replace('_','.',$filestr);
	$json_file = json_decode(file_get_contents($filename));
	// json file itself (title already retrieved)
	if($json_file !== null){
		if(array_key_exists('terms', $json_file)){
			$terms = $json_file->{'terms'};
			foreach($terms as $k){
				$terms_lst[] = $k;
			}
		}
		if(array_key_exists('title', $json_file)){
			$title = $json_file->{'title'};
		}
	}
	$pageContents = ob_get_contents ();
	ob_end_clean (); //clear page before getting title
	echo str_replace ('<!--TITLE-->', $title, $pageContents);
?>
<div class="page-header" align="center">
  <h1><?php echo $title;?></h1>
</div>

<form name="back" action="index.php" align="center">
	<input type="submit" class="btn btn-info" id = "back" value= "Back" align="center">
</form>
<form name="stories" action="result.php" method="POST">
<div class="col-xs-4">
<?php
	$num = count($terms_lst);
	for($i = 0; $i < $num; $i++){
		$term = $terms_lst[$i];
?>
		<div class="form-group">
			<label for="tBox<?php echo $i;?>"><?php echo $term;?></label>
			<input type="text" class="form-control" name="tBox<?php echo $i;?>"  value = "">
		</div>	
<?php
   }
?>
     <input type="submit" class="btn btn-info" id = "submit" name="<?php echo $filename;?>" value="Submit" align="center">
	 
</form>
</div>
<?php
}
// Blank story case
else{
	$no_story = 'No story selected';
	$pageContents = ob_get_contents ();
	ob_end_clean ();
	echo str_replace ('<!--TITLE-->', $no_story, $pageContents);
?>
	<div class="page-header" align="center">
	  <h1><?php echo $no_story;?></h1>
	</div>
	<form name="back" action="index.php" align="center">
		<input type="submit" class="btn btn-info" id = "back" value= "Back" align="center">
	</form>
<?php
   }
?>

</body>
</html>