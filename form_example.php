<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $websiteErr = "Invalid URL";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="page-header">
  <h2>PHP Form Validation Example</h2>
</div>
<p class="text-danger">* required field.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<div class="col-xs-4">
		<div class="form-group">
			<label for="name"><span class="error">*</span> Name: </label>
			<div class = "input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type="text" class="form-control" name="name"  placeholder="Name" value="<?php echo $name;?>" required>
			</div>
			<label><span class="error"><?php echo $nameErr;?></span></label>
		</div>
		<div class="form-group">
			<label for="email"><span class="error">*</span>E-mail:</label>
			<div class = "input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type="text" class="form-control" name="email" placeholder="E-mail"value="<?php echo $email;?>" required>
			</div>
			<label><span class="error"><?php echo $emailErr;?></span></label>
		</div>
		<div class="form-group">
			<label for="website"><span class="error">*</span>Website:</label>
			<div class = "input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
				<input type="text" class="form-control" name="website" placeholder = "Website" value="<?php echo $website;?>" required>
			</div>
			<label><span class="error"><?php echo $websiteErr;?></span></label>
		</div>
		<div class="form-group">
			<label for="comment">Comment:</label>
			<textarea name="comment" class="form-control" rows="5" cols="40" placeholder="Comments" ><?php echo $comment;?></textarea>
		</div>
		<div class="form-group">
			<label for="gender"><span class="error">*</span> Gender:</label> 
			<div class="radio">
				<label><input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male</label>
			</div>
			<label><span class="error"><?php echo $genderErr;?></span></label>
		</div>
			<input type="submit" class="btn btn-default"  name="submit" value="Submit">  
	</div>
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;
?>

</body>
</html>