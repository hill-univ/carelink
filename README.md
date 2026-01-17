# CareLink

CareLink adalah aplikasi berbasis web untuk konsultasi kesehatan yang memudahkan pasien untuk:

-   Mencari dan berkonsultasi dengan dokter
-   Menemukan klinik/rumah sakit terdekat
-   Membeli obat over-the-counter (OTC)

## Installation

```bash
# Clone repository
git clone https://github.com/username/carelink.git
cd carelink

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Konfigurasi database di .env
# DB_DATABASE=carelink
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations & seeders
php artisan migrate --seed

# Link storage
php artisan storage:link

# Start server
php artisan serve
```
