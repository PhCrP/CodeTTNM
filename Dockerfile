FROM php:8.2-fpm

# Cài đặt các extension cần thiết cho PHP
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install mysqli pdo_mysql curl opcache \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean

RUN docker-php-ext-install exif

# Cấu hình Opcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Cấp quyền truy cập cho thư mục ứng dụng
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Thư mục làm việc
WORKDIR /var/www/html