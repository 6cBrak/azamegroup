#!/bin/bash
# ============================================================
#  AZAM GROUP — Script d'installation automatique VPS
#  Usage : bash install.sh
# ============================================================
set -e

# ── Couleurs ────────────────────────────────────────────────
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'
BLUE='\033[0;34m'; BOLD='\033[1m'; NC='\033[0m'

info()    { echo -e "${BLUE}[INFO]${NC}  $1"; }
success() { echo -e "${GREEN}[OK]${NC}    $1"; }
warn()    { echo -e "${YELLOW}[WARN]${NC}  $1"; }
error()   { echo -e "${RED}[ERREUR]${NC} $1"; exit 1; }
title()   { echo -e "\n${BOLD}${BLUE}==> $1${NC}"; }

# ── Bannière ────────────────────────────────────────────────
echo -e "${BOLD}"
echo "  ╔══════════════════════════════════════╗"
echo "  ║     AZAM GROUP — Installation        ║"
echo "  ║     Laravel 12 + Docker + Traefik    ║"
echo "  ╚══════════════════════════════════════╝"
echo -e "${NC}"

# ── Vérifications ───────────────────────────────────────────
title "Vérification de l'environnement"

[ "$EUID" -ne 0 ] && error "Lance ce script en root : sudo bash install.sh"

command -v docker  >/dev/null 2>&1 || error "Docker n'est pas installé."
command -v git     >/dev/null 2>&1 || error "Git n'est pas installé."
success "Docker $(docker --version | awk '{print $3}' | tr -d ',')"
success "Git $(git --version | awk '{print $3}')"

# ── Configuration interactive ────────────────────────────────
title "Configuration"

read -p "  Domaine principal (ex: www.azamgroupe.com) : " DOMAIN
[ -z "$DOMAIN" ] && error "Le domaine est obligatoire."

read -p "  Domaine sans www (ex: azamgroupe.com)     : " DOMAIN_BARE
[ -z "$DOMAIN_BARE" ] && DOMAIN_BARE="${DOMAIN#www.}"

echo ""
read -s -p "  Mot de passe base de données (fort) : " DB_PASS
echo ""
[ -z "$DB_PASS" ] && error "Le mot de passe DB est obligatoire."
read -s -p "  Confirmer le mot de passe            : " DB_PASS2
echo ""
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

# ── Réseau Traefik ───────────────────────────────────────────
title "Réseau Docker 'web' (Traefik)"

if docker network inspect web >/dev/null 2>&1; then
    success "Réseau 'web' déjà existant."
else
    docker network create web
    success "Réseau 'web' créé."
fi

# ── Clonage ─────────────────────────────────────────────────
title "Clonage du dépôt"

if [ -d "$INSTALL_DIR/.git" ]; then
    warn "Dépôt déjà présent — mise à jour (git pull)..."
    git -C "$INSTALL_DIR" pull origin main
else
    git clone "$REPO_URL" "$INSTALL_DIR"
fi
success "Code source prêt dans $INSTALL_DIR"

# ── Génération APP_KEY ───────────────────────────────────────
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

success ".env créé avec APP_KEY générée automatiquement."

# ── Mise à jour labels Traefik selon domaine saisi ───────────
title "Configuration des labels Traefik"

COMPOSE_FILE="$INSTALL_DIR/docker-compose.yml"

# Remplacer le domaine www
sed -i "s/www\.azamgroupe\.com/${DOMAIN}/g" "$COMPOSE_FILE"
# Remplacer le domaine bare
sed -i "s/azamgroupe\.com/${DOMAIN_BARE}/g" "$COMPOSE_FILE"

success "Domaine $DOMAIN configuré dans docker-compose.yml"

# ── Build & démarrage ────────────────────────────────────────
title "Build de l'image Docker"

cd "$INSTALL_DIR"
docker compose build --no-cache app
success "Image construite."

title "Démarrage des containers"
docker compose up -d
success "Containers démarrés."

# ── Attente MySQL ────────────────────────────────────────────
title "Attente que MySQL soit prêt..."

MAX=30; COUNT=0
until docker compose exec -T db mysqladmin ping -h localhost -u root -p"${DB_PASS}" --silent 2>/dev/null; do
    COUNT=$((COUNT+1))
    [ $COUNT -ge $MAX ] && error "MySQL ne répond pas après ${MAX} tentatives."
    echo -n "."
    sleep 3
done
echo ""
success "MySQL prêt."

# ── Laravel setup ────────────────────────────────────────────
title "Migrations"
docker compose exec -T app php artisan migrate --force
success "Migrations exécutées."

title "Seeder (catégories, produits, admin)"
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

# ── Résumé final ─────────────────────────────────────────────
echo ""
echo -e "${BOLD}${GREEN}"
echo "  ╔══════════════════════════════════════════════════╗"
echo "  ║           Installation terminée !               ║"
echo "  ╠══════════════════════════════════════════════════╣"
echo -e "  ║  Site      : https://${DOMAIN}$(printf '%*s' $((40 - ${#DOMAIN})) '')║"
echo "  ║  Admin     : https://${DOMAIN}/admin            "
echo "  ║  Email     : admin@azamgroupe.com               ║"
echo "  ║  MDP admin : Admin@2024  ← CHANGER MAINTENANT  ║"
echo "  ╠══════════════════════════════════════════════════╣"
echo "  ║  Commandes utiles :                             ║"
echo "  ║   docker compose logs -f          (logs live)  ║"
echo "  ║   docker compose restart          (redémarrer) ║"
echo "  ║   cd $INSTALL_DIR && git pull (màj code)       ║"
echo "  ║   ./deploy.sh                    (redéployer)  ║"
echo "  ╚══════════════════════════════════════════════════╝"
echo -e "${NC}"
echo -e "${YELLOW}  ⚠  Assure-toi que les DNS de ${DOMAIN} pointent vers ce serveur.${NC}"
echo -e "${YELLOW}  ⚠  Change le mot de passe admin sur /admin dès la première connexion.${NC}"
echo ""
