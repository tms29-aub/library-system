<?php require_once '../app/controller/BookController.php'; ?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<form method="GET" action="/">
    <label for="genre">Filter by Genre:</label>
    <select name="genre" id="genre" onchange="this.form.submit()">
        <option value="">All Genres</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category) ?>" <?= isset($_GET['genre']) && $_GET['genre'] == $category ? 'selected' : '' ?>>
                <?= htmlspecialchars($category) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<h2>Book List</h2>
<a href="/create.php">Add New Book</a>
<table>
    <tr>
        <th>Title</th><th>Author</th><th>Genre</th><th>Price</th><th>Status</th><th>Actions</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= $book['title'] ?></td>
        <td><?= $book['author'] ?></td>
        <td><?= $book['genre'] ?></td>
        <td><?= $book['price'] ?></td>
        <td><?= $book['status'] ?></td>
        <td>
            <a href="/edit?id=<?= $book['id'] ?>">Edit</a>
            <a href="/delete?id=<?= $book['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$prevPage = $page > 1 ? $page - 1 : 1;
$nextPage = $page + 1;
?>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $prevPage ?>" class="btn">Back</a>
    <?php endif; ?>
    <a href="?page=<?= $nextPage ?>" class="btn">Next</a>
</div>