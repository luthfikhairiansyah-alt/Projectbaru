# Pakai official PHP-FPM image (versi 8.1 yang stabil)
FROM php:8.1-fpm

# Set working directory di dalam container
WORKDIR /var/www/html

# Install dependencies yang dibutuhkan sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install extension PHP yang dibutuhkan
# pdo_mysql: buat koneksi ke MySQL
# mbstring: buat handle string multibyte
# gd: buat manipulasi gambar
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# TIDAK COPY file di sini - kita pakai volume mounting
# Jadi kalau mahasiswa edit code, langsung keliatan perubahannya
# tanpa perlu rebuild image

# Set permission untuk direktori (akan di-override sama volume)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Health check buat mastiin PHP-FPM jalan dengan baik
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm -t || exit 1

# Jalanin PHP-FPM di foreground
CMD ["php-fpm"]