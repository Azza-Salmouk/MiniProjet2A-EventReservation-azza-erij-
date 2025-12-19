<?php

class Event {

    public static function getAll() {
        $stmt = db()->query("SELECT * FROM events ORDER BY event_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRecent($limit = 3) {
        $stmt = db()->prepare("SELECT * FROM events ORDER BY event_date DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $stmt = db()->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $stmt = db()->prepare("
            INSERT INTO events (title, description, event_date, location, seats, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['event_date'],
            $data['location'],
            $data['seats'],
            $data['image']
        ]);
    }

    public static function update($id, $data) {
        $stmt = db()->prepare("
            UPDATE events
            SET title=?, description=?, event_date=?, location=?, seats=?, image=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['event_date'],
            $data['location'],
            $data['seats'],
            $data['image'],
            $id
        ]);
    }

    public static function delete($id) {
        $stmt = db()->prepare("DELETE FROM events WHERE id=?");
        return $stmt->execute([$id]);
    }
}