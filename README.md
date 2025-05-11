# JustEat

## E-Commerce Laravel & Vue.js

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

## Installation

### 1. Cloner le projet

Clonez le projet depuis le repository GitHub :

```bash
git clone https://github.com/Anatoleaze/JustEat.git
cd JustEat
```

### 2. Configurer les variables d'environnement
Copiez le fichier .env.example en .env et configurez-le selon vos besoins. Vous devrez probablement spécifier les informations de connexion à la base de données.

```bash
cp .env.local .env
```

### 3. Lancer les containers Docker
Utilisez Docker Compose pour démarrer les containers nécessaires (MySQL, Nginx, et l'application Laravel).

```bash
docker compose up -d --build
```

Cela va construire les containers et démarrer l'application en mode détaché.

### 4. Lancer les migrations

Une fois les containers démarrés, vous pouvez appliquer les migrations de la base de données avec Laravel :

```bash
docker exec -it laravel-app php artisan migrate
```

Cela créera les tables nécessaires dans la base de données MySQL.

### 5. Accéder à l'application

Une fois les containers en place et les migrations exécutées, vous pouvez accéder à l'application via votre navigateur à l'adresse suivante :

```bash
http://localhost:8000
```

## Licence

Ce projet est sous licence MIT - voir le fichier LICENSE pour plus de détails.
