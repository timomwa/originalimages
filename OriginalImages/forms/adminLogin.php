<html>
<head>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/originalImages.js"></script>
<link rel="icon" type="image/x-icon" href="../favicon.ico" />

<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<style>
body {
	margin: 0; padding : 0; background-color : #f8f7f7; font-family :
	"Century Gothic", Arial, Helvetica, sans-serif; font-size : 12px;
	letter-spacing : normal; line-height : 1.8em; text-align : justify;
	list-style-position: outside;
	padding: 0;
	background-color: #f8f7f7;
	font-family: "Century Gothic", Arial, Helvetica, sans-serif;
	font-size: 12px;
	letter-spacing: normal;
	line-height: 1.8em;
	text-align: justify;
}

.content {
	width: 600px;
	background-color: #FFF;
	padding: 10px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-box-shadow: 0 1px 2px #444;
	-webkit-box-shadow: 0 1px 2px #444;
}

.center {
	margin-top: 15%;
	position: relative;
}
</style>
</head>
<body>
	<div align="center">

		<div class="content center">
			<br>
			<table border="0">
				<tbody>
					<tr>
						<td>Username</td>
						<td><input style='width: 130px;' id="username" type="text"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input style='width: 130px;' id="password" type="password"></td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<button  onclick="OI.adminLogin()">Login</button>
						</td>
					</tr>
				</tbody>
			</table>
			<?php echo $message; ?>
			<div id="error" class="error"></div> 	
			
			

		</div>
	</div>
</body>
</html>