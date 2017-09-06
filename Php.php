<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Oxygen|Poppins" rel="stylesheet">
    <title>Projekt namn</title>
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    
<?php
        $text1 = $_POST["text1"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektnamn";
    

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    
    
if(isset($_POST['submit']))
{
	// vi skapar $filtered för att spara efter varje filter
	$filtered = filter_input(INPUT_POST, "text1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$filtered = trim($filtered);

	// databas
	$mysqli = new mysqli("localhost", "root", "", "projektnamn");
	/* check connection */
	if ($mysqli->connect_error) {
	    die('Connect Error (' . $mysqli->connect_errno . ') '
	            . $mysqli->connect_error);
	}

	/* change character set to utf8 */
	if (!$mysqli->set_charset("utf8")) {
	    echo "Error loading character set utf8: " . $mysqli->error;
	    exit();
	}

	// spara i databas med prep statements
	if (!($stmt = $mysqli->prepare("INSERT into projektnamn(name) values (?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s", $filtered)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$filtered = $mysqli->real_escape_string($filtered);
    
    $sql = "SELECT id, name FROM projektnamn";
$result = $conn->query($sql);

if ($result->num_rows > -2) {
    echo "<table class='table table-bordered'><tr><th>Förslag</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>". $row["name"]." </td></tr>";
    }
    echo "</table>";
} else {
    echo "Det finns inga förslag än";
}
}
$conn->close();
?>



</body>
</html>