FROM phpmyadmin:phpmyadmin

RUN apt-get update && apt-get install -y

RUN mkdir /nvidly && && mkdir /app/nvidly/www

COPY ./index.php /app/nvidly/www

RUN cp -r /app/nvidly/www/* /var/www/html/.