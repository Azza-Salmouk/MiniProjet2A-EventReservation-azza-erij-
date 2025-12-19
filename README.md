# MiniProjet2A-EventReservation-azza-erij-
"Projet de réservation d'événements – 2A GL-03"


## 📋 Description

Application web de gestion de réservations d'événements développée en PHP (MVC) avec MySQL.

**Fonctionnalités** :
- **Côté utilisateur** : Consulter les événements et réserver en ligne
- **Côté admin** : CRUD événements, gestion des réservations, upload d'images

---

## 👥 Équipe

- **Azza** 
- **Erij** 

---

## 🛠️ Technologies Utilisées

- **Backend** : PHP 8+ (Patron MVC simple)
- **Base de données** : MySQL avec PDO
- **Frontend** : HTML5, CSS3, JavaScript
- **Serveur** : Apache ou PHP Built-in Server
- **Version Control** : GitHub (branches main/dev/feature/*)

---

## 📂 Structure du Projet

```
/MiniProjet2A-EventReservation-azza-erij-/
├── /app/
│   ├── /models/           # Classes métier (Event, Reservation, Admin)
│   ├── /controllers/      # Logique applicative (EventController, AdminController)
│   ├── /views/            # Fichiers de vues HTML+PHP (géré par Erij)
│   └── /helpers/          # Classes utilitaires (Validator, ImageUploader, Flash)
├── /config/
│   ├── bootstrap.php      # Initialisation (session, helpers)
│   ├── database.php       # Connexion PDO MySQL
│   └── routes.php         # Définition des routes (13 routes)
├── /public/
│   ├── index.php          # Point d'entrée (routeur frontal)
│   ├── /uploads/          # Images des événements
│   ├── /css/              # Feuilles de style (Erij)
│   ├── /js/               # Scripts JavaScript (Erij)
│   └── test_*.php         # Scripts de test backend
├── BACKEND_CHECKLIST.md  # Checklist de validation backend
├── BACKEND_API.md        # Documentation API pour frontend
└── README.md
```

---

## 🗄️ Base de Données

**Nom** : `mini_event`

### Tables

#### `events`
```sql
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    seats INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL
);
```

#### `reservations`
```sql
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
```

#### `admin`
```sql
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
```

---

## 🚀 Installation

### 1. Cloner le dépôt
```bash
git clone https://github.com/votre-repo/MiniProjet2A-EventReservation-azza-erij-.git
cd MiniProjet2A-EventReservation-azza-erij-
```

### 2. Configurer la base de données

1. Créer la base MySQL :
   ```sql
   CREATE DATABASE mini_event CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Exécuter les tables (voir section "Base de données" ci-dessus)

3. Modifier `/config/database.php` si nécessaire :
   ```php
   $host = "localhost";
   $dbname = "mini_event";
   $user = "root";
   $pass = "";
   ```

### 3. Créer le compte admin

Accéder à : `http://localhost:8000/seed_admin.php`

**Identifiants par défaut** :
- Username : `admin`
- Password : `admin123`



---

## 🧪 Tests Backend

Accéder aux URLs suivantes pour tester le backend :

| Test | URL | Description |
|------|-----|-------------|
| Admin Seed | `/seed_admin.php` | Créer compte admin |
| Admin Auth | `/test_admin.php` | Tester authentification |
| Events CRUD | `/test_event.php` | Tester CRUD événements |
| Reservations | `/test_reservation.php` | Tester réservations |
| Validation | `/test_validation.php` | Tester helpers (Validator, Flash, Upload) |
| Routes | `/test_routes.php` | Visualiser toutes les routes |

**Checklist complète** : Voir [`BACKEND_CHECKLIST.md`](BACKEND_CHECKLIST.md)

---

## 📖 Documentation

- **Backend API** : Voir [`BACKEND_API.md`](BACKEND_API.md) (guide pour intégration frontend)
- **Routes disponibles** : 13 routes (publiques + admin)
- **Validation** : Toutes les données validées côté serveur
- **Sécurité** : Protection XSS, SQLi, upload sécurisé

---

## 🔐 Sécurité

✅ **Mesures implémentées** :
- Protection SQLi : PDO avec requêtes préparées
- Protection XSS : `htmlspecialchars()` + `Validator::clean()`
- Upload sécurisé : Vérification extension + MIME type + taille
- Authentification : Hachage bcrypt avec `password_hash()`
- Sessions sécurisées : Vérification admin avant actions sensibles

---

## 🌐 Routes Principales

### Publiques
- `GET /` → Liste des événements
- `GET /event?id=X` → Détail événement
- `POST /reserve` → Créer réservation

### Admin (authentification requise)
- `GET /admin/login` → Connexion
- `GET /admin` → Dashboard
- `GET /admin/event/new` → Créer événement
- `POST /admin/event/create` → Sauvegarder événement
- `GET /admin/event/edit?id=X` → Éditer événement
- `POST /admin/event/update` → Mettre à jour
- `POST /admin/event/delete` → Supprimer
- `GET /admin/reservations?event_id=X` → Voir réservations
- `GET /admin/logout` → Déconnexion

**Liste complète** : `http://localhost:8000/test_routes.php`

---

## 📦 Livrables


- [x] Models (Event, Reservation, Admin)
- [x] Controllers (EventController, AdminController)
- [x] Helpers (Validator, ImageUploader, Flash)
- [x] Routing system (13 routes)
- [x] Validation côté serveur
- [x] Upload d'images sécurisé
- [x] Tests complets
- [x] Documentation API



---

## 🤝 Workflow Git

**Branches** :
- `main` → Code stable et fonctionnel
- `dev` → Intégration et tests
- `feature/*` → Développement de fonctionnalités

**Commits** :
- Minimum 10 commits par membre
- Messages clairs et descriptifs
- Format : `feat(scope): description`

**Milestones GitHub** :
- [x] Milestone 1 : Base de données + Models
- [x] Milestone 2 : Routing + Controllers
- [x] Milestone 3 : Validation + Sécurité
- [ ] Milestone 4 : Frontend + Intégration
- [ ] Milestone 5 : Tests finaux + Déploiement

---

## 📝 Licence

Projet académique - ISSAT Sousse - 2A GL-03

---

## 📧 Contact

- **Azza** : [azzasalmouk20@gmail.com]
- **Erij** : [erijbenamor6@gmail.com]

---


## Frontend (Views/UI)

Les vues frontend sont dans :
- `app/views/events/` (liste + détails)
- `app/views/admin/` (login, dashboard, form_event, reservations)
- `app/views/partials/` (header/footer)

Assets :
- CSS : `public/css/style.css`
- JS : `public/js/app.js`
- Images : `public/images/`

### Pages Preview (sans backend)
Pour tester l’UI rapidement :
- `/preview_list.php`
- `/preview_details.php`
- `/preview_admin_login.php`
- `/preview_admin_dashboard.php`
- `/preview_admin_form_event.php`
- `/preview_admin_reservations.php`

## Frontend Structure

The frontend follows the MVC pattern with views organized in the `app/views` directory:

```
app/
└── views/
    ├── admin/
    │   ├── dashboard.php       # Admin dashboard with event listing
    │   ├── form_event.php      # Form for creating/editing events
    │   ├── login.php           # Admin login page
    │   └── reservations.php    # View reservations for an event
    ├── events/
    │   ├── details.php         # Event details and reservation form
    │   └── list.php            # List of available events
    └── partials/
        ├── footer.php          # Page footer with JS inclusion
        └── header.php          # Page header with navigation
```

## Frontend Pages

### User Pages
- **Event Listing** (`/`): Displays all available events in a grid layout
- **Event Details** (`/event/{id}`): Shows event details with reservation form
- **Reservation Confirmation**: Success/error messages after form submission

### Admin Pages
- **Admin Login** (`/admin/login`): Secure login for administrators
- **Admin Dashboard** (`/admin`): Overview of all events with CRUD operations
- **Event Creation/Edit** (`/admin/event/new`, `/admin/event/edit?id={id}`): Forms for managing events
- **Reservations View** (`/admin/reservations?event_id={id}`): See all reservations for a specific event

## Frontend Features

### JavaScript Enhancements
Located in `public/js/app.js`:
- Auto-hide success alerts after 3 seconds with fade-out effect
- Confirmation dialog for delete operations
- Client-side validation for reservation forms (name, email, phone)

### CSS Styles
Located in `public/css/style.css`:
- Responsive design for all device sizes
- Accessibility focus styles for keyboard navigation
- Hover effects on interactive elements
- Smooth transitions and animations

### Assets
- CSS: `public/css/style.css`
- JavaScript: `public/js/app.js`
- Images: `public/uploads/`

## Development Utilities
- Preview files for UI testing without backend:
  - `public/preview_list.php`: Event listing preview
  - `public/preview_details.php`: Event details preview

To view these previews, serve the project locally and navigate to the respective URLs.
origin/features/views-ui
