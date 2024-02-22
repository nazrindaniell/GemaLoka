FROM php:apache-bookworm

#copy all directories to the docker directory
COPY php /var/www/html/php
COPY css /var/www/html/css
COPY includes /var/www/html/includes
COPY videos /var/www/html/videos
COPY pictures /var/www/html/pictures
COPY event_images /var/www/html/event_images
COPY events /var/www/html/events

#expose port 80 to allow outside access
EXPOSE 80

