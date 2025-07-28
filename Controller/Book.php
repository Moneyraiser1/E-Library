<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../Model/Database.php";

class Book {
    private $db;
    private $imageDir = __DIR__ . '/../uploads/images/';
    private $fileDir = __DIR__ . '/../uploads/files/';
    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    private $allowedPdfType = 'application/pdf';

    public function __construct() {
        $this->db = new Database();
    }

    public function insertBook($title, $isbn, $author_name, $category_id, $imageFile, $pdfFile) {
        if (empty($title) || empty($isbn) || empty($author_name) || empty($category_id)) {
            $_SESSION['msg'] = 'All fields are required';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Check if ISBN already exists
        $this->db->query("SELECT * FROM books WHERE isbn = :isbn");
        $this->db->bind(':isbn', $isbn);
        if ($this->db->singleRecord()) {
            $_SESSION['msg'] = 'Book already exists';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Validate and upload image
        $imagePath = null;
        if ($imageFile['error'] === 0) {
            if (!in_array($imageFile['type'], $this->allowedImageTypes)) {
                $_SESSION['msg'] = 'Invalid image type';
                $_SESSION['msg_type'] = 'error';
                return false;
            }
            $imageName = uniqid() . '_' . basename($imageFile['name']);
            $imagePath = $this->imageDir . $imageName;
            if (!move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
                $_SESSION['msg'] = 'Failed to upload image';
                $_SESSION['msg_type'] = 'error';
                return false;
            }
        }

        // Validate and upload PDF
        $pdfPath = null;
        if ($pdfFile['error'] === 0) {
            if ($pdfFile['type'] !== $this->allowedPdfType) {
                $_SESSION['msg'] = 'Invalid file type. Only PDF allowed.';
                $_SESSION['msg_type'] = 'error';
                return false;
            }
            $pdfName = uniqid() . '_' . basename($pdfFile['name']);
            $pdfPath = $this->fileDir . $pdfName;
            if (!move_uploaded_file($pdfFile['tmp_name'], $pdfPath)) {
                $_SESSION['msg'] = 'Failed to upload PDF';
                $_SESSION['msg_type'] = 'error';
                return false;
            }
        }

        // Insert book
        $this->db->query("INSERT INTO books (title, isbn, author_name, category_id, image, pdf) 
                          VALUES (:title, :isbn, :author_name, :category_id, :image, :pdf)");
        $this->db->bind(':title', htmlspecialchars($title));
        $this->db->bind(':isbn', htmlspecialchars($isbn));
        $this->db->bind(':author_name', htmlspecialchars($author_name));
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':image', $imageName);
        $this->db->bind(':pdf', $pdfName);

        if ($this->db->execute()) {
            $_SESSION['msg'] = 'Book added successfully';
            $_SESSION['msg_type'] = 'success';
            return true;
        }

        $_SESSION['msg'] = 'Failed to add book';
        $_SESSION['msg_type'] = 'error';
        return false;
    }

    public function showBooks() {
        $this->db->query("SELECT books.*, category.category 
                          FROM books 
                          LEFT JOIN category ON books.category_id = category.id 
                          ORDER BY books.id DESC");
        $rows = $this->db->resultSet();
        return count($rows) > 0 ? $rows : [];
    }

    public function showSingleBook($id) {
        $this->db->query("SELECT books.*, category.category 
                          FROM books 
                          LEFT JOIN category ON books.category_id = category.id 
                          WHERE books.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->singleRecord();
    }

    public function removeBook($id) {
        $book = $this->showSingleBook($id);
        if (!$book) {
            $_SESSION['msg'] = 'Book not found';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Delete files
        if (!empty($book->image) && file_exists($book->image)) unlink($book->image);
        if (!empty($book->pdf) && file_exists($book->pdf)) unlink($book->pdf);

        // Delete DB record
        $this->db->query("DELETE FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            $_SESSION['msg'] = 'Book deleted successfully';
            $_SESSION['msg_type'] = 'success';
            return true;
        }

        $_SESSION['msg'] = 'Failed to delete book';
        $_SESSION['msg_type'] = 'error';
        return false;
    }
    public function updateBook($id, $title, $author_name, $category_id, $imageFile, $pdfFile, $existingImage, $existingPdf) {
    if (empty($title) || empty($author_name) || empty($category_id)) {
        $_SESSION['msg'] = 'All fields are required';
        $_SESSION['msg_type'] = 'error';
        return false;
    }

    // Handle image upload
    $imageName = $existingImage;
    if ($imageFile['error'] === 0) {
        if (!in_array($imageFile['type'], $this->allowedImageTypes)) {
            $_SESSION['msg'] = 'Invalid image type';
            $_SESSION['msg_type'] = 'error';
            return false;
        }
        $imageName = uniqid() . '_' . basename($imageFile['name']);
        $imagePath = $this->imageDir . $imageName;
        if (!move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
            $_SESSION['msg'] = 'Failed to upload new image';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Delete old image
        $oldImagePath = $this->imageDir . $existingImage;
        if (file_exists($oldImagePath)) unlink($oldImagePath);
    }

    // Handle PDF upload
    $pdfName = $existingPdf;
    if ($pdfFile['error'] === 0) {
        if ($pdfFile['type'] !== $this->allowedPdfType) {
            $_SESSION['msg'] = 'Invalid file type. Only PDF allowed.';
            $_SESSION['msg_type'] = 'error';
            return false;
        }
        $pdfName = uniqid() . '_' . basename($pdfFile['name']);
        $pdfPath = $this->fileDir . $pdfName;
        if (!move_uploaded_file($pdfFile['tmp_name'], $pdfPath)) {
            $_SESSION['msg'] = 'Failed to upload new PDF';
            $_SESSION['msg_type'] = 'error';
            return false;
        }

        // Delete old PDF
        $oldPdfPath = $this->fileDir . $existingPdf;
        if (file_exists($oldPdfPath)) unlink($oldPdfPath);
    }

    // Update book record
    $this->db->query("UPDATE books 
                      SET title = :title, author_name = :author_name, category_id = :category_id, image = :image, pdf = :pdf 
                      WHERE id = :id");
    $this->db->bind(':title', htmlspecialchars($title));
    $this->db->bind(':author_name', htmlspecialchars($author_name));
    $this->db->bind(':category_id', $category_id);
    $this->db->bind(':image', $imageName);
    $this->db->bind(':pdf', $pdfName);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
        $_SESSION['msg'] = 'Book updated successfully';
        $_SESSION['msg_type'] = 'success';
        return true;
    }

    $_SESSION['msg'] = 'Failed to update book';
    $_SESSION['msg_type'] = 'error';
    return false;
}
public function getBooksByCategory($categoryId)
{
    $this->db->query("SELECT books.*, category.category AS category 
        FROM books 
        JOIN category ON books.category_id = category.id 
        WHERE books.category_id = :catId");
    $this->db->bind(':catId', $categoryId);
    return $this->db->resultSet();
}

public function searchBooks($term) {
    $term = "%{$term}%";
    $this->db->query("SELECT books.*, category.category FROM books 
            JOIN category ON books.category_id = category.id 
            WHERE books.title LIKE :term OR books.author_name LIKE :term");
    $this->db->bind(':term', $term);
    $rows = $this->db->resultSet();
    return $rows;
}


}
