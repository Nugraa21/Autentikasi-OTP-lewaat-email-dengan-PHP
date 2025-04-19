# Gunakan image PHP dengan Apache
FROM php:7.4-apache

# Salin semua file dari direktori kerja ke dalam container
COPY . /var/www/html/

# Instal ekstensi PHP jika diperlukan (misalnya mysqli)
RUN docker-php-ext-install mysqli

# Expose port 80 untuk web server
EXPOSE 80
