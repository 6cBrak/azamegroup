#!/bin/bash
# Déploiement AZAM GROUP — à lancer depuis /opt/azamgroupe sur le VPS
set -e

echo "==> Vérification réseau Traefik..."
docker network inspect web >/dev/null 2>&1 || docker network create web

echo "==> Pull dernière version..."
git pull origin main

echo "==> Build de l'image app..."
docker compose build --no-cache app

echo "==> Démarrage des containers..."
docker compose up -d

echo "==> Attente que la DB soit prête..."
sleep 12

echo "==> Génération APP_KEY si manquante..."
docker compose exec app php artisan key:generate --no-interaction 2>/dev/null || true

echo "==> Migrations..."
docker compose exec app php artisan migrate --force

echo "==> Seeder (première fois seulement — ignorer si déjà fait)..."
# Décommenter uniquement au premier déploiement :
# docker compose exec app php artisan db:seed --force

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
echo "  Site : https://www.azamgroupe.com"
echo "  Logs : docker compose logs -f nginx"
