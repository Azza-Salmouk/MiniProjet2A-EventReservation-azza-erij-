# MiniProjet2A-EventReservation-azza-erij-
"Projet de réservation d'événements – 2A GL-03"

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