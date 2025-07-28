<?php
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ ."/../Model/Database.php";
    class Category{
        private $db;

        public function __construct(){
            $this->db =  new Database();
        }

          public function showCat(){
            $this->db->query('SELECT * FROM category ');
            $rows = $this->db->resultSet();

            if(count($rows) > 0){
                return $rows;
            }else{
                return false;
            }

        }
        public function removeCat($id){

                $this->db->query('DELETE FROM category WHERE id = :uid');
                $this->db->bind(':uid', $id);

                if ($this->db->execute()) {
                    $_SESSION['msg'] = 'Category removed successfully';
                    $_SESSION['msg_type'] = 'success';
                    return true;
                } else {
                    return false;
                }
           
        }
        Public function InsertCat($category){
                // Save filename in DB
                 $this->db->query("SELECT * FROM category WHERE category=:cat");
                $this->db->bind(':cat', $category);
                $row = $this->db->singleRecord();
                if($row){
                    $_SESSION['msg'] = 'Category already exists';
                    $_SESSION['msg_type'] = 'error';
                    exit();
                }

                $this->db->query('INSERT INTO category(category) VALUES(:cat)');
                $this->db->bind(':cat', $category); 
  
                if($this->db->execute()){
                    return true;
                }
            
        }
        public function editCat($id, $category){
            $this->db->query("UPDATE category SET category =:cat WHERE id = :id");
            $this->db->bind(":id", $id);
            $this->db->bind(":cat", $category);
         
        
            return $this->db->execute() ? true : $_SESSION['msg'] = 'Failed to update category'; $_SESSION['msg_type'] = 'error';
        }
        // Inside Controller/Book.php
public function getFeaturedBooks($limit = 6)
{
    $limit = intval($limit); // sanitize to integer
    $this->db->query("SELECT books.*, category.category AS category 
        FROM books 
        JOIN category ON books.category_id = category.id 
        ORDER BY RAND() 
        LIMIT $limit"); // 👈 directly embedded since LIMIT can't be bound
    return $this->db->resultSet();
}

public function getCategoryNameById($id) {
    $this->db->query("SELECT category FROM category WHERE id = :id");
    $this->db->bind(':id', $id);
    $row = $this->db->singleRecord();
    return $row ? $row['category'] : 'Unknown';
}


       
    }

    
