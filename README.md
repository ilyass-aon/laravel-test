# 🏠 Property Booking Management System

Une application Laravel complète pour la gestion des réservations de propriétés. Système permettant aux utilisateurs de consulter et réserver des propriétés, avec un tableau de bord administrateur complet pour gérer les réservations et les revenus.

## 📋 Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Technologies](#technologies)
- [Configuration initiale](#configuration-initiale)
- [Installation](#installation)
- [Seeding de la base de données](#seeding-de-la-base-de-données)
- [Utilisation](#utilisation)
- [Structure du projet](#structure-du-projet)
- [Documentation interface](INTERFACE_DOCUMENTATION.md)

---

## ✨ Fonctionnalités

### Pour les utilisateurs
- ✅ Consultation des propriétés disponibles
- ✅ Réservation de propriétés avec sélection de dates
- ✅ Gestion des réservations (consulter, annuler)
- ✅ Dashboard utilisateur avec récapitulatif des réservations
- ✅ Système d'authentification sécurisé

### Pour les administrateurs
- ✅ Tableau de bord avec statistiques complètes
- ✅ Gestion des propriétés (CRUD)
- ✅ Gestion des réservations
- ✅ Suivi des revenus
- ✅ Gestion des utilisateurs
- ✅ Interface admin professionnelle via Filament

---

## 🛠️ Technologies

| Technologie | Version | Utilisation |
|------------|---------|-------------|
| **Laravel** | 11.0 | Framework backend |
| **PHP** | 8.2+ | Langage serveur |
| **Livewire** | 3.5 | Composants réactifs |
| **Filament** | 4.0 | Admin panel |
| **Tailwind CSS** | 3.1 | Styling front-end |
| **MySQL** | 5.7+ | Base de données |
| **Vite** | 7.0 | Build tool |
| **Node.js** | 18+ | Gestion des assets |

---

## 📦 Configuration initiale

### Prérequis
- **PHP 8.2+** 
- **MySQL 5.7+** (base de données)
- **Composer** (pour les dépendances PHP)
- **Node.js 18+** et **npm** (pour les assets front-end)
- **Git** (optionnel)

### Vérification de votre environnement

```bash
php --version
composer --version
node --version
npm --version
```

---

## 🚀 Installation

### Étape 1 : Cloner le projet

```bash
cd laravel-test
```

### Étape 2 : Copier le fichier d'environnement

```bash
# Windows
copy .env.example .env

# macOS/Linux
cp .env.example .env
```

### Étape 3 : Configurer le fichier `.env`

Le fichier `.env` contient les configurations essentielles. Voici les variables importantes :

```env
# Application
APP_NAME="Property Booking"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=property_booking
DB_USERNAME=root
DB_PASSWORD=your_password

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Étape 4 : Installer les dépendances PHP

```bash
composer install
```

### Étape 5 : Générer la clé d'application

```bash
php artisan key:generate
```

### Étape 6 : Créer la base de données MySQL

```bash
# Créer la base de données dans MySQL
mysql -u root -p -e "CREATE DATABASE property_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Ou via PhpMyAdmin/MySQL Workbench
# CREATE DATABASE property_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Étape 7 : Exécuter les migrations

```bash
php artisan migrate
```

**Ou directement avec forçage (pour le développement):**
```bash
php artisan migrate --force
```

### Étape 8 : Seeder la base de données

```bash
php artisan db:seed
```

**Ou seeder une classe spécifique:**
```bash
php artisan db:seed --class=PropertySeeder
```

### Étape 9 : Installer les dépendances Node.js

```bash
npm install
```

### Étape 10 : Compiler les assets

```bash
# Mode production
npm run build

# Mode développement (avec hot reload)
npm run dev
```

### Étape 11 : Lancer le serveur

```bash
php artisan serve
```

L'application sera disponible sur `http://localhost:8000`

---

## 🌱 Seeding de la base de données

### Vue d'ensemble des seeders

| Seeder | Classe | Fonction |
|--------|--------|----------|
| **DatabaseSeeder** | `Database\Seeders\DatabaseSeeder` | Seeder principal qui orchestre tout |
| **PropertySeeder** | `Database\Seeders\PropertySeeder` | Crée les propriétés d'exemple |

### DatabaseSeeder

Le seeder principal crée les utilisateurs et appelle PropertySeeder :

```php
// Fichier: database/seeders/DatabaseSeeder.php

User::create([
    'name'     => 'admin',
    'email'    => 'admin@admin.com',
    'password' => Hash::make('test123456'),
    'is_admin' => true,
]);

User::create([
    'name'     => 'ilyass',
    'email'    => 'ilyass@test.com',
    'password' => Hash::make('test123456'),
    'is_admin' => false,
]);

$this->call([
    PropertySeeder::class,
]);
```

**Création automatique :**
- 1 utilisateur administrateur
- 1 utilisateur de test
- 5 propriétés (voir PropertySeeder)

### PropertySeeder

Crée 5 propriétés d'exemple avec des localisations françaises :

| Nom | Location | Prix/nuit | Max Guests |
|-----|----------|-----------|------------|
| Villa Provençale | Gordes, Provence | 890€ | 8 |
| Château de la Loire | Amboise, Vallée de la Loire | 1200€ | 12 |
| Appartement Saint-Germain | Paris 6e | 180€ | 2 |
| Maison Basque | Bidart, Pays Basque | 350€ | 5 |
| Chalet Mont-Blanc | Chamonix, Alpes | 420€ | 6 |

### Commandes de seeding

```bash
# Seeder toute la base de données
php artisan db:seed

# Seeder une classe spécifique
php artisan db:seed --class=PropertySeeder

# Réinitialiser la base et seeder
php artisan migrate:refresh --seed

# Réinitialiser avec forçage (production)
php artisan migrate:refresh --seed --force
```

### Réinitialiser les seeders en développement

```bash
# Option 1 : Rafraîchir toute la base
php artisan migrate:refresh --seed

# Option 2 : Vider une table spécifique et la recreer
php artisan tinker
>>> DB::table('properties')->truncate();
>>> exit
php artisan db:seed --class=PropertySeeder
```

---

## 💡 Utilisation

### Accéder au dashboard utilisateur

1. Allez sur `http://localhost:8000/register`
2. Créez un compte utilisateur
3. Connectez-vous
4. Accédez au dashboard personnalisé

### Accéder au panel administrateur

1. Allez sur `http://localhost:8000/admin`
2. Connectez-vous avec :
   - **Email:** `admin@admin.com`
   - **Mot de passe:** `test123456`

### Réserver une propriété

1. Sur la page d'accueil, consultez les propriétés disponibles
2. Cliquez sur "Réserver" pour une propriété
3. Sélectionnez les dates de check-in et check-out
4. Confirmez votre réservation

---

## 📁 Structure du projet

### Répertoires principaux

```
laravel-test/
├── app/
│   ├── Filament/              # Ressources Filament (Admin panel)
│   │   ├── Resources/         # Resources CRUD
│   │   ├── Pages/             # Pages custom du dashboard
│   │   └── Widgets/           # Widgets statistiques
│   ├── Http/
│   │   ├── Controllers/       # Contrôleurs de l'app
│   │   └── Requests/          # Form requests
│   ├── Livewire/              # Composants Livewire
│   ├── Models/                # Modèles Eloquent
│   │   ├── User.php
│   │   ├── Property.php
│   │   └── Booking.php
│   └── Providers/
│
├── database/
│   ├── migrations/            # Migrations de schéma
│   ├── seeders/               # Seeders de données
│   │   ├── DatabaseSeeder.php
│   │   └── PropertySeeder.php
│   └── factories/             # Factories de test
│
├── routes/
│   ├── web.php                # Routes web
│   ├── auth.php               # Routes authentification
│   └── console.php
│
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript
│
├── config/                    # Configuration de l'app
├── storage/                   # Fichiers stockés
├── tests/                     # Tests automatisés
└── public/                    # Assets publics
```

### Modèles de données

#### User
- `id` - Clé primaire
- `name` - Nom de l'utilisateur
- `email` - Email unique
- `password` - Mot de passe hashé
- `is_admin` - Boolean (accès admin)
- `timestamps` - created_at, updated_at

**Relations :**
- `bookings()` - Réservations de l'utilisateur

#### Property
- `id` - UUID primaire
- `name` - Nom de la propriété
- `description` - Description détaillée
- `price_per_night` - Prix par nuit (decimal 8,2)
- `location` - Localisation
- `max_guests` - Nombre maximum de clients
- `timestamps` - created_at, updated_at

**Relations :**
- `bookings()` - Réservations liées
- `getIsAvailableAttribute()` - Vérifier disponibilité

#### Booking
- `id` - UUID primaire
- `user_id` - Référence utilisateur
- `property_id` - Référence propriété
- `start_date` - Date d'arrivée
- `end_date` - Date de départ
- `status` - Enum: pending, confirmed, cancelled
- `nbr_guests` - Nombre de clients
- `timestamps` - created_at, updated_at

**Relations :**
- `user()` - Utilisateur qui a réservé
- `property()` - Propriété réservée
- `getTotalPriceAttribute()` - Prix total calculé

---

## 🔐 Comptes de test

### Administrateur
```
Email:    admin@admin.com
Password: test123456
```
**Accès :** http://localhost:8000/admin

### Utilisateur de test
```
Email:    ilyass@test.com
Password: test123456
```
**Accès :** http://localhost:8000/dashboard

---

## 🚦 Commandes utiles

### Développement

```bash
# Lancer le serveur de développement
php artisan serve

# Lancer avec npm en parallèle (si disponible)
npm run dev

# Lancer tous les services à la fois
composer run dev
```

### Base de données

```bash
# Créer les tables
php artisan migrate

# Annuler les migrations
php artisan migrate:rollback

# Réinitialiser et seeder
php artisan migrate:refresh --seed

# Voir le statut des migrations
php artisan migrate:status

# Vérifier la structure de la BD avec Tinker
php artisan tinker
>>> DB::table('properties')->get()
>>> exit
```

### Cache et Session

```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Effacer les sessions
php artisan session:clear
```

### Assets

```bash
# Construire les assets
npm run build

# Développement avec hot reload
npm run dev

# Vérifier les dépendances
npm list
```

---

## 🎨 Pages principales

### Page d'accueil
- URL: `/`
- Affiche toutes les propriétés disponibles
- Permet de consulter les détails

### Dashboard utilisateur
- URL: `/dashboard` (authentifié)
- Statistiques personnalisées
- Récentes réservations
- Prochaine réservation confirmée

### Réservation
- URL: `/properties/{id}/book`
- Formulaire de réservation
- Sélection des dates
- Calcul du prix total

### Admin Panel
- URL: `/admin`
- Gestion complète avec Filament
- Ressources: Users, Properties, Bookings
- Widgets de statistiques

---

## 📊 Fichiers de configuration importants

### `.env`
Configuration locale (variables d'environnement)

### `config/app.php`
Configuration générale de l'application

### `config/database.php`
Configuration des bases de données

### `tailwind.config.js`
Configuration Tailwind CSS

### `vite.config.js`
Configuration du build Vite

---

## 🐛 Dépannage

### La base de données MySQL n'existe pas
```bash
mysql -u root -p -e "CREATE DATABASE property_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate
```

### Erreur de connexion MySQL
```bash
# Vérifier que MySQL est en cours d'exécution
# Vérifier les identifiants dans .env
# Vérifier que la base de données existe
mysql -u root -p
SHOW DATABASES;
```

### Les assets ne se compilent pas
```bash
npm install
npm run build
```

### Erreur "class not found"
```bash
composer dump-autoload
```

### Sessions/Cache non fonctionnels
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 📞 Support

Pour plus d'informations:
- Documentation Laravel: https://laravel.com/docs
- Documentation Livewire: https://livewire.laravel.com
- Documentation Filament: https://filamentadmin.com
- Documentation Tailwind: https://tailwindcss.com

---

## 📝 Notes supplémentaires

### Scripts Composer disponibles

- `composer setup` - Installation complète (installer, config, migrations, assets)
- `composer dev` - Lancer tous les services (serveur, queue, logs, Vite)
- `composer test` - Exécuter les tests PHPUnit

### Authentification

L'application utilise **Laravel Breeze** pour l'authentification avec routes protégées par middleware.

### Variables d'environnement requises

| Variable | Défaut | Description |
|----------|--------|-------------|
| `APP_DEBUG` | `true` | Mode débogage |
| `DB_CONNECTION` | `mysql` | Type de base de données |
| `SESSION_DRIVER` | `database` | Stockage des sessions |
| `CACHE_STORE` | `database` | Stockage du cache |

---

**Dernière mise à jour:** Juin 2026
