<head>
    <link rel="stylesheet" href="style.css">
</head>

<h2>Add New Book</h2>
<form action="/create.php" method="post">
    <input type="text" name="title" required placeholder="Title">
    <input type="text" name="author" required placeholder="Author">
    <input type="date" name="published_date" required>
    <input type="text" name="genre" required placeholder="Genre">
    <input type="number" step="0.01" name="price" required placeholder="Price">
    <select name="status">
        <option value="available">Available</option>
        <option value="checked_out">Checked Out</option>
        <option value="reserved">Reserved</option>
    </select>
    <button type="submit">Add Book</button>
</form>