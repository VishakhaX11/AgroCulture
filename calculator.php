<?php

session_start();
if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] == 0)
{
	$_SESSION['message'] = "You need to first login to access this page !!!";
	header("Location: Login/error.php");
}

if (isset($_POST['crop-name'])) {
	$conn = new PDO("mysql:host=localhost;dbname=AgroCulture", "root", "");
  
	// Get the crop name from the POST variable.
	$crop_name = $_POST['crop-name'];
  
	// Define the crop_name parameter.
	$param_crop_name = 's';
  
	// Bind the crop_name parameter to the ? placeholder in the SELECT statement.
	$stmt = $conn->prepare("SELECT nitrogen, phosphorus, potassium FROM crops WHERE crop_name = ?");
	$stmt->bindParam($param_crop_name, $crop_name);
  
	// Execute the SELECT statement.
	$stmt->execute();
  
	// Get the result of the SELECT statement.
	$result = $stmt->fetch();
  
	// Check if the result is empty.
	if ($result === false) {
	  echo "The crop name you entered does not exist.";
	  return;
	}
  
	// Get the nitrogen requirement for the crop.
	$nitrogen_requirement = $result['nitrogen'] * $plant_age;
  
	// Get the phosphorus requirement for the crop.
	$phosphorus_requirement = $result['phosphorus'] * $plant_age;
  
	// Get the potassium requirement for the crop.
	$potassium_requirement = $result['potassium'] * $plant_age;
  
	// Calculate the amount of fertilizer to add.
	$nitrogen_to_add = $nitrogen_requirement - $result['nitrogen'];
	$phosphorus_to_add = $phosphorus_requirement - $result['phosphorus'];
	$potassium_to_add = $potassium_requirement - $result['potassium'];
  
	// Display the results.
	echo "The amount of nitrogen to apply is " . $nitrogen_to_add . " pounds.";
	echo "<br>";
	echo "The amount of phosphorus to apply is " . $phosphorus_to_add . " pounds.";
	echo "<br>";
	echo "The amount of potassium to apply is " . $potassium_to_add . " pounds.";
  } 

function validateForm() {
  // Check the crop name field.
  if (empty($_POST['crop-name'])) {
    alert('Please enter a crop name.');
    return false;
  }
  $conn = new PDO("mysql:host=localhost;dbname=AgroCulture", "root", "");
$stmt = $conn->prepare("SELECT nitrogen, phosphorus, potassium FROM crops WHERE crop_name = ?");
$param_crop_name = 's';
$stmt->bindParam($param_crop_name, $crop_name);

// Bind the crop_name parameter to the ? placeholder in the SELECT statement.
$stmt->bindParam($param_crop_name, $crop_name);

  // Define the param_crop_name variable and assign it the value of the crop name field.
  $param_crop_name = $_POST['crop-name'];

  // Check if the crop name is valid.
  if (!preg_match('/^[a-z]+$/', $param_crop_name)) {
    alert('The crop name must only contain lowercase letters.');
    return false;
  }

  return true;
}

function getNutrientRequirements($crop_name) {
  // Connect to the database.
  $conn = new PDO("mysql:host=localhost;dbname=AgroCulture", "root", "");

  // Define the stmt variable.
  $stmt = $conn->prepare("SELECT nitrogen, phosphorus, potassium FROM crops WHERE crop_name = ?");

  // Bind the crop_name parameter to the ? placeholder in the SELECT statement.
  $stmt->bindParam("s", $crop_name);

  // Execute the SELECT statement.
  $stmt->execute();

  // Return the first row of the result set.
  return $stmt->fetch();
}
?>

<a href="<?php echo $link; ?>" class="btn btn-primary">Back</a>



<!DOCTYPE html>
<html>
<head>
  <title>Calculator</title>
  <meta charset="UTF-8">
		<title>PlantSnap</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap\js\bootstrap.min.js"></script>
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="login.css"/>
		<link rel="stylesheet" type="text/css" href="indexFooter.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="style.css">
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
</head>

<!DOCTYPE html>
<html>
<head>
  <title>Soil Fertilizer Calculator</title>
</head>
<body>

<div class="container">

<form action="calculator.php" method="post" onsubmit="return validateForm()">

  <h1>Soil Fertilizer Calculator</h1>

  <div class="form-group">
    <label for="crop-name">Crop Name</label>
    <input type="text" name="crop-name" placeholder="Crop Name">
  </div>
  <div class="form-group">
    <label for="soil-type">Soil Type</label>
    <input type="text" name="soil-type" placeholder="Soil Type">
  </div>
  <div class="form-group">
    <label for="plant-age">Plant Age</label>
    <input type="number" name="plant-age" placeholder="Plant Age">
  </div>
  <button type="submit" class="btn btn-primary">Calculate</button>
</form>
</div>

</body>
</html>

<script>
function validateForm() {
  // Check the crop name field.
  if (empty($_POST['crop-name'])) {
    alert('Please enter a crop name.');
    return false;
  }

  // Define the param_crop_name variable.
  $param_crop_name = 's';

  // Check if the crop name is valid.
  if (!preg_match('/^[a-z]+$/', $_POST['crop-name'])) {
    alert('The crop name must only contain lowercase letters.');
    return false;
  }

  return true;
}

function getNutrientRequirements($crop_name) {
  // Connect to the database.
  $conn = new PDO("mysql:host=localhost;dbname=AgroCulture", "root", "");

  // Define the stmt variable.
  $stmt = $conn->prepare("SELECT nitrogen, phosphorus, potassium FROM crops WHERE crop_name = ?");

  // Bind the crop_name parameter to the ? placeholder in the SELECT statement.
  $stmt->bindParam($param_crop_name, $crop_name);

  // Execute the SELECT statement.
  $stmt->execute();

  // Check if the result is empty.
  if ($result === false) {
    echo "The crop name you entered does not exist.";
    return;
  }

  return $result;
}

</script>

  <script src="script.js"></script>



		<Footer >
			<--<footer id="footer">
				<div class="container">
					<div class="row">
						<section class="4u 6u(medium) 12u$(small)">
							<h3>Welcome to  Platsnap</h3>

							<ul class="alt">
								<li><a href="#">Lorem ipsum dolor sit amet.</a></li>
								<li><a href="#">Quod adipisci perferendis et itaque.</a></li>
								<li><a href="#">Itaque eveniet ullam, veritatis reiciendis?</a></li>
								<li><a href="#">Accusantium repellat accusamus a, soluta.</a></li>
							</ul>
						</section>
						<section class="4u 6u$(medium) 12u$(small)">
							<h3>Nostrum, repellat!</h3>
							<p>Tenetur voluptate exercitationem eius tempora! Obcaecati suscipit, soluta earum blanditiis.</p>
							<ul class="alt">
								<li><a href="#">Lorem ipsum dolor sit amet.</a></li>
								<li><a href="#">Id inventore, qui necessitatibus sunt.</a></li>
								<li><a href="#">Deleniti eum odit nostrum eveniet.</a></li>
								<li><a href="#">Illum consectetur quibusdam eos corporis.</a></li>
							</ul>
						</section>
						<section class="4u$ 12u$(medium) 12u$(small)">
							<h3>Contact Us</h3>
							<ul class="icons">
								<li><a href="#" class="icon rounded fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon rounded fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon rounded fa-pinterest"><span class="label">Pinterest</span></a></li>
								<li><a href="#" class="icon rounded fa-google-plus"><span class="label">Google+</span></a></li>
								<li><a href="#" class="icon rounded fa-linkedin"><span class="label">LinkedIn</span></a></li>
							</ul>
							<ul class="tabular">
								<li>
									<h3>Address</h3>
									Purnanagar Chikhali<br>
									Pune 19
								</li>
								<li>
									<h3>Mail</h3>
									<a href="#">someone@untitled.tld</a>
								</li>
								<li>
									<h3>Phone</h3>
									(000) 000-0000
								</li>
							</ul>
						</section>
					</div>
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li>
						<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
						<li>Images: <a href="http://unsplash.com">Unsplash</a></li>
					</ul>
				</div>
			</footer>



</body>
</html>