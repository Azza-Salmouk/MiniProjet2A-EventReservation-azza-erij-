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
}
