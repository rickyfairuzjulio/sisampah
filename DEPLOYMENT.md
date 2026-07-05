# SiSampah - Panduan Deployment

Dokumen ini berisi panduan lengkap untuk mendeploy aplikasi SiSampah ke production environment.

## Prerequisites

- Ubuntu 20.04 LTS atau lebih baru
- PHP 8.2 atau lebih baru dengan extensions: curl, mbstring, xml, zip, gd
- MySQL 8.0 atau lebih baru
- Nginx atau Apache
- Node.js 18+
- Composer

## Setup Server

### 1. Install Dependencies

```bash
sudo apt-get update
sudo apt-get install -y php8.3 php8.3-fpm php8.3-mysql php8.3-curl php8.3-mbstring php8.3-xml php8.3-zip php8.3-gd php8.3-cli
sudo apt-get install -y mysql-server
sudo apt-get install -y nginx
sudo apt-get install -y nodejs npm
sudo npm install -g n
sudo n 18
```

### 2. Setup MySQL Database

```bash
sudo mysql -u root -e "CREATE DATABASE sisampah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -u root -e "CREATE USER 'sisampah'@'localhost' IDENTIFIED BY 'secure_password_here';"
sudo mysql -u root -e "GRANT ALL PRIVILEGES ON sisampah.* TO 'sisampah'@'localhost';"
sudo mysql -u root -e "FLUSH PRIVILEGES;"
```

### 3. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/yourusername/sisampah.git
cd sisampah
sudo chown -R www-data:www-data .
```

### 4. Install Application

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 5. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dengan konfigurasi production:

```env
APP_NAME="SiSampah"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sisampah.yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sisampah
DB_USERNAME=sisampah
DB_PASSWORD=secure_password_here

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@sisampah.local
MAIL_FROM_NAME="SiSampah"
```

### 6. Database Migration

```bash
php artisan migrate --force
php artisan db:seed --class=RoleAndPermissionSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=TrashCategorySeeder
php artisan db:seed --class=ArticleSeeder
```

### 7. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 8. Setup Nginx

Buat file konfigurasi `/etc/nginx/sites-available/sisampah`:

```nginx
upstream php_backend {
    server unix:/run/php/php8.3-fpm.sock;
}

server {
    listen 80;
    listen [::]:80;
    server_name sisampah.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name sisampah.yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/sisampah.yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/sisampah.yourdomain.com/privkey.pem;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    root /var/www/sisampah/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php_backend;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    error_log /var/log/nginx/sisampah_error.log;
    access_log /var/log/nginx/sisampah_access.log;
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/sisampah /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 9. SSL Certificate dengan Let's Encrypt

```bash
sudo apt-get install -y certbot python3-certbot-nginx
sudo certbot certonly --nginx -d sisampah.yourdomain.com
```

### 10. Setup Supervisor untuk Queue Processing

Buat file `/etc/supervisor/conf.d/sisampah.conf`:

```ini
[program:sisampah-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/sisampah/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/sisampah-worker.log
user=www-data
```

Restart supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start sisampah-worker:*
```

### 11. Setup Cron Job untuk Scheduled Tasks

```bash
sudo crontab -e
```

Tambahkan:

```
* * * * * cd /var/www/sisampah && php artisan schedule:run >> /dev/null 2>&1
```

### 12. Setup Backup

Buat script `/usr/local/bin/backup-sisampah.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/var/backups/sisampah"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u sisampah -p'secure_password_here' sisampah | gzip > $BACKUP_DIR/sisampah_db_$DATE.sql.gz

# Backup files
tar -czf $BACKUP_DIR/sisampah_files_$DATE.tar.gz /var/www/sisampah

# Keep only last 7 days
find $BACKUP_DIR -name "*.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

Buat executable dan setup cron:

```bash
sudo chmod +x /usr/local/bin/backup-sisampah.sh
sudo crontab -e
```

Tambahkan:

```
0 2 * * * /usr/local/bin/backup-sisampah.sh >> /var/log/sisampah-backup.log 2>&1
```

## Monitoring & Maintenance

### Check Application Status

```bash
# Check PHP-FPM
sudo systemctl status php8.3-fpm

# Check Nginx
sudo systemctl status nginx

# Check MySQL
sudo systemctl status mysql

# Check Queue Workers
sudo supervisorctl status sisampah-worker:*
```

### View Logs

```bash
# Application logs
tail -f /var/www/sisampah/storage/logs/laravel.log

# Nginx error logs
tail -f /var/log/nginx/sisampah_error.log

# Queue worker logs
tail -f /var/log/sisampah-worker.log
```

### Database Optimization

```bash
# Optimize tables
php artisan db:optimize

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Update Application

```bash
cd /var/www/sisampah

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
sudo supervisorctl restart sisampah-worker:*
```

## Security Checklist

- [ ] Set `APP_DEBUG=false` di production
- [ ] Gunakan strong database password
- [ ] Enable SSL/TLS dengan Let's Encrypt
- [ ] Setup firewall rules
- [ ] Regular backup database dan files
- [ ] Monitor error logs
- [ ] Update PHP dan dependencies secara berkala
- [ ] Setup fail2ban untuk brute force protection
- [ ] Restrict file permissions (chmod 755 untuk directory, 644 untuk files)
- [ ] Disable unnecessary PHP functions

## Troubleshooting

### 500 Internal Server Error

```bash
# Check application logs
tail -f storage/logs/laravel.log

# Check PHP-FPM logs
tail -f /var/log/php8.3-fpm.log

# Check Nginx logs
tail -f /var/log/nginx/sisampah_error.log
```

### Database Connection Error

```bash
# Test MySQL connection
mysql -u sisampah -p -h 127.0.0.1 sisampah

# Check .env configuration
cat .env | grep DB_
```

### Queue Not Processing

```bash
# Check supervisor status
sudo supervisorctl status sisampah-worker:*

# Restart workers
sudo supervisorctl restart sisampah-worker:*

# Check queue logs
tail -f /var/log/sisampah-worker.log
```

---

**Untuk support lebih lanjut, silakan buat issue di repository atau hubungi tim development.**
