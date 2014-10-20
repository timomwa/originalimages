<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Original images </title>
<link rel="stylesheet" href="css/style.css" type="text/css"
	media="screen" />
<link rel="stylesheet" href="css/nav.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/dimbox.css" type="text/css"
	media="screen" />

<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="js/jquery.tinyscrollbar.min.js"></script>
<script type="text/javascript" src="js/utils.js"></script>




<?php 
$current_uri = $_SERVER['REQUEST_URI'];
	
$cs = explode("/", $current_uri);
	
$page = $cs[2];

define('CURPAGE', $page);

if(CURPAGE=='home.php' || CURPAGE=='admin.php'){
	echo '<link rel="stylesheet" href="css/orbit.css" />';
	echo '<script type="text/javascript" src="js/jquery.orbit.min.js"></script>';
}

$s = explode("?", CURPAGE);
if($s[0]=='albums.php' || $s[0]=='admin.php'){
	echo '<link rel="stylesheet" href="css/original.css" />';
	echo '<script type="text/javascript" src="js/originalImages.js"></script>';
	echo '<link rel="stylesheet" href="css/right.css" type="text/css" media="screen" />';
	
	echo '<script type="text/javascript" src="js/jquery.pikachoose.js"></script>';
	
	
}

if(CURPAGE=='admin.php' || CURPAGE=='albums.php'){
	
	echo '<link rel="stylesheet" href="css/adminAlb.css" />';
	

}


?>
<script type="text/javascript" src="js/originalImages.js"></script>
<script type="text/javascript" src="js/dimbox.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<?php 
//if(CURPAGE=='home.php'){
echo "<script type=\"text/javascript\">
		$(document).ready(function(){
			$('#scrollbar1').tinyscrollbar();	
		});
	</script>
	";
//}
?>
<link rel="icon" type="image/x-icon" href="favicon.ico" />






<?php 


if(CURPAGE=='home.php'){
	echo "<!--[if IE]>
			<style type=\"text/css\">
				.timer { display: none !important; }
				div.caption { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }
			</style>
		<![endif]-->

<!-- Run the plugin -->
<script type=\"text/javascript\">
			$(window).load(function() {
				$('#featured').orbit({
					'bullets': true,
					'timer' : true,
					'animation' : 'fade'
				});
			});
		</script>";
	
}

?>


</head>
<body>