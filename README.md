 
## À propos

**Projet : Système de Gestion des Rendez-vous Médicaux**.

Ce projet est une application web développée avec **Laravel**. Elle permet notamment de gérer des rendez-vous (création/validation/annulation), des consultations, ainsi que des prestations, avec une gestion des rôles et permissions (ex. patient, médecin, secrétaire, responsable prestations).

Les diagrammes UML du système sont disponibles dans le dossier **`UML/`**.

## Outils et technologies utilisées

- **Laravel** (framework PHP)
- **Composer** (gestion des dépendances PHP)
- **npm** / **Node.js** (gestion des dépendances front)
- **Vite** (bundler pour les assets)
- **Tailwind CSS** (styles)
- **PlantUML** (génération/visualisation des diagrammes dans `UML/`)

## Démarrage rapide

### 1) Installation des dépendances PHP

```bash
composer install
```

### 2) Configuration de l’environnement

Copiez le fichier d’exemple puis configurez vos identifiants base de données :

```bash
cp .env.example .env
```

### 3) Lancer les migrations et seeders

```bash
php artisan migrate
php artisan db:seed
```

> Note : les seeders incluent notamment `RolesAndPermissionsSeeder` pour préparer les rôles/permissions et des utilisateurs de test.

### 4) Installation des dépendances front

```bash
npm install
```

### 5) Démarrer le serveur de développement

```bash
php artisan serve
```

### 6) (Optionnel) Construire/servir les assets front

Selon la configuration Vite du projet :

```bash
npm run dev
```

## Fonctionnalités par rôle

Le système gère des fonctionnalités différentes selon le rôle connecté.

### Patient
- Accéder à son **dashboard patient** (`/patient/dashboard`).
- **Prendre un RDV** : création et enregistrement (`/patient/rv/create` et `/patient/rv/store`).
- **Annuler un RDV** (`/patient/rv/cancel/{id}`).
- **Imprimer** une consultation ou une prestation associée à un patient :
  - Consultation (`/patient/consultation/{id}/print`)
  - Prestation (`/patient/prestation/{id}/print`).

### Secrétaire
- Accéder à son **dashboard** (`/secretaire/dashboard`).
- **Valider un RDV** (`/secretaire/rv/validate/{id}`).
- **Annuler** un RDV (`/secretaire/rv/{id}/cancel`).
- **Marquer comme complété** (`/secretaire/rv/{id}/complete`).
- Consulter les **statistiques** (`/secretaire/statistics`).

### Médecin
- Accéder à son **dashboard** (`/medecin/dashboard`).
- **Voir les consultations** : écran de consultation (`/medecin/consultation/{id}`).
- **Compléter une consultation** (`/medecin/consultation/{id}/complete`).
- **Annuler une consultation** (`/medecin/consultation/{id}/cancel`).
- **Rechercher un patient** (`/medecin/patient/search`).
- Voir l’**historique patient** (`/medecin/patient/{id}/history`).

### Responsable prestations
- Accéder à son **dashboard** (`/responsable/dashboard`).
- **Voir une prestation** (`/responsable/prestation/{id}`).
- **Mettre à jour les résultats** (`/responsable/prestation/{id}/update`).
- **Annuler une prestation** (`/responsable/prestation/{id}/cancel`).

### Statistiques (page partagée)
- La page **Statistiques du Jour** est accessible via `/statistics`.
- Rôles autorisés : `secretaire`, `medecin`, `responsable_prestation`.

## UML

Le dossier `UML/` contient l’ensemble des diagrammes en **PlantUML** : contexte, classes, séquences, cas d’usage, états, architecture, déploiement, etc.

Voir `UML/README.md` pour la compilation (PlantUML en ligne ou local, extension VS Code, etc.).


## Contribuer

Les contributions sont les bienvenues. Veuillez vous référer à la documentation Laravel pour les bonnes pratiques de contribution.

## Sécurité

En cas de faille de sécurité, merci de signaler le problème via les canaux recommandés par la communauté Laravel.

## Licence

Le framework **Laravel** est open-source et distribué sous licence **MIT**.

