#!/bin/bash
# ============================================================
#  AZAM GROUP — Script d'installation automatique VPS
#  Usage : bash install.sh
#  Testé : Ubuntu 24.04, Docker 29.x, Docker Compose v5.x
# ============================================================
set -e

RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'
BLUE='\033[0;34m'; BOLD='\033[1m'; NC='\033[0m'

info()    { echo -e "${BLUE}[INFO]${NC}  $1"; }
success() { echo -e "${GREEN}[OK]${NC}    $1"; }
warn()    { echo -e "${YELLOW}[WARN]${NC}  $1"; }
error()   { echo -e "${RED}[ERREUR]${NC} $1"; exit 1; }
title()   { echo -e "\n${BOLD}${BLUE}==> $1${NC}"; }

echo -e "${BOLD}"
echo "  ╔══════════════════════════════════════╗"
echo "  ║     AZAM GROUP — Installation        ║"
echo "  ║     Laravel 12 + Docker + Traefik    ║"
echo "  ╚══════════════════════════════════════╝"
echo -e "${NC}"

# ── Vérifications ────────────────────────────────────────────
title "Vérification de l'environnement"

[ "$EUID" -ne 0 ] && error "Lance ce script en root : sudo bash install.sh"
command -v docker >/dev/null 2>&1 || error "Docker n'est pas installé."
command -v git    >/dev/null 2>&1 || error "Git n'est pas installé."

success "Docker $(docker --version | awk '{print $3}' | tr -d ',')"
success "Docker Compose $(docker compose version | awk '{print $NF}')"
success "Git $(git --version | awk '{print $3}')"

# Vérifier que le réseau Traefik 'web' existe
docker network inspect web >/dev/null 2>&1 \
    && success "Réseau Traefik 'web' détecté." \
    || error "Le réseau Docker 'web' est introuvable. Assure-toi que Traefik est démarré."

# Vérifier que Traefik tourne
docker ps --format '{{.Names}}' | grep -q traefik \
    && success "Traefik est en cours d'exécution." \
    || warn "Aucun container Traefik détecté — le SSL ne fonctionnera pas."

# ── Configuration interactive ─────────────────────────────────
title "Configuration"

read -p "  Domaine principal        (ex: www.azamgroupe.com) : " DOMAIN
[ -z "$DOMAIN" ] && error "Le domaine est obligatoire."

# Auto-déduire le bare domain
DEFAULT_BARE="${DOMAIN#www.}"
read -p "  Domaine sans www         (défaut: $DEFAULT_BARE) : " DOMAIN_BARE
[ -z "$DOMAIN_BARE" ] && DOMAIN_BARE="$DEFAULT_BARE"

echo ""
read -s -p "  Mot de passe base de données (fort, min 12 car.) : " DB_PASS; echo ""
[ ${#DB_PASS} -lt 8 ] && error "Mot de passe trop court (minimum 8 caractères)."
read -s -p "  Confirmer le mot de passe                        : " DB_PASS2; echo ""
[ "$DB_PASS" != "$DB_PASS2" ] && error "Les mots de passe ne correspondent pas."

INSTALL_DIR="/opt/azamgroupe"
REPO_URL="https://github.com/6cBrak/azamegroup.git"

echo ""
info "Domaine       : https://$DOMAIN"
info "Redirection   : https://$DOMAIN_BARE → https://$DOMAIN"
info "Répertoire    : $INSTALL_DIR"
echo ""
read -p "  Confirmer et lancer l'installation ? [o/N] : " CONFIRM
[[ ! "$CONFIRM" =~ ^[oO]$ ]] && { echo "Annulé."; exit 0; }

# ── Clonage ──────────────────────────────────────────────────
title "Clonage du dépôt"

if [ -d "$INSTALL_DIR/.git" ]; then
    warn "Dépôt déjà présent — mise à jour (git pull)..."
    git -C "$INSTALL_DIR" pull origin main
else
    git clone "$REPO_URL" "$INSTALL_DIR"
fi
success "Code source prêt dans $INSTALL_DIR"

# ── Génération APP_KEY ────────────────────────────────────────
APP_KEY="base64:$(openssl rand -base64 32)"

# ── Création du .env ─────────────────────────────────────────
title "Création du fichier .env"

cat > "$INSTALL_DIR/.env" <<EOF
APP_NAME="AZAM GROUP"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=https://${DOMAIN}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=azamgroupe
DB_USERNAME=azamuser
DB_PASSWORD=${DB_PASS}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log

FILESYSTEM_DISK=public
EOF

success ".env créé (APP_KEY générée automatiquement)."

# ── Patch domaine dans docker-compose.yml ─────────────────────
title "Configuration des domaines Traefik"

COMPOSE_FILE="$INSTALL_DIR/docker-compose.yml"
sed -i "s/www\.azamgroupe\.com/${DOMAIN}/g"     "$COMPOSE_FILE"
sed -i "s/azamgroupe\.com/${DOMAIN_BARE}/g"      "$COMPOSE_FILE"
success "Labels Traefik mis à jour : $DOMAIN / $DOMAIN_BARE"

# ── Build & démarrage ─────────────────────────────────────────
title "Build de l'image Docker"
cd "$INSTALL_DIR"
docker compose build --no-cache app
success "Image PHP-FPM construite."

title "Démarrage des containers"
docker compose up -d
success "Containers démarrés (azam_app, azam_nginx, azam_db)."

# ── Attente MySQL ─────────────────────────────────────────────
title "Attente que MySQL soit prêt..."

MAX=30; COUNT=0
until docker compose exec -T db mysqladmin ping -h localhost -u root -p"${DB_PASS}" --silent 2>/dev/null; do
    COUNT=$((COUNT+1))
    [ $COUNT -ge $MAX ] && error "MySQL ne répond pas après ${MAX} tentatives."
    echo -n "."; sleep 3
done
echo ""
success "MySQL prêt."

# ── Laravel setup ─────────────────────────────────────────────
title "Migrations"
docker compose exec -T app php artisan migrate --force
success "Migrations exécutées."

title "Seeder (catégories, produits, compte admin)"
docker compose exec -T app php artisan db:seed --force
success "Données initiales insérées."

title "Cache production"
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
success "Cache généré."

title "Storage link & permissions"
docker compose exec -T app php artisan storage:link 2>/dev/null || true
docker compose exec -T app chown -R www-data:www-data /var/www/storage
docker compose exec -T app chmod -R 775 /var/www/storage
success "Permissions OK."

# ── Résumé ────────────────────────────────────────────────────
echo ""
echo -e "${BOLD}${GREEN}"
echo "  ╔════════════════════════════════════════════════════╗"
echo "  ║            Installation terminée !                ║"
echo "  ╠════════════════════════════════════════════════════╣"
echo "  ║  Site    : https://${DOMAIN}"
echo "  ║  Admin   : https://${DOMAIN}/admin"
echo "  ║  Email   : admin@azamgroupe.com"
echo "  ║  MDP     : docker compose logs app | grep "mot de passe""
echo "  ╠════════════════════════════════════════════════════╣"
echo "  ║  Containers actifs :"
echo "  ║    azam_app    — PHP 8.2-FPM (Laravel)"
echo "  ║    azam_nginx  — Nginx (servi via Traefik)"
echo "  ║    azam_db     — MySQL 8.0"
echo "  ╠════════════════════════════════════════════════════╣"
echo "  ║  Commandes utiles :"
echo "  ║    docker compose -f $INSTALL_DIR/docker-compose.yml logs -f"
echo "  ║    cd $INSTALL_DIR && ./deploy.sh   (mise à jour)"
echo "  ╚════════════════════════════════════════════════════╝"
echo -e "${NC}"
echo -e "${YELLOW}  ⚠  DNS : pointe ${DOMAIN} et ${DOMAIN_BARE} vers ce serveur.${NC}"
echo -e "${YELLOW}  ⚠  Change le mot de passe admin sur /admin dès la 1ère connexion.${NC}"
echo ""
