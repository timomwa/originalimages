<?php
/**
 * Copyright (c) 2011 http://www.pixelandtag.com
 * "Original Images Project"
 * Date: 2011-06-10
 * Ver 1.0
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * http://www.opensource.org/licenses/bsd-license.php
 */

include_once 'configuration/configuration.php';
include_once 'classes/security.php';
include_once 'classes/cms.php';

include('includes/header.php');


echo '<script type="text/javascript">
$(document).ready(function()
		{ 
		       $(document).bind("contextmenu",function(e){
		              return false;
		       }); 
		});

</script>
';
echo '<link rel="stylesheet" href="css/right.css" type="text/css" media="screen"/>
			<link rel="stylesheet" href="css/original.css" type="text/css" media="screen"/>';

require_once 'classes/album.php';



if(!isset($_GET["album_id"])){
	if(!session_id())
	session_start();
		
	if(isset($_SESSION['userId']) && $_SESSION['userId']!=3){
		Security::showUserDash();
	}elseif (isset($_SESSION['userId']) && $_SESSION['userId']==3){
		Security::showAdminDash();
	}
	
	if(isset($_SESSION['userId'])){
	Album::listALLAlbumsWithLinksAndThumbnails4($_SESSION['userId']);
		die();
	}else{
		header("Location: clients.php");
	}
}

$album_id = $_GET["album_id"];

$album = new Album();

$album->setAlbumId($album_id);

$photosJson = $album->getAllPhotos(null);

$photos = json_decode($photosJson,true);

$sizeofP = count($photos['photos']['photo_id']);

$albumName = $album->getName();

if($albumName==NULL){

	$msg = $album->isDeleted() ? "This album has been deleted" : "Album Does not exist or has been deleted!";
	if($album->isDeleted()){
		die ("OOPS.. ".$msg);
	}else{
		echo "OOPS.. ".$msg;
	}
}

if($sizeofP==0){
	if(isset($_SESSION['userId']) && $_SESSION['userId']!=3)
	Security::showUserDash();
	die ("OOPS! The Album <b>".$albumName."</b> Does not have photos. <a  class='oicovercheck2' href='albums.php'>Back</a>");
}
?>

<div style='width: 1024px; margin: auto;'>

	<div class="pikachoose lefters">




	<?php

	$album_id = $_GET['album_id'];

	if(isset($_SESSION['ALBUM_ID'])){
		unset($_SESSION['ALBUM_ID']);
	}

	$_SESSION['ALBUM_ID'] = $album_id;

	//echo "<H3>".$albumName."</H3>";
	
	if(isset($_SESSION['userId']) && $_SESSION['userId']!=3){
		Security::showUserDash();
	}elseif (isset($_SESSION['userId']) && $_SESSION['userId']==3){
		Security::showAdminDash();
	}
	
	if(!(isset($_SESSION['userId']) && $_SESSION['userId']==$album->getOwnerID()) && $album->getOwnerID() !=3)
		die("You don't have the priviledge to view this album");
	//if(Security::isAdmin()){
	//echo "<a onclick=OI.editAlb(".$album_id.") href='albumAdmin.php'>Edit</a>";
	//}
	?>

		<ul id="pikame" class="jcarousel-skin-pika">
			
			
		<?php

		
		for ($i = 0; $i < $sizeofP; ++$i){

			$photo_id = $photos['photos']['photo_id'][$i];
			$imgUrl = $photos['photos']['imageUrl'][$i];
			$dateUploaded = $photos['photos']['dateUploaded'][$i];
			$caption = $photos['photos']['caption'][$i];// == null ? '' : $photos['photos']['caption'][$i];

			echo "<li><a href='#'><img src='".$imgUrl."'/></a><span>".$caption."</span></li>";
		}

		?>
		</ul>
	</div>
	<!--  Other Album Links-->
	<div class='oinavigator lefters'
		style='display: inline; position: relative;'>
		<!--  div style='text-decoration: none !important;' class='oicovercheck2 nodec' ><h3></h3></div-->
		<div>
			
		<?php echo Album::listAlbumsWithLinks($album_id);?></div>
		<br />
		<div class='oicovercheck2'>
			<br/>
		<a style='text-decoration: none !important;' class='oicovercheck2 noDecor' href='home.php'><span
				class='raisedabit'>Home</span> </a>
		</div>
		<!--  img src='images/back_home.png' alt='back' /-->
	</div>
	<div class='clearers'></div>



</div>


<script type="text/javascript" language="javascript">

$(document).ready(function (){
	$("#pikame").PikaChoose({
		carousel:true, carouselVertical:true});
});

</script>
