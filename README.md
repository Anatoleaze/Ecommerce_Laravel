# Primestore - E-Commerce Laravel & Vue.js

Ce projet est une plateforme e-commerce développée avec **Laravel** pour le back-end et **Vue.js** pour le front-end.  
L'application Primestore permet la gestion des produits, des paniers, des utilisateurs et des commandes dans un environnement moderne et performant.

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

## 2. Configuration de Stripe

Après avoir cloné le projet, vous devez configurer Stripe afin de permettre le fonctionnement des paiements.

### 2.1 Créer un compte Stripe

Rendez-vous sur https://dashboard.stripe.com et créez un compte (ou connectez-vous si vous en avez déjà un).

Ensuite, récupérez vos clés API dans le tableau de bord Stripe :
- Clé publique (Publishable key)
- Clé secrète (Secret key)

### 2.2 Configuration des variables d’environnement

Créez ou modifiez le fichier `.env.local` (côté front-end Vue.js) et ajoutez :

```env
VITE_STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
```

### 2.3 Important

- VITE_STRIPE_KEY et STRIPE_KEY correspondent à la même clé publique Stripe
- STRIPE_SECRET correspond à la clé secrète Stripe
- Ne jamais exposer la clé secrète côté front-end

---

## 3. Démarrer les containers Docker PrimeStore

```bash
docker compose up -d --build
```

---

## 4. Générer la clé Laravel

```bash
docker exec -it laravel-app php artisan key:generate
```

---

## 5. Lancer les migrations et les seeders de Primestore

```bash
docker exec -it laravel-app php artisan migrate --seed
```

---

## 6. Accéder à l’application Primestore

Ouvrez votre navigateur à l’adresse suivante :

```txt
http://localhost:8000
```

---

## Licence

Projet sous licence MIT.