<?php
include_once 'configuration/configuration.php';
include_once 'classes/security.php';
include_once 'classes/cms.php';

if(!Security::isAdmin())
	header('Location: admin.php?message=Please+login+as+admin+first.') ;


require_once 'classes/album.php';

//include_once 'includes/header.php';

$album = new Album();

if(!isset($_GET['album_id'])){
	
	$albums = $album->getAllAlbums();
	
	$sizeOfAlb = count($albums['albums']['id']);
	
	//echo "<ul>";
	
	for ($i = 0; $i < $sizeOfAlb; ++$i){
	
		$alb_id = $albums['albums']['id'][$i];
	
		$alb_name = $albums['albums']['name'][$i];
	
		echo "<div><a style='cursor: pointer' class='oiformDiv2' href='".$_SERVER["PHP_SELF"]."?album_id=".$alb_id."'>".$alb_name."</a></div>";
	}
	
	//echo "</ul>";

}else{
	
	include_once 'admin/albumEditScripts.php';
	
	$alb_Id = $_GET['album_id'];
	
	if(isset($_SESSION['ALBUM_ID'])){
		unset($_SESSION['ALBUM_ID']);
	}
	
	$_SESSION['ALBUM_ID'] = $alb_Id;
	
	
	$allPhotos = $album->getAllPhotos($alb_Id);
	
	$album->setAlbumId($alb_Id);
	
	$photos = json_decode($allPhotos,true);
	
	$sizeofP = count($photos['photos']['photo_id']);
	
	$albumName = $album->getName();
	
	if(isset($_SESSION['ALBUM_NAME'])){
		unset($_SESSION['ALBUM_NAME']);
	}
	
	$_SESSION['ALBUM_NAME'] = $albumName;
	
	$albums = $album->getAlbumNamesUsingId(3);
	
	$sizeOfAlb = count($albums['albums']['id']);
	
	$allAlbs = '" class="">';
	
	$allAlbs .= "<option value='-1'> </option>";
	
	$alb_name = '';
	
	for ($i = 0; $i < $sizeOfAlb; ++$i){
	
		$alb_idbm = $albums['albums']['id'][$i];
	
		$alb_name = $albums['albums']['name'][$i];
	
		if($alb_Id!=$alb_idbm)
			$allAlbs .= "<option value='".$alb_idbm."'>".$alb_name."</option>";
	}
	
	$allAlbs .= '</select>';
	
	$current_uri = $_SERVER['REQUEST_URI'];
		
	$cs = explode("/", $current_uri);
		
	$curPage = $cs[2];
	
	$deletedAlbmsg = $album->isDeleted() ? "<span class='topleft oifivePixPadding lefters'>Status: <img src='images/deleted.png' alt='deleted'/> (Deleted)</span><div class='clearers'></div>" : "";
	
	$owner = "";
	
	//if(!isset($_SESSION['userId']) && $_SESSION['userId']==3)
		$owner = " (Owner: ".$album->getOwner($alb_Id).")";
	
	echo '<div id="mainTabber" >';
	echo '<H2>Album:: <span id="alb_h_id_'.$alb_Id.'">'.$albumName.$owner.'</span></H2>'.$deletedAlbmsg.'';
	
	if(!isset($_GET['noPanel']))
		Security::showAdminDash();
	
	$delete_or_undelete = $album->isDeleted() ? "Undelete" : "Delete";
	//The tabs
	echo '<ul class="tabs">';
	echo 	'<li><a href="#">Photos</a></li>';
	echo 	'<li><a href="#">Add Photos</a></li>';
	echo 	'<li><a href="#">Edit Name</a></li>';
	echo 	'<li><a href="#">'.$delete_or_undelete.'</a></li>';
	echo '</ul>';
	
	echo '<div class="panes">';
	
	//first tab content
	echo '<div class="oidivo">';
	
	
	
	echo '<div id="photoEditDiv" class="mainPhotoDiv oioverdiv">';
	$c = 0;
	
	for ($i = 0; $i < $sizeofP; ++$i){
		
		
		
		$c++;
		
		$photo_id = $photos['photos']['photo_id'][$i];
		
		$imgUrl = $photos['photos']['imageUrl'][$i];
		
		$dateUploaded = $photos['photos']['dateUploaded'][$i];
		
		$caption = $photos['photos']['caption'][$i];
		
		$allAlbsw_ = '<select id="move_alb_'.$photo_id;
		
		
		echo '<div id="imgDiv_'.$photo_id.'" class="oiimageDiv">';
		
		echo "<span class='topleft oifivePixPadding lefters'>Caption: 
		
		</span><textarea id='caption_".$photo_id."' class='albumEdit topleft' cols='10' rows='2'>".$caption."</textarea>";	
		
		echo "<div id='img_".$photo_id."' class='oiimgdiv righters oithumb' >";
		
		echo "<img width='150px' src='".$imgUrl."'/>";
		
		echo 	'<div class="oicovercheck"> ';
		
		echo 		'<input type="checkbox" value="1" id="delete_'.$photo_id.' name="delete_'.$photo_id.'"/> 
					<label id="label_delete_7489781" for="delete_7489781">Delete this photo.</label> 
					<div style="padding:4px;">Move to&nbsp;'.$allAlbsw_.$allAlbs.'</div>';
		echo 	'</div>';
		
		echo '</div>';
		
		echo '<div class="clearers">&nbsp;</div></div>';
		
		if($i+1==$sizeofP)
			echo '<center><span id="error" class="error" ></span><button id="saveChanges" onclick="OI.commitPhotoEdit(this,'.$alb_Id.')">Save Changes</button></center>';
		
	}
	
	if($c==0)
		echo "<span class='oicovercheck2'>No photos Found in this album.</span>";
	
	
	echo '</div>';
	
	echo '</div>';
	
	echo '<div class="oidivo">';
	
	
	echo 		'<div id="renameTable" class="mainPhotoDiv oioverdiv">';
	
	if(!$album->isDeleted()){
		
		
		echo '<div class="oicovercheck2">Add images to <b>'.$albumName.'</b></div>';
		
					include_once 'forms/upload.php';
		echo 		'<div id="upload_area"></div>';
		
		
	}else{
		echo "<span class='topleft oifivePixPadding lefters'><b>".$albumName."</b> is marked as deleted, please undelete it before uploading new photos.</span>";
		echo "<div class='clearers'>&nbsp;</div>";
	}
	
	echo '</div>';
	
	
	
	
	
	echo '</div>';
	
	
	
	
	echo '<div class="oidivo">';
	
	echo 		'<div id="renameTable" class="mainPhotoDiv oioverdiv">';

	
	
	if(!$album->isDeleted()){
		
		echo			'<span class="topleft oifivePixPadding lefters">
						Rename Album from <b id="alb_span_id_'.$alb_Id.'">'.$albumName.'</b>
						to</span>
						<input class="albumEdit2 lefters" id="inpt'.$alb_Id.'" toplef" value="'.$albumName.'"/>
						<button class="albumEdit2 lefters" onclick="OI.renameAlbum(\''.$alb_Id.'\')"> Rename </butoton>
						&nbsp;&nbsp;&nbsp;<button class="albumEdit2 lefters" onclick="OI.reloadCurPage()"> Cancel </button>
						<span id="error" class="niceFont lefters"></span>';
		echo			'<div class="clearers"></div>';
		
		
	}else{
		
		echo "<span class='topleft oifivePixPadding lefters'><b>".$albumName."</b> is marked as deleted, please undelete it before renaming it.</span>";
		echo "<div class='clearers'>&nbsp;</div>";
	
	}
	
	
	
	echo 		'</div>';
	
	echo '</div>';
	
	
	
	echo '<div class="oidivo">';
	
	echo 		'<div id="renameTable" class="mainPhotoDiv oioverdiv">';
	
	if(!$album->isDeleted()){
		
		echo			'<span class="topleft oifivePixPadding lefters">
							Delete this Album <b id="alb_span_name_'.$alb_Id.'">'.$albumName.'</b>
							? </span>
							<button class="albumEdit2 lefters" onclick="OI.deleteAlbum(\''.$alb_Id.'\')"> Yes </butoton>
							&nbsp;&nbsp;&nbsp;<button class="albumEdit2 lefters" onclick="OI.reloadCurPage()"> No </button>
							<span id="error0" class="niceFont lefters"></span>';
		echo			'<div class="clearers"></div>';
	
	}else{

		echo			'<span class="topleft oifivePixPadding lefters">
							Undelete <b id="alb_span_name_d_'.$alb_Id.'">'.$albumName.'</b>
							? </span>
							<button class="albumEdit2 lefters" onclick="OI.undeleteAlbum(\''.$alb_Id.'\')"> Yes </butoton>
							&nbsp;&nbsp;&nbsp;<button class="albumEdit2 lefters" onclick="OI.reloadCurPage()"> No </button>
							<span id="error1" class="niceFont lefters"></span>';
		echo			'<div class="clearers"></div>';
	}
	echo		'</div>';
	
	
	echo '</div>';
	
	echo '</div>';
	echo '</div>';
	
	echo '<script type="text/javascript">
		$(function() {
			// setup ul.tabs to work as tabs for each div directly under div.panes
			$("ul.tabs").tabs("div.panes > div" );
		});
	</script>';
	
}	

//include 'includes/footer.php';
?>