<?php

/**
 * Routes Configuration
 * Format: 'METHOD|PATH' => ['controller' => 'ControllerName', 'action' => 'methodName']
 */

return [
    // === PUBLIC ROUTES (utilisateurs) ===
    
    // Page d'accueil - Liste des événements
    'GET|/' => [
        'controller' => 'EventController',
        'action' => 'index'
    ],
    
    // Détail d'un événement
    'GET|/event' => [
        'controller' => 'EventController',
        'action' => 'show'
    ],
    
    // Traitement réservation (POST)
    'POST|/reserve' => [
        'controller' => 'EventController',
        'action' => 'reserve'
    ],
    
    
    // === ADMIN ROUTES (authentification requise) ===
    
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
    
    // Dashboard admin (liste événements)
    'GET|/admin' => [
        'controller' => 'AdminController',
        'action' => 'dashboard'
    ],
    
    // Formulaire création événement
    'GET|/admin/event/new' => [
        'controller' => 'AdminController',
        'action' => 'createForm'
    ],
    
    // Traitement création événement (POST)
    'POST|/admin/event/create' => [
        'controller' => 'AdminController',
        'action' => 'create'
    ],
    
    // Formulaire édition événement
    'GET|/admin/event/edit' => [
        'controller' => 'AdminController',
        'action' => 'editForm'
    ],
    
    // Traitement mise à jour événement (POST)
    'POST|/admin/event/update' => [
        'controller' => 'AdminController',
        'action' => 'update'
    ],
    
    // Suppression événement (POST)
    'POST|/admin/event/delete' => [
        'controller' => 'AdminController',
        'action' => 'delete'
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
];
