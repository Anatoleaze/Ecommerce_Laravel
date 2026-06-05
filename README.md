# E-Commerce Laravel & Vue.js

Ce projet est un site e-commerce développé avec **Laravel** pour le back-end et **Vue.js** pour le front-end.  
L'application permet la gestion des produits, des paniers, des utilisateurs et des commandes dans un environnement moderne et performant.

---

## Technologies utilisées

- **Laravel** : Framework PHP pour la partie back-end
- **Vue.js** : Framework JavaScript pour la partie front-end
- **MySQL** : Base de données relationnelle
- **Docker** : Conteneurisation de l'application
- **Nginx** : Serveur web

---

## Fonctionnalités

- Gestion des produits
- Gestion des utilisateurs
- Panier d’achat
- Gestion des commandes
- Base de données avec seeders
- Architecture Dockerisée

---

## Prérequis

Avant de commencer, assurez-vous d’avoir installé :

- Docker
- Docker Compose

---

# 🛠️ Installation

## 1. Cloner le projet

```bash
git clone https://github.com/Anatoleaze/Ecommerce_Laravel.git
cd Ecommerce_Laravel
```

---

## 2. Démarrer les containers Docker

```bash
docker compose up -d --build
```

---

## 3. Générer la clé Laravel

```bash
docker exec -it laravel-app php artisan key:generate
```

---

## 4. Lancer les migrations et les seeders

```bash
docker exec -it laravel-app php artisan migrate --seed
```

---

## 5. Accéder à l’application

Ouvrez votre navigateur à l’adresse suivante :

```txt
http://localhost:8000
```

---

## Licence

Projet sous licence MIT.