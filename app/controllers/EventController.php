<?php
require_once ROOT . "/app/models/Event.php";
require_once ROOT . "/app/models/Reservation.php";

class EventController {
    public function index() {
        $events = Event::getAll();
        require ROOT . "/app/views/events/list.php";
    }

    public function show() {
        // Support both ?id=1 and /event/1 formats
        $id = $_GET['id'] ?? $_GET['event_id'] ?? null;
        
        if (!$id) {
            header("Location: /");
            exit;
        }

        $event = Event::getById($id);
        require ROOT . "/app/views/events/details.php";
    }

    public function reserve() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /");
            exit;
        }
        
        // Validation
        $validator = new Validator();
        
        $validator->required('event_id', $_POST['event_id'] ?? '');
        $validator->required('name', $_POST['name'] ?? '', 'Name');
        $validator->required('email', $_POST['email'] ?? '', 'Email');
        $validator->required('phone', $_POST['phone'] ?? '', 'Phone');
        
        if (!empty($_POST['email'])) {
            $validator->email('email', $_POST['email']);
        }
        
        if (!empty($_POST['name'])) {
            $validator->minLength('name', $_POST['name'], 2, 'Name');
        }
        
        // Si erreurs de validation
        if ($validator->hasErrors()) {
            $errors = $validator->getErrors();
            Flash::error('Validation failed: ' . implode(', ', $errors));
            header("Location: /event?id=" . ($_POST['event_id'] ?? ''));
            exit;
        }
        
        // Vérifier que l'événement existe
        $event = Event::getById($_POST['event_id']);
        if (!$event) {
            Flash::error('Event not found.');
            header("Location: /");
            exit;
        }
        
        // Créer la réservation
        try {
            Reservation::create([
                'event_id' => Validator::clean($_POST['event_id']),
                'name' => Validator::clean($_POST['name']),
                'email' => Validator::clean($_POST['email']),
                'phone' => Validator::clean($_POST['phone']),
            ]);
            
            Flash::success('Reservation successful! See you at the event.');
            header("Location: /event?id=" . $_POST['event_id']);
        } catch (Exception $e) {
            Flash::error('Reservation failed. Please try again.');
            header("Location: /event?id=" . $_POST['event_id']);
        }
        
        exit;
    }
}