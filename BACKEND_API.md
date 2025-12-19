# BACKEND API DOCUMENTATION
## Guide d'intégration pour le Frontend (Personne B)

---

## 📂 STRUCTURE DES VUES ATTENDUES

Créer ces fichiers dans `/app/views/` :

```
/app/views/
├── events/
│   ├── list.php          # Liste des événements (page d'accueil)
│   └── details.php       # Détail d'un événement + formulaire réservation
├── admin/
│   ├── login.php         # Formulaire de connexion admin
│   ├── dashboard.php     # Dashboard admin (liste événements)
│   ├── form_event.php    # Formulaire création/édition événement
│   └── reservations.php  # Liste des réservations par événement
└── partials/
    ├── header.php        # En-tête commun
    └── footer.php        # Pied de page commun
```

---

## 🔗 ROUTES DISPONIBLES

### Routes Publiques (Utilisateurs)

#### 1. Page d'accueil - Liste des événements
**URL** : `GET /`  
**Controller** : EventController@index  
**Variables disponibles dans la vue** :
```php
$events = [
    [
        'id' => 1,
        'title' => 'Concert Jazz',
        'description' => 'Soirée jazz...',
        'event_date' => '2025-12-20 19:00:00',
        'location' => 'Sousse, Tunisia',
        'seats' => 100,
        'image' => 'event_xxx.jpg' // ou null
    ],
    // ...
];
```
**Vue à créer** : `/app/views/events/list.php`

---

#### 2. Détail d'un événement
**URL** : `GET /event?id=1`  
**Controller** : EventController@show  
**Variables disponibles** :
```php
$event = [
    'id' => 1,
    'title' => 'Concert Jazz',
    'description' => 'Description complète...',
    'event_date' => '2025-12-20 19:00:00',
    'location' => 'Sousse, Tunisia',
    'seats' => 100,
    'image' => 'event_xxx.jpg'
];
```
**Vue à créer** : `/app/views/events/details.php`

**Formulaire de réservation attendu** :
```html
<form action="/reserve" method="POST">
    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
    
    <input type="text" name="name" placeholder="Nom complet" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="tel" name="phone" placeholder="Téléphone" required>
    
    <button type="submit">Réserver</button>
</form>
```

---

#### 3. Traitement réservation
**URL** : `POST /reserve`  
**Controller** : EventController@reserve  
**Champs requis** :
- `event_id` (hidden)
- `name` (min 2 caractères)
- `email` (format email valide)
- `phone`

**Validation backend** :
- ✅ Tous les champs obligatoires
- ✅ Email valide
- ✅ Événement existe

**Redirections** :
- ✅ Succès → `/event?id=X` avec message `Flash::success()`
- ❌ Erreur → `/event?id=X` avec message `Flash::error()`

---

### Routes Admin (Authentification requise)

#### 4. Formulaire de connexion admin
**URL** : `GET /admin/login`  
**Controller** : AdminController@loginForm  
**Vue à créer** : `/app/views/admin/login.php`

**Formulaire attendu** :
```html
<form action="/admin/login" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Se connecter</button>
</form>
```

**Identifiants par défaut** :
- Username : `admin`
- Password : `admin123`

---

#### 5. Traitement connexion
**URL** : `POST /admin/login`  
**Controller** : AdminController@login  
**Redirections** :
- ✅ Succès → `/admin` (dashboard) + `$_SESSION['admin_id']` définie
- ❌ Échec → `/admin/login` avec `Flash::error('Invalid credentials.')`

---

#### 6. Dashboard admin
**URL** : `GET /admin`  
**Controller** : AdminController@dashboard  
**Variables disponibles** :
```php
$events = [ /* même structure que liste publique */ ];
$_SESSION['admin_username'] = 'admin';
```
**Vue à créer** : `/app/views/admin/dashboard.php`

**Actions possibles** :
- Bouton "Créer événement" → `/admin/event/new`
- Bouton "Modifier" → `/admin/event/edit?id=X`
- Bouton "Supprimer" → `POST /admin/event/delete` (formulaire avec `id`)
- Bouton "Voir réservations" → `/admin/reservations?event_id=X`
- Bouton "Déconnexion" → `/admin/logout`

---

#### 7. Formulaire création événement
**URL** : `GET /admin/event/new`  
**Controller** : AdminController@createForm  
**Variables disponibles** :
```php
$event = null; // Création (pas d'édition)
```
**Vue à créer** : `/app/views/admin/form_event.php`

**Formulaire attendu** :
```html
<form action="/admin/event/create" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Titre" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="datetime-local" name="event_date" required>
    <input type="text" name="location" placeholder="Lieu" required>
    <input type="number" name="seats" min="0" placeholder="Places" required>
    <input type="file" name="image" accept="image/*">
    
    <button type="submit">Créer</button>
</form>
```

**Validation backend** :
- ✅ Tous les champs obligatoires (sauf image)
- ✅ Date future
- ✅ Seats >= 0
- ✅ Image : jpg/jpeg/png/gif/webp, max 5MB

---

#### 8. Formulaire édition événement
**URL** : `GET /admin/event/edit?id=1`  
**Controller** : AdminController@editForm  
**Variables disponibles** :
```php
$event = [
    'id' => 1,
    'title' => 'Concert Jazz',
    'description' => '...',
    'event_date' => '2025-12-20 19:00:00',
    'location' => 'Sousse',
    'seats' => 100,
    'image' => 'event_xxx.jpg'
];
```
**Vue à créer** : Réutiliser `/app/views/admin/form_event.php`

**Formulaire attendu** :
```html
<form action="/admin/event/update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $event['id'] ?>">
    
    <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
    <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>
    
    <!-- Convertir datetime pour input datetime-local -->
    <?php $dateForInput = date('Y-m-d\TH:i', strtotime($event['event_date'])); ?>
    <input type="datetime-local" name="event_date" value="<?= $dateForInput ?>" required>
    
    <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>
    <input type="number" name="seats" value="<?= $event['seats'] ?>" min="0" required>
    
    <?php if ($event['image']): ?>
        <p>Image actuelle : <img src="/uploads/<?= $event['image'] ?>" width="100"></p>
    <?php endif; ?>
    <input type="file" name="image" accept="image/*">
    <small>Laisser vide pour conserver l'image actuelle</small>
    
    <button type="submit">Mettre à jour</button>
</form>
```

**Note** : Si aucune nouvelle image, l'ancienne est conservée.

---

#### 9. Suppression événement
**URL** : `POST /admin/event/delete`  
**Controller** : AdminController@delete  
**Formulaire attendu** (dans dashboard) :
```html
<form action="/admin/event/delete" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
    <input type="hidden" name="id" value="<?= $event['id'] ?>">
    <button type="submit">Supprimer</button>
</form>
```

**Backend** : Supprime l'événement + son image

---

#### 10. Liste des réservations
**URL** : `GET /admin/reservations?event_id=1`  
**Controller** : AdminController@reservations  
**Variables disponibles** :
```php
$event = [ /* infos événement */ ];
$reservations = [
    [
        'id' => 1,
        'event_id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+216 12345678',
        'created_at' => '2025-12-14 10:30:00'
    ],
    // ...
];
```
**Vue à créer** : `/app/views/admin/reservations.php`

---

#### 11. Déconnexion
**URL** : `GET /admin/logout`  
**Controller** : AdminController@logout  
**Action** : Détruit la session + redirige vers `/admin/login`

---

## 💬 FLASH MESSAGES

**Dans toutes les vues**, afficher les messages flash :

```php
<?php
$flashMessages = Flash::get();
if (!empty($flashMessages)):
    foreach ($flashMessages as $msg):
        $class = 'alert-' . $msg['type']; // success, error, warning, info
?>
    <div class="alert <?= $class ?>">
        <?= htmlspecialchars($msg['message']) ?>
    </div>
<?php
    endforeach;
endif;
?>
```

**Types de messages** :
- `success` → Vert (réservation réussie, événement créé, etc.)
- `error` → Rouge (validation échouée, erreur système)
- `warning` → Orange (avertissements)
- `info` → Bleu (déconnexion, informations)

---

## 🖼️ AFFICHAGE DES IMAGES

**URL des images** : `/uploads/nom_fichier.jpg`

```html
<?php if ($event['image']): ?>
    <img src="/uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
<?php else: ?>
    <img src="/images/placeholder.jpg" alt="Pas d'image">
<?php endif; ?>
```

---

## 🔒 PROTECTION DANS LES VUES

**Toujours échapper les données** :
```php
<?= htmlspecialchars($event['title']) ?>
```

**Vérifier les sessions admin** (dans les vues admin) :
```php
<?php if (!isset($_SESSION['admin_id'])): ?>
    <p>Non autorisé</p>
    <?php exit; ?>
<?php endif; ?>
```
*(Note : Le backend gère déjà cette protection, mais bonne pratique)*

---

## 📅 FORMATAGE DES DATES

**Afficher date lisible** :
```php
<?php
$date = new DateTime($event['event_date']);
echo $date->format('d/m/Y à H:i'); // 20/12/2025 à 19:00
?>
```

---

## ✅ EXEMPLE COMPLET : details.php

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['title']) ?></title>
</head>
<body>
    <!-- Flash Messages -->
    <?php
    $flashMessages = Flash::get();
    foreach ($flashMessages as $msg):
    ?>
        <div class="alert-<?= $msg['type'] ?>">
            <?= htmlspecialchars($msg['message']) ?>
        </div>
    <?php endforeach; ?>

    <!-- Détail événement -->
    <h1><?= htmlspecialchars($event['title']) ?></h1>
    
    <?php if ($event['image']): ?>
        <img src="/uploads/<?= htmlspecialchars($event['image']) ?>" alt="">
    <?php endif; ?>
    
    <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
    <p>Date : <?= (new DateTime($event['event_date']))->format('d/m/Y à H:i') ?></p>
    <p>Lieu : <?= htmlspecialchars($event['location']) ?></p>
    <p>Places disponibles : <?= $event['seats'] ?></p>

    <!-- Formulaire réservation -->
    <h2>Réserver</h2>
    <form action="/reserve" method="POST">
        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        
        <input type="text" name="name" placeholder="Nom complet" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Téléphone" required>
        
        <button type="submit">Réserver</button>
    </form>
</body>
</html>
```

---

## 🔗 LIENS UTILES

**Tests backend** :
- http://localhost:8000/test_routes.php (voir toutes les routes)
- http://localhost:8000/test_validation.php (helpers)

**Identifiants admin** :
- Username : `admin`
- Password : `admin123`

---

**BACKEND PRÊT POUR INTÉGRATION FRONTEND** ✅
