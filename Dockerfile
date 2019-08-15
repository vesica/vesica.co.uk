FROM quay.io/vesica/php72:dev

# Copy files
RUN cd ../ && rm -rf /var/www/html
COPY . /var/www/

# Run Composer
RUN cd /var/www && composer install --no-dev
