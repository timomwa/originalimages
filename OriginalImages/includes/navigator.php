<div id="control">
		<div id="navigation">
			<ul>
				<li><a href="home.php" <?php if(CURPAGE=='home.php') echo 'class="active"' ?>>Home</a></li>
				<li><a href="about.php" <?php if(CURPAGE=='about.php') echo 'class="active"' ?> >About us</a></li>
				<li><a href="clients.php" <?php if(CURPAGE=='clients.php') echo 'class="active"' ?>>Clients</a></li>
				<li><a href="blog" target="blank">blog</a></li>
				<li><a href="#" <?php if(CURPAGE=='sessions.php' || CURPAGE=='price.php') echo 'class="active"' ?>>Services</a>
					<ul>
						<li><a href="sessions.php">Sessions</a></li>
						<li><a href="price.php">Clients</a></li>


					</ul>
				</li>

				<li><a href="#">Portfolio</a>
					<ul>
						<?php

					require_once 'configuration/configuration.php';
					require_once 'classes/album.php';

					$album = new Album();

					$albums = $album->getAlbumNamesUsingId(3);

					$sizeOfAlb = count($albums['albums']['id']);

					for ($i = 0; $i < $sizeOfAlb; ++$i){

						$alb_id = $albums['albums']['id'][$i];

						$alb_name = $albums['albums']['name'][$i];

						echo "<li><a href='albums.php?album_id=".$alb_id."'>".$alb_name."</a></li>";
					}

					?>

					</ul>
				</li>
				<li><a href="contact.php" <?php if(CURPAGE=='contact.php') echo 'class="active"' ?>>Contact</a></li>

			</ul>
		</div>
		<div id="logo">
			<a href="index.php"><img src="images/logo.png" alt="Originnal logo" />
			</a>
		</div>
	</div>
