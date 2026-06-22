#!/bin/bash
# Script de déploiement AZAM GROUP
set -e

echo "==> Pull dernière version..."
git pull origin main

echo "==> Build de l'image..."
docker compose build --no-cache app

echo "==> Redémarrage des containers..."
docker compose up -d

echo "==> Attente que la DB soit prête..."
sleep 10

echo "==> Migrations..."
docker compose exec app php artisan migrate --force

echo "==> Cache production..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

echo "==> Storage link..."
docker compose exec app php artisan storage:link 2>/dev/null || true

echo "==> Permissions storage..."
docker compose exec app chown -R www-data:www-data /var/www/storage
docker compose exec app chmod -R 775 /var/www/storage

echo ""
echo "✓ Déploiement terminé !"
