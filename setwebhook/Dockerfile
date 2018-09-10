FROM nimmis/apache-php5
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
ADD index.php /var/www/public/
ADD handler.php /var/www/public/
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
