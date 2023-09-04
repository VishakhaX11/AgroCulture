<!DOCTYPE html>
<html>
<head>
    <title>PlantSnap Search</title>
    <link rel="stylesheet" href="style.css">
    <!-- Other meta tags and CSS links -->
</head>
<body>
    <h1>PlantSnap Search</h1>
    <form action="search.php" method="post">
        <input type="text" name="searchTerm" placeholder="Enter a plant name">
        <input type="submit" value="Search">
    </form>

    <?php
    session_start();
    // Rest of your session handling code

    if (isset($_POST['searchTerm'])) {
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=AgroCulture', 'root', '');

        // Get the search term from the user
        $searchTerm = $_POST['searchTerm'];
        $like_pattern = "%" . $searchTerm . "%";

        // Search the database for plants that match the search term
        $query = "SELECT * FROM plants WHERE name LIKE :searchTerm";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':searchTerm', $like_pattern);
        $stmt->execute();

        // If there are any results, display them to the user
        if ($stmt->rowCount() > 0) {
            echo "<ul>";
            foreach ($stmt as $row) {
                echo "<li><a href='plant.php?id=$row[id]'><img src='images/$row[image]' alt='$row[name]'><br>$row[name]</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No plants found.</p>";
        }
    }
	// Replace these with your actual database connection credentials
	$host = 'localhost';
	$dbname = 'AgroCulture';
	$username = 'root';
	$password = '';
	
	try {
		$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	
		$plantName = "Rose";
		$description = "A beautiful flower.";
		$image = "rose.jpg";
	
		$query = "INSERT INTO plants (name, description, image) VALUES (:name, :description, :image)";
		$stmt = $db->prepare($query);
	
		$stmt->bindParam(':name', $plantName);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':image', $image);
	
		$stmt->execute();
	
		echo "Data inserted successfully!";
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	

    ?>
</body>
</html>
