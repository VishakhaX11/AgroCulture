<?php
	if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == 1)
	{
		$loginProfile = "My Profile: ". $_SESSION['Username'];
		$logo = "glyphicon glyphicon-user";
		if($_SESSION['Category']!= 1)
		{
			$link = "profile.php";
		}
		else {
				$link = "../profileView.php";
		}
	}
	else
	{
		$loginProfile = "Login";
		$link = "../index.php";
		$logo = "glyphicon glyphicon-log-in";
	}
?>

<!DOCTYPE html>
			<header id="header">
				<h4><a href="index.php">PlantSnap</a></h4>
				<nav id="nav">
					<ul>
						<li><a href="../index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						<li><a href="../search.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
						<li><a href="../myCart.php"><span class="glyphicon glyphicon-shopping-cart"> MyCart</a></li>
						<li><a href="../chat.php"><span class="glyphicon glyphicon-shopping-chat"> Chat</a></li>
						<li><a href="<?= $link; ?>"><span class="<?php echo $logo; ?>"></span><?php echo" ". $loginProfile; ?></a></li>
						<li><a href="../market.php"><span class="glyphicon glyphicon-grain"> Digital-Market</a></li>
						<li><a href="../calculator.php"><span class="glyphicon glyphicon-shopping-cart"> Calculator</a></li>
						<li><a href="../blogView.php"><span class="glyphicon glyphicon-comment"> BLOG</a></li>
					</ul>
				</nav>
			</header>

	</body>
</html>
