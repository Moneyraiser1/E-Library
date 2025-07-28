   <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../Model/Database.php";

class DownloadRecord {
    private $db;
      public function __construct() {
        $this->db = new Database();
    }
   public function showDownload() {
        $this->db->query("SELECT downloads.*, books.title, books.author_name, books.isbn, category.category AS category, user.username
            FROM downloads
            INNER JOIN books ON books.id = downloads.book_id
            INNER JOIN category ON category.id = books.category_id
            INNER JOIN user ON user.id = downloads.user_id
            ORDER BY downloads.id DESC;
            ");
                    $rows = $this->db->resultSet();
                    return count($rows) > 0 ? $rows : [];
    }
    public function getDownloadCountByBook($bookId) {
        $this->db->query("SELECT COUNT(*) as total FROM downloads WHERE book_id = :book_id");
        $this->db->bind(':book_id', $bookId);
        $row = $this->db->singleRecord();
        return $row ? $row['total'] : 0;
    }
       public function showsingleDownload($id) {
        $this->db->query("SELECT downloads.*, books.title, category.category AS category, user.username
            FROM downloads
            INNER JOIN books ON books.id = downloads.book_id
            INNER JOIN category ON category.id = books.category_id
            INNER JOIN user ON user.id = downloads.user_id
            WHERE downloads.user_id = :id
            ORDER BY downloads.id DESC;");
            $this->db->bind(':id', $id);
            $row = $this->db->resultSet();
            return $row ? $row : $_SESSION['msg'] = 'No data found';
            $_SESSION['msg_type'] = 'error';
    }
public function getTopDownloaders($limit = 10) {
    $limit = (int)$limit > 0 ? (int)$limit : 10;
    $this->db->query("
        SELECT user.username, COUNT(downloads.id) as total_downloads
        FROM downloads
        INNER JOIN user ON user.id = downloads.user_id
        GROUP BY downloads.user_id
        ORDER BY total_downloads DESC
        LIMIT $limit
    ");
    return $this->db->resultSet();
}
public function getTotalDownloads() {
    $this->db->query("SELECT COUNT(*) as total FROM downloads");
    $row = $this->db->singleRecord();
    return $row ? $row['total'] : 0;
}

public function getTopDownloadedBooks($limit = 10) {
    $this->db->query("
        SELECT books.title, COUNT(downloads.id) as total_downloads
        FROM downloads
        INNER JOIN books ON books.id = downloads.book_id
        GROUP BY downloads.book_id
        ORDER BY total_downloads DESC
        LIMIT :limit
    ");
    $this->db->bind(':limit', $limit, PDO::PARAM_INT);
    return $this->db->resultSet();
}
public function insertDownload($userId, $bookId, $categoryId) {

    $this->db->query("INSERT INTO downloads (user_id, book_id, category_id) VALUES (:user_id, :book_id, :category_id)");
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':book_id', $bookId);
    $this->db->bind(':category_id', $categoryId);
    return $this->db->execute();
}

}