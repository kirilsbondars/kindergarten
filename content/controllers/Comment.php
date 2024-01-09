<?php
class Comment {
    private $id;
    private $text;
    private $user_id;
    private $created_at;

    private $user_full_name;

    public function __construct($id, $text, $user_id, $created_at, $user_full_name) {
        $this->id = $id;
        $this->text = $text;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
        $this->user_full_name = $user_full_name;
    }

    public static function createComment($text, $user_id) {
        $comment = new Comment(null, $text, $user_id, null, null);
        return $comment;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setUserFullName($user_full_name) {
        $this->user_full_name = $user_full_name;
    }

    public function getUserFullName() {
        return $this->user_full_name;
    }

    private static function isUserAllowedToCreateComment($user_id): bool
    {
        $one_week_ago = date('Y-m-d H:i:s', strtotime('-1 week'));
        $stmt = Database::prepare("SELECT COUNT(*) AS comment_count FROM comments WHERE user_id = ? AND created_at >= ?");
        $stmt->bind_param("is", $user_id, $one_week_ago);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['comment_count'] >= 2) {
            return false;
        } else {
            return true;
        }
    }

    public static function getAll($order = "DESC"): array
    {
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'DESC';
        }

        $sql = "SELECT c.id as comment_id, text, user_id, created_at, CONCAT(u.name, ' ', u.surname) as user_full_name FROM comments c
                JOIN users u ON c.user_id = u.id
                ORDER BY created_at " . $order;
        $result = Database::query($sql);

        if ($result === false) {
            die('Error: The SQL query failed.');
        }

        $comments = [];
        while ($c = $result->fetch_assoc()) {
            $comment = new Comment($c["comment_id"], $c["text"], $c["user_id"], $c["created_at"], $c["user_full_name"]);
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function getCommentById($id): ?Comment
    {
        $sql = "SELECT c.id as comment_id, text, user_id, created_at, CONCAT(u.name, ' ', u.surname) as user_full_name FROM comments c
                JOIN users u ON c.user_id = u.id WHERE c.id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $c = $result->fetch_assoc();
            $comment = new Comment($c["comment_id"], $c["text"], $c["user_id"], $c["created_at"], $c["user_full_name"]);
            return $comment;
        } else {
            return null;
        }
    }

    public function create(): bool
    {
        if(!self::isUserAllowedToCreateComment($this->user_id)) {
            throw new Exception('Jums nav atļauts izveidot vairāk nekā 2 komentārus nedēļā.');
        }

        $sql = "INSERT INTO comments (text, user_id) VALUES (?, ?)";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("si", $this->text, $this->user_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE comments SET text = ?, user_id = ? WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("sii", $this->text, $this->user_id, $this->id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}