# E-Commerce Laravel & Vue.js

Ce projet est un site e-commerce développé avec **Laravel** pour le back-end et **Vue.js** pour le front-end. L'application permet la gestion des produits, des paniers, des utilisateurs et des commandes dans un environnement moderne et performant.

## Technologies utilisées

- **Laravel** : Framework PHP pour la partie back-end
- **Vue.js** : Framework JavaScript pour la partie front-end
- **MySQL** : Base de données pour stocker les informations des produits, utilisateurs, etc.
- **Docker** : Conteneurisation de l'application avec Docker pour faciliter l'installation et le déploiement
- **Nginx** : Serveur web utilisé pour servir l'application

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants sur votre machine :

- **Docker** : [Docker installation](https://www.docker.com/get-started)
- **Docker Compose** : [Docker Compose installation](https://docs.docker.com/compose/install/)

## 🛠️ Installation

### 1. Cloner le projet

Clonez le projet depuis le repository GitHub :

```bash
git clone https://github.com/Anatoleaze/Ecommerce_Laravel.git
cd Ecommerce_Laravel
```

### 2. Lancer les containers Docker
Utilisez Docker Compose pour démarrer les containers nécessaires (MySQL, Nginx, PHP, Node.js) :

```bash
docker compose up -d --build
```

### 3. Installer les dépendances PHP avec Composer

```bash
docker exec -it laravel-app composer install
```

### 5. Donner les bonnes permissions aux dossiers nécessaires

```bash
docker exec -it laravel-app chown -R www-data:www-data /var/www/storage
docker exec -it laravel-app chown -R www-data:www-data /var/www/bootstrap/cache
```

### 6. Générer la clé d'application Laravel

```bash
docker exec -it laravel-app php artisan key:generate
```

### 7. Lancer les migrations

```bash
docker exec -it laravel-app php artisan migrate --seed

```

### 8. Accéder à l'application

Ouvrez votre navigateur à l'adresse suivante :

```bash
http://localhost:8000
```

## Licence

Ce projet est sous licence MIT - voir le fichier LICENSE pour plus de détails.
