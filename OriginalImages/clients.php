<?php include 'includes/header.php';?>


<div id="container">


	<div id="clr">
		<!--used to create space between elements-->
	</div>
	<div id="services">
		<div id="left">
			<img src="images/clients.jpg" alt="clients image" />
		</div>

		<div id="right">
			<h3>Client Login</h3>
			<div id="cl">



			<?php

			session_start();
			if(isset($_SESSION['userId']) && $_SESSION['userId']!=3){
				include_once 'classes/security.php';
				Security::showUserDash();
			}else{

				echo '<table>
                <p>Please Login to View Your Albums</p>
					<tr>
						<td>Username</td>
						<td><input style="width: 130px;" id="username" type="text" />
						
						</td>
					</tr>
					</tr>
					<td>Password</td>
					<td><input  style="width: 130px;" id="password" type="password" />
					</td>
					</tr>
					<tr>
						<td colspan="2" align="right" width><button name="Login"
								id="login" onclick="OI.login()">Login</button>
						</td>
					</tr>

				</table>

				<span id="error" class="error"></span>';

			}

			?>



			</div>
		</div>
		
		
		
		


	

</div>


<?php include 'includes/navigator.php'?>


<?php include 'includes/footer.php';?>

