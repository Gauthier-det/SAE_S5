# Sanglier Explorer - Guide de Démarrage

## 🚀 Démarrage Rapide

### Prérequis
- PHP 8.2+
- Node.js + npm
- Composer

### 1️⃣ Initialisation du projet

```bash
cd laravel
composer setup
```

Cette commande :
- ✅ Installe les dépendances PHP
- ✅ Génère la clé d'application
- ✅ Crée la base de données SQLite
- ✅ Exécute les migrations
- ✅ Installe les dépendances npm
- ✅ Compile les assets front (React + Tailwind)

### 2️⃣ Lancer l'application en développement

```bash
composer dev
```

Cela lance automatiquement en parallèle :
- 🐘 **Serveur Laravel** → http://127.0.0.1:8000
- ⚡ **Vite dev server** (React/Tailwind avec hot reload)
- 📊 **Queue worker** (traitement des jobs)

### 3️⃣ Accéder l'application

Ouvrez votre navigateur : **http://127.0.0.1:8000**

## 🛠️ Commandes Utiles

### Développement
```bash
composer dev          # Lancer tout
npm run dev          # Seulement le front (Vite)
php artisan serve    # Seulement le serveur
```

### Base de données
```bash
php artisan migrate              # Exécuter les migrations
php artisan migrate:rollback     # Annuler la dernière migration
php artisan db:seed              # Remplir la base avec les seeders
php artisan tinker               # Console PHP interactive
```

### Tests
```bash
composer test        # Lancer les tests
php artisan test     # Alternative
```

### Build pour la production
```bash
npm run build        # Compiler les assets
```

## 📁 Structure du Projet

- `laravel/app/` → Code PHP (Controllers, Models, etc.)
- `laravel/resources/js/` → Code React (TypeScript)
- `laravel/routes/` → Routes (API + Web)
- `laravel/database/` → Migrations et seeders
- `laravel/storage/` → Fichiers uploadés, logs

## 🔧 Configuration

- `.env` → Variables de développement (SQLite)
- `.env.prod` → Variables de production (MySQL)

## ❌ Problèmes courants

**"Database file does not exist"**
```bash
php artisan migrate --force
```

**Vite ne compile pas**
```bash
npm install
npm run dev
```

**Accès refusé à la base de données**
- Vérifier les droits d'accès au dossier `storage/`

---

**Documentation** : [Laravel](https://laravel.com/docs) | [React](https://react.dev) | [Vite](https://vitejs.dev)
