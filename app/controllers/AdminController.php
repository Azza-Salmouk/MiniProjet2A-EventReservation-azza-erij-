<?php
require_once ROOT . '/app/models/Event.php';
require_once ROOT . '/app/models/Reservation.php';
require_once ROOT . '/app/models/Admin.php';


class AdminController {

    private function checkAuth() {
        requireAdmin();
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
        
        // Get statistics
        $totalEvents = Event::getAll();
        $totalEvents = count($totalEvents);
        
        $stmt = db()->query("SELECT COUNT(*) as count FROM reservations");
        $totalReservations = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        $stmt = db()->query("SELECT SUM(seats) as total_seats FROM events");
        $totalSeats = $stmt->fetch(PDO::FETCH_ASSOC)['total_seats'] ?? 0;
        
        $stmt = db()->query("SELECT COUNT(*) as count FROM reservations");
        $reservedSeats = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
        
        $seatsRemaining = $totalSeats - $reservedSeats;
        
        // Get recent events (last 3)
        $events = Event::getRecent(3);
        
        require ROOT . '/app/views/admin/dashboard.php';
    }

    public function listEvents() {
        $this->checkAuth();
        $events = Event::getAll();
        require ROOT . '/app/views/admin/list_events.php';
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
        
        // Handle datetime-local format conversion
        $eventDate = $_POST['event_date'] ?? '';
        if (!empty($eventDate)) {
            // Convert datetime-local format (YYYY-MM-DDTHH:MM) to MySQL datetime (YYYY-MM-DD HH:MM:SS)
            $eventDate = str_replace('T', ' ', $eventDate) . ':00';
            // Validate the converted date
            $validator->date('event_date', $eventDate, 'Event date');
            $validator->futureDate('event_date', $eventDate, 'Event date');
        }
        
        if (!empty($_POST['seats'])) {
            $validator->numeric('seats', $_POST['seats'], 'Seats');
            $validator->positive('seats', $_POST['seats'], 'Seats');
        }
        
        if ($validator->hasErrors()) {
            $_SESSION['form_errors'] = $validator->getErrors();
            $_SESSION['form_data'] = $_POST;
            Flash::error('Please fix the validation errors.');
            header("Location: /admin/events/new");
            exit;
        }
        
        // Upload image
        $uploader = new ImageUploader();
        $imageName = null;
        
        // Check if file was uploaded and handle errors properly
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imageName = $uploader->upload($_FILES['image']);
            
            if ($uploader->hasError()) {
                Flash::error('Image upload failed: ' . $uploader->getError());
                header("Location: /admin/events/new");
                exit;
            }
        }
        
        // Créer l'événement
        try {
            Event::create([
                'title' => Validator::clean($_POST['title']),
                'description' => Validator::clean($_POST['description']),
                'event_date' => $eventDate, // Use the converted date
                'location' => Validator::clean($_POST['location']),
                'seats' => (int)$_POST['seats'],
                'image' => $imageName
            ]);
            
            Flash::success('✅ Event created successfully');
            header("Location: /admin/events");
        } catch (Exception $e) {
            Flash::error('❌ Failed to create event: ' . $e->getMessage());
            header("Location: /admin/events/new");
        }
        
        exit;
    }

    public function editForm() {
        $this->checkAuth();
        
        // Get ID from route parameter (standardized route: /admin/events/edit/{id})
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: /admin/events");
            exit;
        }
        
        $event = Event::getById($id);
        
        if (!$event) {
            header("Location: /admin/events?error=event_not_found");
            exit;
        }
        
        require ROOT . '/app/views/admin/form_event.php';
    }

    public function update() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/events");
            exit;
        }
        
        // Get ID from route parameter (standardized route: /admin/events/{id})
        $eventId = $_GET['id'] ?? null;
        
        if (!$eventId) {
            Flash::error('Event ID is missing.');
            header("Location: /admin/events");
            exit;
        }
        
        // Vérifier que l'événement existe
        $existingEvent = Event::getById($eventId);
        if (!$existingEvent) {
            Flash::error('Event not found.');
            header("Location: /admin/events");
            exit;
        }
        
        // Validation
        $validator = new Validator();
        
        $validator->required('title', $_POST['title'] ?? '', 'Title');
        $validator->required('description', $_POST['description'] ?? '', 'Description');
        $validator->required('event_date', $_POST['event_date'] ?? '', 'Event date');
        $validator->required('location', $_POST['location'] ?? '', 'Location');
        $validator->required('seats', $_POST['seats'] ?? '', 'Seats');
        
        // Handle datetime-local format conversion
        $eventDate = $_POST['event_date'] ?? '';
        if (!empty($eventDate)) {
            // Convert datetime-local format (YYYY-MM-DDTHH:MM) to MySQL datetime (YYYY-MM-DD HH:MM:SS)
            $eventDate = str_replace('T', ' ', $eventDate) . ':00';
            // Validate the converted date
            $validator->date('event_date', $eventDate, 'Event date');
        }
        
        if (!empty($_POST['seats'])) {
            $validator->numeric('seats', $_POST['seats'], 'Seats');
            $validator->positive('seats', $_POST['seats'], 'Seats');
        }
        
        if ($validator->hasErrors()) {
            $_SESSION['form_errors'] = $validator->getErrors();
            $_SESSION['form_data'] = $_POST;
            Flash::error('Please fix the validation errors.');
            header("Location: /admin/events/edit/" . $eventId);
            exit;
        }
        
        // Gestion image (nouvelle ou conserver ancienne)
        $imageName = $existingEvent['image']; // Par défaut, conserver l'ancienne
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new ImageUploader();
            $newImage = $uploader->upload($_FILES['image']);
            
            if ($uploader->hasError()) {
                Flash::error('Image upload failed: ' . $uploader->getError());
                header("Location: /admin/events/edit/" . $eventId);
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
                'event_date' => $eventDate, // Use the converted date
                'location' => Validator::clean($_POST['location']),
                'seats' => (int)$_POST['seats'],
                'image' => $imageName
            ]);
            
            Flash::success('✅ Event updated successfully!');
            header("Location: /admin/events");
        } catch (Exception $e) {
            Flash::error('❌ Failed to update event: ' . $e->getMessage());
            header("Location: /admin/events/edit/" . $eventId);
        }
        
        exit;
    }

    public function delete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/events");
            exit;
        }
        
        // Get ID from route parameter (standardized route: /admin/events/{id}/delete)
        $eventId = $_GET['id'] ?? null;
        
        if (!$eventId) {
            Flash::error('Event ID is missing.');
            header("Location: /admin/events");
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
            Flash::success('✅ Event deleted successfully!');
        } catch (Exception $e) {
            Flash::error('❌ Failed to delete event: ' . $e->getMessage());
        }
        
        header("Location: /admin/events");
        exit;
    }

    public function reservations() {
        $this->checkAuth();
        
        // Get parameters
        $event_id = $_GET['event_id'] ?? null;
        $searchTerm = $_GET['q'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 10;
        
        // If no event_id is provided, show list of events to choose from
        if (empty($event_id)) {
            $events = Event::getAll();
            require ROOT . '/app/views/admin/reservations_list.php';
            return;
        }
        
        $event = Event::getById($event_id);
        
        // Get paginated reservations
        $paginationData = Reservation::getPaginatedByEvent($event_id, $searchTerm, $page, $perPage);
        $reservations = $paginationData['rows'];
        $totalCount = $paginationData['total_count'];
        $totalPages = ceil($totalCount / $perPage);
        
        require ROOT . '/app/views/admin/reservations.php';
    }

    public function logout() {
        session_destroy();
        Flash::info('You have been logged out.');
        header("Location: /admin/login");
        exit;
    }
}