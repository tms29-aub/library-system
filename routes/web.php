<?php
require_once '../config/db_config.php';
require_once '../app/controller/BookController.php';

$bookController = new BookController($pdo);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    // GET methods render the view pages
    // POST methods handle the form submissions
    case '/':
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $category = isset($_GET['genre']) ? $_GET['genre'] : null;
        $data = $bookController->list($page, $category);

        if ($data) {
            $books = $data['books'];
            $categories = $data['categories'];
            include '../app/views/index.php';
        }
        break;
    case '/create.php':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $bookController->add();
        }
        else if($_SERVER['REQUEST_METHOD'] == 'GET'){
            include '../app/views/create.php';
        }
        break;
    case '/edit':
        $id = $_GET['id'];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $bookController->edit($id);
        }
        else if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $bookDetail = $bookController->detail($id);
            include '../app/views/edit.php';
        }
        break;
    case '/delete':
        $id = $_GET['id'];
        $bookController->delete($id);
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
?>