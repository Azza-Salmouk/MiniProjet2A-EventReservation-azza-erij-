<?php

class Reservation {

    public static function create($data) {
        $stmt = db()->prepare("
            INSERT INTO reservations (event_id, name, email, phone)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['event_id'],
            $data['name'],
            $data['email'],
            $data['phone']
        ]);
    }

    public static function getByEvent($event_id) {
        $stmt = db()->prepare("
            SELECT * FROM reservations
            WHERE event_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$event_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function searchByEvent($event_id, $search_term) {
        $stmt = db()->prepare("
            SELECT * FROM reservations
            WHERE event_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)
            ORDER BY created_at DESC
        ");
        $search_term = '%' . $search_term . '%';
        $stmt->execute([$event_id, $search_term, $search_term, $search_term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getPaginatedByEvent($event_id, $search_term = '', $page = 1, $per_page = 10) {
        $offset = ($page - 1) * $per_page;
        
        // Build query based on whether we have a search term
        if (!empty($search_term)) {
            $stmt = db()->prepare("
                SELECT * FROM reservations
                WHERE event_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?
            ");
            
            $search_term_param = '%' . $search_term . '%';
            $stmt->bindValue(1, $event_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $search_term_param, PDO::PARAM_STR);
            $stmt->bindValue(3, $search_term_param, PDO::PARAM_STR);
            $stmt->bindValue(4, $search_term_param, PDO::PARAM_STR);
            $stmt->bindValue(5, $per_page, PDO::PARAM_INT);
            $stmt->bindValue(6, $offset, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = db()->prepare("
                SELECT * FROM reservations
                WHERE event_id = ?
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?
            ");
            
            $stmt->bindValue(1, $event_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $per_page, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get total count for pagination
        if (!empty($search_term)) {
            $countStmt = db()->prepare("
                SELECT COUNT(*) as total FROM reservations
                WHERE event_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)
            ");
            
            $search_term_param = '%' . $search_term . '%';
            $countStmt->execute([$event_id, $search_term_param, $search_term_param, $search_term_param]);
        } else {
            $countStmt = db()->prepare("
                SELECT COUNT(*) as total FROM reservations
                WHERE event_id = ?
            ");
            $countStmt->execute([$event_id]);
        }
        
        $total_count = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return [
            'rows' => $rows,
            'total_count' => $total_count
        ];
    }
    
    public static function getAll() {
        $stmt = db()->query("
            SELECT r.*, e.title as event_title 
            FROM reservations r
            LEFT JOIN events e ON r.event_id = e.id
            ORDER BY r.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function searchAll($search_term) {
        $stmt = db()->prepare("
            SELECT r.*, e.title as event_title 
            FROM reservations r
            LEFT JOIN events e ON r.event_id = e.id
            WHERE r.name LIKE ? OR r.email LIKE ? OR r.phone LIKE ? OR e.title LIKE ?
            ORDER BY r.created_at DESC
        ");
        $search_term = '%' . $search_term . '%';
        $stmt->execute([$search_term, $search_term, $search_term, $search_term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}