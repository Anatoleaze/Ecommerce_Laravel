# 🛒 Primestore – E-Commerce Laravel & Vue.js

![Aperçu du projet](image/primestore.png)

## 📄 Description courte
Plateforme e-commerce full-stack moderne développée avec Laravel (Back-end) et Vue.js (Front-end).
Elle offre une gestion fluide des produits, paniers, utilisateurs et commandes dans un environnement performant.
L'application intègre le paiement sécurisé Stripe et est entièrement conteneurisée sous Docker.

---

## 📖 Description détaillée
Primestore est une application e-commerce complète conçue selon une architecture découplée (API Back-end / Single Page Application Front-end). Laravel assure la logique métier, la persistance des données sur une base MySQL, ainsi que la sécurisation des transactions. Côté front-end, Vue.js propose une interface dynamique et réactive pour l'expérience d'achat utilisateur.

L'environnement est entièrement conteneurisé grâce à Docker et Docker Compose avec un serveur Nginx, facilitant son déploiement et son exécution en local. Le projet inclut également un jeu de données de démonstration (seeders) pour tester le catalogue et le processus de commande immédiatement après l'installation.

---

## ✨ Fonctionnalités du projet
- 📦 **Gestion du catalogue** : Consultation, filtrage et fiches détaillées des produits.
- 🛒 **Panier d'achat dynamique** : Ajout, modification et suivi des articles en temps réel.
- 👤 **Espace utilisateur** : Authentification et gestion des comptes clients.
- 🛍️ **Gestion des commandes** : Suivi du statut et traitement des achats.
- 💳 **Paiement Stripe** : Module de paiement en ligne sécurisé via API.
- 🎲 **Données de démonstration** : Base de données pré-remplie à l'aide de migrations et seeders.
- 🐳 **Conteneurisation Docker** : Environnement complet avec Docker, Nginx et MySQL.

---

## 🛠️ Technologies utilisées
- **Back-end :** Laravel (PHP)
- **Front-end :** Vue.js
- **Base de données :** MySQL
- **Paiement :** API Stripe
- **DevOps & Infrastructure :** Docker, Docker Compose, Nginx

---

## 🚀 Installation

### 1️⃣ Cloner le projet
```bash
git clone https://github.com/Anatoleaze/Ecommerce_Laravel.git
cd Ecommerce_Laravel
```

### 2️⃣ Configuration de Stripe
1. Récupérez vos clés API sur votre tableau de bord [Stripe](https://dashboard.stripe.com) (*Publishable key* et *Secret key*).
2. Créez ou modifiez le fichier `.env.local` (côté front-end Vue.js) :

```env
VITE_STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
```

> ⚠️ *Important : `VITE_STRIPE_KEY` et `STRIPE_KEY` correspondent à la clé publique. Ne jamais exposer la clé secrète côté front-end.*

### 3️⃣ Démarrer les conteneurs Docker PrimeStore
```bash
docker compose up -d --build
```

### 4️⃣ Générer la clé Laravel
```bash
docker exec -it laravel-app php artisan key:generate
```

### 5️⃣ Lancer les migrations et les seeders
```bash
docker exec -it laravel-app php artisan migrate --seed
```

### 6️⃣ Accéder à l'application
Ouvrez votre navigateur à l'adresse suivante : 👉 http://localhost:8000

---

## 📄 Licence
Projet sous licence MIT.