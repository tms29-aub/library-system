<?php
require_once '../app/model/Book.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class BookController {
    private $bookModel;

    public function __construct($pdo){
        // Database connection
        $this->bookModel = new Book($pdo);
    }

    public function add(){
        $requiredFields = ['title', 'author', 'published_date', 'genre', 'price', 'status'];

        // Check if all required fields are set
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                http_response_code(400);
                echo "All fields are required.";
                return;
            }
        }

        // Sanitize and validate inputs
        $title = htmlspecialchars(trim($_POST['title']));
        $author = htmlspecialchars(trim($_POST['author']));
        $published_date = trim($_POST['published_date']);
        $genre = htmlspecialchars(trim($_POST['genre']));
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $status = htmlspecialchars(trim($_POST['status']));

        // Validate price
        if (!$price || $price < 0) {
            http_response_code(400);
            echo "Invalid price value.";
            return;
        }

        // Validate status
        $allowedStatus = ['available', 'checked_out', 'reserved'];
        if (!in_array($status, $allowedStatus)) {
            http_response_code(400);
            echo "Invalid status.";
            return;
        }

        // Add to database
        try{
            $this->bookModel->addBook($title, $author, $published_date, $genre, $price, $status);
            http_response_code(200);
            error_log("Before headers_sent() check");
if (headers_sent($file, $line)) {
    die("Headers already sent in $file on line $line");
}
error_log("After headers_sent() check, proceeding to header()");
header("Location: /");
exit;
            
        } catch (PDOException $e){
            http_response_code(500);
            echo "Server Error";
        }
    }

    public function list($page=1, $category=null){
        // Ensure $page is a valid positive integer
        $page = filter_var($page, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if (!$page) {
            http_response_code(400);
            echo "Invalid page number.";
            return;
        }

        try{
            $categories = $this->bookModel->getCategories();
            $books = [];

            // Check if category is set
            if($category){
                // Check if category exists
                if(!in_array($category, $categories)){
                    http_response_code(404);
                    echo "Category not found.";
                    return;
                }
                $books = $this->bookModel->getBooksOfCategory($page, $category);
            }
            else{
                $books = $this->bookModel->getAllBooks($page);
            }

            http_response_code(200);
            return ['categories'=>$categories, 'books'=>$books];
        } catch (PDOException $e){
            http_response_code(500);
            echo "Server Error".$e->getMessage();
        }
    }

    public function detail($id){
        try{
            $book = $this->bookModel->getBookById($id);

            // Check if book exists
            if (!$book) {
                http_response_code(404);
                echo "Book not found.";
                return;
            }

            $bookDetail = $this->bookModel->getBookById($id);
            http_response_code(200);
            return $bookDetail;
        } catch (PDOException $e){
            http_response_code(500);
            echo "Server Error";
            return null;
        }
    }

    public function edit($id){
        // Sanitize and validate inputs
        $title = htmlspecialchars(trim($_POST['title']));
        $author = htmlspecialchars($_POST['author']);
        $published_date = htmlspecialchars($_POST['published_date']);
        $genre = htmlspecialchars($_POST['genre']);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $status = htmlspecialchars($_POST['status']);

        // Check if all required fields are set
        if(empty($title) || empty($author) || empty($published_date) || empty($genre) || empty($price) || empty($status)) {
            http_response_code(400);
            echo "All fields are required.";
            return;
        }

        // Validate price
        if (!$price || $price < 0) {
            http_response_code(400);
            echo "Invalid price value.";
            return;
        }

        try{
            $book = $this->bookModel->getBookById($id);

            // Check if book exists
            if (!$book) {
                http_response_code(404);
                echo "Book not found.";
                return;
            }

            $this->bookModel->updateBook($id, $title, $author, $published_date, $genre, $price, $status);
            http_response_code(200);
        } catch (PDOException $e){
            http_response_code(500);
            echo "Server Error";
        }

        header("Location: /");
    }

    public function delete($id){
        try{
            $book = $this->bookModel->getBookById($id);

            // Check if book exists
            if (!$book) {
                http_response_code(404);
                echo "Book not found.";
                return;
            }

            $this->bookModel->deleteBook($id);
            http_response_code(200);
        } catch (PDOException $e){
            http_response_code(500);
            echo "Server Error";
        }

        header("Location: /");
    }
}
