<?php

/**
 * Routes Configuration
 * Format: 'METHOD|PATH' => ['controller' => 'ControllerName', 'action' => 'methodName']
 * Note: More specific routes should come before general ones to avoid conflicts
 */

return [
    // === ADMIN ROUTES (authentification requise) ===
    
    // Dashboard admin (overview only)
    'GET|/admin' => [
        'controller' => 'AdminController',
        'action' => 'dashboard'
    ],
    
    // Liste complète des événements admin
    'GET|/admin/events' => [
        'controller' => 'AdminController',
        'action' => 'listEvents'
    ],
    
    // Formulaire création événement - Standardisé: /admin/events/new
    'GET|/admin/events/new' => [
        'controller' => 'AdminController',
        'action' => 'createForm'
    ],
    
    // Formulaire édition événement - Standardisé: /admin/events/edit/1
    'GET|/admin/events/edit/{id}' => [
        'controller' => 'AdminController',
        'action' => 'editForm'
    ],
    
    // Alias pour compatibilité - REST style
    'GET|/admin/events/{id}/edit' => [
        'controller' => 'AdminController',
        'action' => 'editForm'
    ],
    
    // Traitement création événement (POST) - Standardisé: /admin/events
    'POST|/admin/events' => [
        'controller' => 'AdminController',
        'action' => 'create'
    ],
    
    // Traitement mise à jour événement (POST) - Standardisé: /admin/events/1
    'POST|/admin/events/{id}' => [
        'controller' => 'AdminController',
        'action' => 'update'
    ],
    
    // Suppression événement (POST) - Standardisé: /admin/events/1/delete
    'POST|/admin/events/{id}/delete' => [
        'controller' => 'AdminController',
        'action' => 'delete'
    ],
    
    // Alias pour compatibilité - format alternatif
    'POST|/admin/events/delete/{id}' => [
        'controller' => 'AdminController',
        'action' => 'delete'
    ],
    
    // Formulaire de connexion admin
    'GET|/admin/login' => [
        'controller' => 'AdminController',
        'action' => 'loginForm'
    ],
    
    // Traitement connexion admin (POST)
    'POST|/admin/login' => [
        'controller' => 'AdminController',
        'action' => 'login'
    ],
    
    // Liste des réservations pour un événement
    'GET|/admin/reservations' => [
        'controller' => 'AdminController',
        'action' => 'reservations'
    ],
    
    // Déconnexion admin
    'GET|/admin/logout' => [
        'controller' => 'AdminController',
        'action' => 'logout'
    ],
    
    
    // === PUBLIC ROUTES (utilisateurs) ===
    
    // Page d'accueil - Liste des événements
    'GET|/' => [
        'controller' => 'EventController',
        'action' => 'index'
    ],
    
    // Détail d'un événement - Format 1: /event?id=1
    'GET|/event' => [
        'controller' => 'EventController',
        'action' => 'show'
    ],
    
    // Détail d'un événement - Format 2: /event/1
    'GET|/event/{id}' => [
        'controller' => 'EventController',
        'action' => 'show'
    ],
    
    // Traitement réservation (POST)
    'POST|/reserve' => [
        'controller' => 'EventController',
        'action' => 'reserve'
    ],
];