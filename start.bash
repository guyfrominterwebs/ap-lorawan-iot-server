#!/bin/bash
hub_path=/vagrant/
php ${hub_path}main.php rt &
php ${hub_path}main.php mqtt &
php ${hub_path}main.php cac &