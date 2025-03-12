<?php require_once '../app/controller/BookController.php'; ?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<h2>Edit Book</h2>
<form action="/edit?id=<?php echo $bookDetail['id']; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $bookDetail['id']; ?>">
    <input type="text" name="title" required value="<?php echo $bookDetail['title'] ?>">
    <input type="text" name="author" required value=<?php echo $bookDetail['author'] ?>>
    <input type="date" name="published_date" required value=<?php echo $bookDetail['published_date'] ?>>
    <input type="text" name="genre" required value=<?php echo $bookDetail['genre'] ?>>
    <input type="number" step="0.01" name="price" required value=<?php echo $bookDetail['price'] ?>>
    <select name="status">
        <option value="available">Available</option>
        <option value="checked_out">Checked Out</option>
        <option value="reserved">Reserved</option>
    </select>
    
    <button type="submit">Save</button>
</form>