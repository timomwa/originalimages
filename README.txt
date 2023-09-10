@Author Timothy Mwangi
Date Created 13th June 2011
===========================
Project: Original Images
===========================


REQUIREMENTS
============
You MUST have the following servers installed;

WAMP Server (Tested on WAMP 2.1 (php 5.3.4))
Mysql Server(Tested on version 5.1.53)

Browsers compatible: Mozilla, Google Chrome, IE 6+, Netscape, Opera.



INSTALLATION
============

i)	Site folder
	The site folder is called "OriginalImages".
  	The content of this file should be emptied into the server.

ii)	Configuration
		a. Create a database – for disambiguation, I suggest you call the database "original_images".
		b. After your database is set, edit the configuration file. This file is located in the folder called "configuration". The lines of interest are 22, 24,26,28 and 30 which hold the values for database's name, database's user password, database's username and the database's host respectively.
	
	File: configuration/configuration.php
	
	LINE	VARIABLE_NAME		Description
	26		$DATABASE_NAME		The database name - the one created in step i) a
	24		$DATABASE_PASSWORD	The database's password 
	26		$DATABASE_USERNAME	The database's username
	28		$DATABASE_HOST 		The database's host (it can be 'localhost' if the web server and database server are running on the same server.

		c. Run the web set up: After you have edited the configuration file, open any PC browser and enter the url: '/configuration/'
		   If you set everything correctly and your database works, you should see the following message on your browser 

		   "Database initialization successfull!".

		   If you see this message, open a coke and relax because most of the configuration has been done for you, and the website is ready for use ?.

		   If you try to run the configuration once again, the database tables will not be re-created, rather you will see this message;

		   "The database is set and ready for use!"

		   In case you do not see the message "Database initialization successfull!", then there must be something that you did not set right, check also if you have administrative rights, check spelling mistakes that might be there in the configuration/configuration.php



TESTING/TROUBLESHOOTING
=======================
When you see a blank page after deployment, check the following;

	i) Enable the `mysql`, `mysqli` and `pdo_mysql`  extensions. `pdo_mysql` is deprecated in higher php versions e.g version 7

		


