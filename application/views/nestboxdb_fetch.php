<?php
header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Fetch</title>

	<style type="text/css">
	</style>
</head>
<body>

<?php
echo "<h1>$count tweets fetched</h1>";

echo "<p>URL: " . $url . "</p>\n";

echo htmlentities($rawData);

?>
</body>
</html>