<?php
require_once ROOT . '/app/models/Event.php';
require_once ROOT . '/app/models/Reservation.php';
require_once ROOT . '/app/models/Admin.php';


class AdminController {

    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: /admin/login");
            exit;
        }
    }

    public function loginForm() {
        require ROOT . '/app/views/admin/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/login");
            exit;
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            Flash::error('Username and password are required.');
            header("Location: /admin/login");
            exit;
        }
        
        $admin = Admin::login($username, $password);

        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            Flash::success('Welcome back, ' . $admin['username'] . '!');
            header("Location: /admin");
        } else {
            Flash::error('Invalid credentials.');
            header("Location: /admin/login");
        }
        
        exit;
    }

    public function dashboard() {
        $this->checkAuth();
        $events = Event::getAll();
        require ROOT . '/app/views/admin/dashboard.php';
    }

    public function createForm() {
        $this->checkAuth();
        require ROOT . '/app/views/admin/form_event.php';
    }

    public function create() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin");
            exit;
        }
        
        // Validation
        $validator = new Validator();
        
        $validator->required('title', $_POST['title'] ?? '', 'Title');
        $validator->required('description', $_POST['description'] ?? '', 'Description');
        $validator->required('event_date', $_POST['event_date'] ?? '', 'Event date');
        $validator->required('location', $_POST['location'] ?? '', 'Location');
        $validator->required('seats', $_POST['seats'] ?? '', 'Seats');
        
        if (!empty($_POST['event_date'])) {
            $validator->date('event_date', $_POST['event_date'], 'Event date');
            $validator->futureDate('event_date', $_POST['event_date'], 'Event date');
        }
        
        if (!empty($_POST['seats'])) {
            $validator->numeric('seats', $_POST['seats'], 'Seats');
            $validator->positive('seats', $_POST['seats'], 'Seats');
        }
        
        if ($validator->hasErrors()) {
            $_SESSION['form_errors'] = $validator->getErrors();
            $_SESSION['form_data'] = $_POST;
            Flash::error('Please fix the validation errors.');
            header("Location: /admin/event/new");
            exit;
        }
        
        // Upload image
        $uploader = new ImageUploader();
        $imageName = null;
        
        if (isset($_FILES['image'])) {
            $imageName = $uploader->upload($_FILES['image']);
            
            if ($uploader->hasError()) {
                Flash::error('Image upload failed: ' . $uploader->getError());
                header("Location: /admin/event/new");
                exit;
            }
        }
        
        // Créer l'événement
        try {
            Event::create([
                'title' => Validator::clean($_POST['title']),
                'description' => Validator::clean($_POST['description']),
                'event_date' => $_POST['event_date'],
                'location' => Validator::clean($_POST['location']),
                'seats' => (int)$_POST['seats'],
                'image' => $imageName
            ]);
            
            Flash::success('Event created successfully!');
            header("Location: /admin");
        } catch (Exception $e) {
            Flash::error('Failed to create event.');
            header("Location: /admin/event/new");
        }
        
        exit;
    }

    public function editForm() {
        $this->checkAuth();
        
        if (!isset($_GET['id'])) {
            header("Location: /admin");
            exit;
        }
        
        $event = Event::getById($_GET['id']);
        
        if (!$event) {
            header("Location: /admin?error=event_not_found");
            exit;
        }
        
        require ROOT . '/app/views/admin/form_event.php';
    }

    public function update() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin");
            exit;
        }
        
        $eventId = $_POST['id'] ?? null;
        
        if (!$eventId) {
            Flash::error('Event ID is missing.');
            header("Location: /admin");
            exit;
        }
        
        // Vérifier que l'événement existe
        $existingEvent = Event::getById($eventId);
        if (!$existingEvent) {
            Flash::error('Event not found.');
            header("Location: /admin");
            exit;
        }
        
        // Validation
        $validator = new Validator();
        
        $validator->required('title', $_POST['title'] ?? '', 'Title');
        $validator->required('description', $_POST['description'] ?? '', 'Description');
        $validator->required('event_date', $_POST['event_date'] ?? '', 'Event date');
        $validator->required('location', $_POST['location'] ?? '', 'Location');
        $validator->required('seats', $_POST['seats'] ?? '', 'Seats');
        
        if (!empty($_POST['event_date'])) {
            $validator->date('event_date', $_POST['event_date'], 'Event date');
        }
        
        if (!empty($_POST['seats'])) {
            $validator->numeric('seats', $_POST['seats'], 'Seats');
            $validator->positive('seats', $_POST['seats'], 'Seats');
        }
        
        if ($validator->hasErrors()) {
            $_SESSION['form_errors'] = $validator->getErrors();
            $_SESSION['form_data'] = $_POST;
            Flash::error('Please fix the validation errors.');
            header("Location: /admin/event/edit?id=" . $eventId);
            exit;
        }
        
        // Gestion image (nouvelle ou conserver ancienne)
        $imageName = $existingEvent['image']; // Par défaut, conserver l'ancienne
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new ImageUploader();
            $newImage = $uploader->upload($_FILES['image']);
            
            if ($uploader->hasError()) {
                Flash::error('Image upload failed: ' . $uploader->getError());
                header("Location: /admin/event/edit?id=" . $eventId);
                exit;
            }
            
            // Supprimer ancienne image si nouvelle uploadée
            if ($newImage && $existingEvent['image']) {
                $uploader->delete($existingEvent['image']);
            }
            
            $imageName = $newImage;
        }
        
        // Mettre à jour l'événement
        try {
            Event::update($eventId, [
                'title' => Validator::clean($_POST['title']),
                'description' => Validator::clean($_POST['description']),
                'event_date' => $_POST['event_date'],
                'location' => Validator::clean($_POST['location']),
                'seats' => (int)$_POST['seats'],
                'image' => $imageName
            ]);
            
            Flash::success('Event updated successfully!');
            header("Location: /admin");
        } catch (Exception $e) {
            Flash::error('Failed to update event.');
            header("Location: /admin/event/edit?id=" . $eventId);
        }
        
        exit;
    }

    public function delete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin");
            exit;
        }
        
        $eventId = $_POST['id'] ?? null;
        
        if (!$eventId) {
            Flash::error('Event ID is missing.');
            header("Location: /admin");
            exit;
        }
        
        // Récupérer l'événement pour supprimer l'image
        $event = Event::getById($eventId);
        
        if ($event && $event['image']) {
            $uploader = new ImageUploader();
            $uploader->delete($event['image']);
        }
        
        // Supprimer l'événement
        try {
            Event::delete($eventId);
            Flash::success('Event deleted successfully!');
        } catch (Exception $e) {
            Flash::error('Failed to delete event.');
        }
        
        header("Location: /admin");
        exit;
    }

    public function reservations() {
        $this->checkAuth();
        
        if (!isset($_GET['event_id'])) {
            header("Location: /admin");
            exit;
        }
        
        $event = Event::getById($_GET['event_id']);
        $reservations = Reservation::getByEvent($_GET['event_id']);
        
        require ROOT . '/app/views/admin/reservations.php';
    }

    public function logout() {
        session_destroy();
        Flash::info('You have been logged out.');
        header("Location: /admin/login");
        exit;
    }
}
