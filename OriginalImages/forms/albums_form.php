
<?php
include '../configuration/configuration.php';
include '../classes/album.php';


if(isset($_GET['portfolio'])){
	echo "<H3>Portfolio Albums [<a class='footer' href='javascript:void(0)' onclick='OI.showNewAlbPop()'>CREATE NEW</a>]</H3>
	<p>You can edit the portfolio photos visible publicly here. Click on any Album you want to edit.</p>
		";
	Album::listALLAlbumsWithLinksAndThumbnailsPortfolio();
	die();
}


if(!isset($_GET["album_id"])){
	echo "<H3>Albums </H3>
<p>Choose any album by clicking on it to edit.</p>
	";
	Album::listALLAlbumsWithLinksAndThumbnails2();
	die();
}


echo "</div>";
?>