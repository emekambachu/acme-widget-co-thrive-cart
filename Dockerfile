FROM php:8.1-cli

# Install system dependencies (unzip and git are needed for Composer and installations).
RUN apt-get update && apt-get install -y unzip git

# Install Composer by copying from the official Composer image.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container.
WORKDIR /var/www/html

# Copy all project files into the container.
COPY . .

# Install PHP dependencies defined in composer.json.
RUN composer install

# Expose port 8080 for the PHP built-in server.
EXPOSE 8080

# Command to run the PHP built-in server.
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
