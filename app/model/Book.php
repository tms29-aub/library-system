<?php

class Book{
    public $pdo;

    public function __construct($pdo){
        // Database connection
        $this->pdo = $pdo;
    }

    public function getAllBooks($page){
        // Pagination
        $offset = 10*($page - 1);

        // Get all books
        $query = $this->pdo->query("SELECT * FROM Books LIMIT 10 OFFSET $offset");
        $books = $query->fetchAll();

        return $books;
    }

    public function getBookById($id){
        $query = $this->pdo->prepare("SELECT * from Books WHERE id = :id;");
        $query->execute(["id" => $id]);
        $book = $query->fetch();

        return $book;
    }

    public function addBook($title, $author, $published_date, $genre, $price, $status){
        $query = $this->pdo->prepare("INSERT INTO Books (title, author, published_date, genre, price, status) VALUES
            (:title, :author, :published_date, :genre, :price, :status);");
        $query->execute([
            "title" => $title,
            "author" => $author,
            "published_date" => $published_date,
            "genre" => strtolower($genre),
            "price" => $price,
            "status" => $status
        ]);
    }

    public function updateBook($id, $title, $author, $published_date, $genre, $price, $status){
        $query = $this->pdo->prepare("UPDATE Books SET title=:title, author=:author, published_date=:published_date, genre=:genre, price=:price, status=:status WHERE id=:id;");
        $query->execute([
            "id" => $id,
            "title" => $title,
            "author" => $author,
            "published_date" => $published_date,
            "genre" => strtolower($genre),
            "price" => $price,
            "status" => $status
        ]);
    }

    public function deleteBook($id){
        $query = $this->pdo->prepare("DELETE FROM Books WHERE id = :id;");
        $query->execute(["id" => $id]);
    }

    public function getBooksOfCategory($page, $category){
        // Pagination
        $offset = 10*($page - 1);

        // Get all books of category
        $query = $this->pdo->prepare("SELECT * FROM Books where genre = :genre LIMIT 10 OFFSET $offset;");
        $query->execute(['genre' => $category]);

        $books = $query->fetchAll();

        return $books;
    }

    public function getCategories(){
        $query = $this->pdo->query("SELECT DISTINCT genre FROM Books;");
        $categories = $query->fetchAll(PDO::FETCH_COLUMN, 0); // Fetch only genre names as a simple array
    
        return $categories;
    }
}
?>