<?php

class News {
    private $id;
    private $title;
    private $image;
    private $description;
    private $created_at;

    public function __construct($id, $title, $image, $description, $created_at) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->created_at = $created_at;
    }

    public static function createNews($title, $image, $description) {
        $news = new News(null, $title, $image, $description, null);
        return $news;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getImage() {
        return $this->image;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function shortDescription() {
        return substr($this->description, 0, 200) . '...';
    }

    public static function get_all($search = null, $order = 'DESC') {
        $sql = "SELECT * FROM news";
        if ($search) {
            $search = '%' . $search . '%';
            $sql .= " WHERE title LIKE ? OR description LIKE ?";
        }
        $sql .= " ORDER BY created_at " . $order;
        $stmt = Database::prepare($sql);
        if ($search) {
            $stmt->bind_param("ss", $search, $search);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $news_objects = [];
        while ($news_item = $result->fetch_assoc()) {
            $news = new News($news_item['id'], $news_item['title'], $news_item['image'],
                $news_item['description'], $news_item['created_at']);
            $news_objects[] = $news;
        }

        return $news_objects;
    }
    public static function get_news_by_id($id) {
        $sql = "SELECT * FROM news WHERE id = $id";
        $result = Database::query($sql);

        if ($result->num_rows > 0) {
            $news_item = $result->fetch_assoc();
            $news = new News($news_item['id'], $news_item['title'], $news_item['image'],
                $news_item['description'], $news_item['created_at']);
            return $news;
        } else {
            return null;
        }
    }

    public function create(): bool
    {
        $sql = "INSERT INTO news (title, image, description) VALUES (?, ?, ?)";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("sss", $this->title, $this->image, $this->description);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("i", $this->id);
        $deleteSuccessful = $stmt->execute();

        if ($deleteSuccessful) {
            $this->delete_image();
        }

        return $deleteSuccessful;
    }

    public function delete_image(): void
    {
        $imagePath = IMAGE_DIR . $this->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function update(): bool
    {
        $sql = "UPDATE news SET title = ?, image = ?, description = ? WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("sssi", $this->title, $this->image, $this->description, $this->id);
        return $stmt->execute();
    }
}