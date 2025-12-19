# BACKEND CHECKLIST - Tests de validation complète

## ✅ ÉTAPE 1 : MODELS (CRUD)

### Event Model
- [ ] `Event::getAll()` → Retourne tous les événements
- [ ] `Event::getById($id)` → Retourne un événement spécifique
- [ ] `Event::create($data)` → Crée un nouvel événement
- [ ] `Event::update($id, $data)` → Met à jour un événement
- [ ] `Event::delete($id)` → Supprime un événement

**Test URL** : http://localhost:8000/test_event.php

### Reservation Model
- [ ] `Reservation::create($data)` → Crée une réservation
- [ ] `Reservation::getByEvent($event_id)` → Liste les réservations d'un événement

**Test URL** : http://localhost:8000/test_reservation.php

### Admin Model
- [ ] `Admin::login($username, $password)` → Authentification admin
- [ ] Hachage de mot de passe avec `password_verify()`

**Test URL** : http://localhost:8000/test_admin.php

---

## ✅ ÉTAPE 2 : ROUTING SYSTEM

### Routes publiques
- [ ] `GET /` → Liste des événements (EventController@index)
- [ ] `GET /event?id=X` → Détail événement (EventController@show)
- [ ] `POST /reserve` → Créer réservation (EventController@reserve)

### Routes admin
- [ ] `GET /admin/login` → Formulaire login (AdminController@loginForm)
- [ ] `POST /admin/login` → Traitement login (AdminController@login)
- [ ] `GET /admin` → Dashboard (AdminController@dashboard) *auth requis*
- [ ] `GET /admin/event/new` → Formulaire création (AdminController@createForm) *auth requis*
- [ ] `POST /admin/event/create` → Créer événement (AdminController@create) *auth requis*
- [ ] `GET /admin/event/edit?id=X` → Formulaire édition (AdminController@editForm) *auth requis*
- [ ] `POST /admin/event/update` → Mettre à jour (AdminController@update) *auth requis*
- [ ] `POST /admin/event/delete` → Supprimer (AdminController@delete) *auth requis*
- [ ] `GET /admin/reservations?event_id=X` → Liste réservations (AdminController@reservations) *auth requis*
- [ ] `GET /admin/logout` → Déconnexion (AdminController@logout)

**Test URL** : http://localhost:8000/test_routes.php

### Erreurs
- [ ] Route invalide → 404 Page Not Found

---

## ✅ ÉTAPE 3 : VALIDATION & SÉCURITÉ

### Validator Helper
- [ ] `required()` → Champs obligatoires
- [ ] `email()` → Format email valide
- [ ] `minLength()` / `maxLength()` → Longueur
- [ ] `numeric()` / `positive()` → Nombres
- [ ] `date()` / `futureDate()` → Dates
- [ ] `Validator::clean()` → Protection XSS

### ImageUploader Helper
- [ ] Extensions autorisées : jpg, jpeg, png, gif, webp
- [ ] Vérification MIME type
- [ ] Limite de taille : 5MB
- [ ] Noms de fichiers uniques (uniqid)
- [ ] Suppression d'images lors de delete/update
- [ ] Dossier `public/uploads/` créé automatiquement

### Flash Helper
- [ ] `Flash::success()` / `error()` / `warning()` / `info()`
- [ ] Messages stockés en session
- [ ] `Flash::get()` supprime les messages après lecture

**Test URL** : http://localhost:8000/test_validation.php

---

## ✅ ÉTAPE 4 : CONTROLLERS (Logique métier)

### EventController
- [ ] `index()` → Charge la vue liste événements
- [ ] `show()` → Charge la vue détail événement
- [ ] `reserve()` → Validation + création réservation + flash message

### AdminController
- [ ] `loginForm()` → Affiche formulaire login
- [ ] `login()` → Validation + création session + flash message
- [ ] `dashboard()` → Protection auth + liste événements
- [ ] `createForm()` → Protection auth + formulaire vide
- [ ] `create()` → Validation + upload image + création
- [ ] `editForm()` → Protection auth + formulaire pré-rempli
- [ ] `update()` → Validation + gestion image (nouvelle/ancienne)
- [ ] `delete()` → Suppression événement + image associée
- [ ] `reservations()` → Liste réservations d'un événement
- [ ] `logout()` → Destruction session + flash message

---

## ✅ ÉTAPE 5 : SÉCURITÉ

### Protection XSS
- [ ] Tous les inputs utilisent `Validator::clean()` ou `htmlspecialchars()`

### Protection SQLi
- [ ] Tous les models utilisent `PDO::prepare()` avec paramètres

### Sessions sécurisées
- [ ] `session_start()` dans bootstrap.php
- [ ] Vérification `$_SESSION['admin_id']` dans `checkAuth()`

### Upload sécurisé
- [ ] Vérification extension + MIME type
- [ ] Noms de fichiers aléatoires (pas de nom original)
- [ ] Limite de taille respectée

---

## ✅ TESTS FINAUX

### Scénario 1 : Créer un événement (admin)
1. Accéder à `/admin/login`
2. Se connecter (admin/admin123)
3. Aller sur `/admin/event/new`
4. Remplir formulaire + upload image
5. Vérifier : événement créé + image dans `/uploads/`

### Scénario 2 : Réserver un événement (utilisateur)
1. Accéder à `/` (liste événements)
2. Cliquer sur un événement
3. Remplir formulaire réservation
4. Vérifier : réservation enregistrée + message succès

### Scénario 3 : Modifier un événement (admin)
1. Dashboard `/admin`
2. Éditer un événement
3. Changer image
4. Vérifier : ancienne image supprimée + nouvelle uploadée

### Scénario 4 : Supprimer un événement (admin)
1. Dashboard `/admin`
2. Supprimer événement
3. Vérifier : événement + image supprimés

### Scénario 5 : Validation échoue
1. Formulaire réservation avec email invalide
2. Vérifier : message d'erreur + aucune insertion DB

---

## 📊 RÉSUMÉ

**Models** : 3 classes ✅  
**Controllers** : 2 classes ✅  
**Helpers** : 3 classes ✅  
**Routes** : 13 routes ✅  
**Tests** : 5 fichiers ✅  

---

## 🔗 URLS DE TEST

- http://localhost:8000/seed_admin.php (créer admin)
- http://localhost:8000/test_admin.php (test auth)
- http://localhost:8000/test_event.php (test CRUD events)
- http://localhost:8000/test_reservation.php (test reservations)
- http://localhost:8000/test_validation.php (test helpers)
- http://localhost:8000/test_routes.php (voir toutes les routes)

---

## ⚠️ IMPORTANT POUR PERSONNE B (FRONTEND)

Les vues doivent se trouver dans :
- `/app/views/events/list.php` → Liste événements
- `/app/views/events/details.php` → Détail événement
- `/app/views/admin/login.php` → Login admin
- `/app/views/admin/dashboard.php` → Dashboard admin
- `/app/views/admin/form_event.php` → Formulaire création/édition
- `/app/views/admin/reservations.php` → Liste réservations

Les variables disponibles dans les vues :
- `list.php` : `$events` (array)
- `details.php` : `$event` (array)
- `dashboard.php` : `$events` (array)
- `form_event.php` : `$event` (array ou null si création)
- `reservations.php` : `$reservations` (array), `$event` (array)

Messages flash disponibles partout :
```php
<?php
$flashMessages = Flash::get();
foreach ($flashMessages as $msg) {
    echo "<div class='alert-{$msg['type']}'>{$msg['message']}</div>";
}
?>
```

---

**BACKEND COMPLET ET FONCTIONNEL** ✅
