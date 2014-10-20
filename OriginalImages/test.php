<?php
$link = "http://www.".$_SERVER['HTTP_HOST']."/clients.php";
htmlentities($link);

$clientLink = "<p>Please Click <a href='".$link."'>Here</a> to see your album. If you can't see your album, copy and paste this url to your browser;";
echo "<html><head></head><body></body>";		
echo htmlentities($clientLink);
echo "</body></html>"
?>