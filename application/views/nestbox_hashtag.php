<?php
header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Nestbox: <?php echo $hashtag; ?></title>
	<link href="/0/nestbox.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php

echo "<h1>Archive of <a href=\"https://twitter.com/#!/search/%23" . $hashtag . "\">#$hashtag</a> tweets</h1>";

echo "<p id=\"info\">Updated every 10 minutes (if Twitter API is working). <a href=\"https://twitter.com/#!/search/%23" . $hashtag . "\">Most recent tweets on Twitter</a>. See also <a href=\"http://twapperkeeper.com/hashtag/tdwg\">#tdwg @ Twapperkeeper</a> &#8226; <a href=\"" . site_url("nestbox/authors") . "/" . $hashtag . "\">Top tweeters</a></p>";

// echo "<pre>"; print_r ($data); // DEBUG 

$mem = "";

echo "<table>\n";
echo "<tr>
<th>Date (GMT)</th>
<th>From</th>
<th>Tweet</th>
</tr>\n";
foreach ($data as $tweetGuid => $tweetArray)
{
	if (strpos($tweetArray['title'], "RT @") === 0)
	{
		$class = " class=\"RT\"";
	}
	else
	{
		$class = "";
	}
	
	// Converts addresses to hyperlinks
	$linkedTitle = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $tweetArray['title']);

	$linkedTitle = preg_replace("/@([A-Za-z0-9_]+)(\s|\Z|\.|\:)/", "<a class='p' href='https://twitter.com/#!/$1'>$0</a>", $linkedTitle);

	$len = strlen($tweetArray['pubdate']) - 14;
	$simpledDate = substr($tweetArray['pubdate'], 5, $len);

	$onlyDate = substr($simpledDate, 0, 11);
	

	echo "	<tr" . $class . ">\n";
	echo "		<td class=\"pubdate\"><a href=\"" . $tweetArray['link'] . "\">" . $simpledDate . "</a></td>\n";
	echo "		<td><a href=\"https://twitter.com/#!/" . $tweetArray['author'] . "\">" . $tweetArray['author'] . "</a></td>\n";
	echo "		<td>" . $linkedTitle . "</td>\n";
	echo "	</tr>\n";
}
echo "</table>\n\n";

/*
			$doc['hashtag'] = $hashtag;
			
			$doc['title'] = $item['text'];
			$doc['pubdate'] = $item['created_at'];
			$doc['timestamp'] = strtotime($doc['pubdate']);
			
			$doc['id_str'] = $item['id_str'];
			$doc['author'] = $item['from_user'];
			
			$doc['profile_image_url'] = $item['profile_image_url'];
			$doc['to_user'] = @$item['to_user'];
			$doc['iso_language_code'] = $item['iso_language_code'];
			$doc['source'] = $item['source'];
			
			$doc['entities'] = @$item['entities'];
			
			$doc['link'] = "https://twitter.com/#!/" . $item['from_user'] . "/status/" . $item['id_str'];
	*/

?>

</body>
</html>