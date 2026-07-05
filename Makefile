.PHONY: help install setup migrate seed build optimize clean test serve

help:
	@echo "SiSampah - Platform Bank Sampah Skala Lokal"
	@echo ""
	@echo "Available commands:"
	@echo "  make install     - Install dependencies"
	@echo "  make setup       - Setup environment (install + migrate + seed)"
	@echo "  make migrate     - Run database migrations"
	@echo "  make seed        - Seed database with dummy data"
	@echo "  make build       - Build frontend assets"
	@echo "  make optimize    - Optimize application for production"
	@echo "  make clean       - Clean cache and compiled files"
	@echo "  make test        - Run tests"
	@echo "  make serve       - Start development server"

install:
	@echo "Installing Composer dependencies..."
	composer install --no-interaction --prefer-dist
	@echo "Installing NPM dependencies..."
	npm install

setup: install migrate seed build optimize
	@echo "Setup complete! Application is ready to use."
	@echo "Admin credentials: admin@sisampah.local / password"
	@echo "Petugas credentials: petugas1@sisampah.local / password"
	@echo "Nasabah credentials: nasabah1@sisampah.local / password"

migrate:
	@echo "Running migrations..."
	php artisan migrate:fresh

seed:
	@echo "Seeding database..."
	php artisan db:seed

build:
	@echo "Building frontend assets..."
	npm run build

optimize:
	@echo "Optimizing application..."
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache
	php artisan optimize

clean:
	@echo "Cleaning cache..."
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	rm -rf bootstrap/cache/*

test:
	@echo "Running tests..."
	php artisan test

serve:
	@echo "Starting development server..."
	php artisan serve --host=0.0.0.0 --port=8000
