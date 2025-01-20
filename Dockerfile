# Используем официальный PHP-образ с Composer
FROM php:8.2-fpm

# Устанавливаем Composer
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем зависимости PHP (например, pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Указываем рабочую директорию
WORKDIR /var/www

# Копируем проект внутрь контейнера
COPY . .

# Запускаем установку зависимостей
RUN composer install

# Разрешаем запись в storage и bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache
