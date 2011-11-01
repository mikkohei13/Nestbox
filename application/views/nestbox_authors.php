<?php
header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Authors by activity: <?php echo $hashtag; ?></title>
	<link href="/0/nestbox.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php

$count = 0;
$totalTweets = 0;
$table = "";

echo "<h1>Top tweeters on <a href=\"https://twitter.com/#!/search/%23" . $hashtag . "\">#$hashtag</a></h1>";


// echo "<pre>"; print_r ($data); // DEBUG 


$table .= "<table>\n";
$table .= "<tr>
<th>Author</th>
<th colspan=\"2\">Tweets</th>
</tr>\n";
foreach ($data as $author => $tweets)
{

	$table .= "	<tr>\n";
	$table .= "		<td><a href=\"https://twitter.com/#!/" . $author . "\">" . $author . "</a></td>\n";
	$table .= "		<td>" . $tweets . "</td><!--<td><img src=\"/0/transparent.gif\" class=\"bar\" style=\"width: " . $tweets . "px !important;\" />--></td>\n";
	$table .= "	</tr>\n";
	
	$count++;
	$totalTweets += $tweets;
}
$table .= "</table>\n\n";

echo "<p><a href=\"" . site_url("nestbox/hashtag"). "/" . $hashtag . "\">&laquo; Back to tweet archive</a>
&#8226; $totalTweets tweets by $count tweeters
</p>";

echo "<p></p>";

echo $table;

?>

</body>
</html>