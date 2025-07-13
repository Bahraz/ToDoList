FROM php:8.2-apache

# Włącz mod_rewrite
RUN a2enmod rewrite

# Ustaw DocumentRoot i konfigurację katalogu public
RUN sed -i 's|/var/www/html|/var/www/html|g' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory "/var/www/html">' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

# Skopiuj plik index.php jeśli potrzebujesz testu działania (opcjonalne)
# COPY ./public /var/www/html

WORKDIR /var/www/html
