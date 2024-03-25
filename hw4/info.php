<?php phpinfo();

// Put me in /var/www/html

/*******************************************************************************
  __           ___
 (__|_ _ ._  _  | _.|  _ ._
 __)|_(/_|_)_>  |(_||<(/_| |
         |

Install Apache

	sudo apt install apache2

Test Apache

	Type localhost into a web browser and confirm that you land on the
	Apache2 default page.

Install PHP module for Apache

	This is a software module that will allow Apache to interact with PHP.

		sudo apt install libapache2-mod-php

	It must bundle PHP with it?

Restart Apache

	sudo systemctl restart apache2

Test PHP

	On the command line, you can test that php is installed, preferably by
	checking the version, by issuing the command 'php -v'.

	Create a php file and generate a php report.

	sudo vim /var/www/html/info.php

		1 <?php
		2 phpinfo();
		~
		~

	Point your web browser to localhost/info.php to review the report.

Install MySql Server

	sudo apt install mysql-server

Install MySql Client

	sudo apt install mysql-client

	sudo apt install php8.1-mysql

	sudo apt install php8.1-curl

Check MySql Server

	sudo systemtl status mysql

	It should say 'active (running)' in green.

Install PhpMyAdmin

	I'm not sure that this part is necessary for our assignment, but this
	was part of the tutorial that I followed.

		sudo apt install phpmyadmin

	You will be prompted with a box titled "configuring phpmyadmin." Ensure
	that the apache2 check mark box is selected and hit enter.

	The box will appear again with a yes-or-no prompt. Hit yes to confirm.

	Finally, the box will appear one last time, asking you to create a MySQL
	application password for phpmyadmin. Do so and press enter to confirm
	your password.

	You will need to restart apache.

		sudo systemctl restart apache2

	You will also need to append a line to the bottom of the apache config
	file.

		sudo vim /etc/apache2/apache2.conf

			Include /etc/phpmyadmin/apache.conf

	Whenever edits are made, we must retart the service.

		sudo systemctl retart apache2
		sudo /etc/init.d/mysqrt restart

Test PhpMyAdmin

	Point your broswer to localhost/phpmyadmin.

	You will be welcomed to a login page. The phpMyAdmin logo is a boat.

	You can review the username and password like this.

		sudo less /etc/phpmyadmin/config-db.php

	The use name is 'phpmyadmin' with the password you chose during
	installation.

*/
