# Usa uma imagem base oficial do PHP com Apache
FROM php:8.3-apache

# Instala extensões PHP necessárias para SQLite
RUN apt-get update \
    && apt-get install -y \
        libsqlite3-dev \
        libzip-dev \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Instala as extensões PHP (PDO, sqlite3, pdo_sqlite e opcache)
# O PDO básico é geralmente uma parte fundamental e é instalado
# automaticamente ao instalar pdo_sqlite. No entanto, vamos ser explícitos.
RUN docker-php-ext-install pdo pdo_sqlite opcache

# Habilita o módulo de reescrita do Apache (necessário para o .htaccess)
RUN a2enmod rewrite

# Copia o arquivo .htaccess da pasta pai (SH/) para a pasta web do Apache
COPY ../.htaccess /var/www/html/

# Copia todo o código da sua aplicação para o diretório de trabalho do Apache
COPY .. /var/www/html/

# Define o diretório de trabalho padrão
WORKDIR /var/www/html