sudo service apache2 stop
sudo rsync -av --progress * /var/www/nextcloud --exclude-from 'exclude-list.txt'
sudo chown -R www-data:www-data /var/www/nextcloud/
sudo service apache2 start

