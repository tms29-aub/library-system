# Library System Practical Task

### Database Setup
- Create MySQL database library_system
- Create table Books
    - id (primary key, auto_increment)
    - title (varchar)
    - author (varchar)
    - published_date (date)
    - genre (varchar)
    - price (decimal)
    - status (available, checked_out, reserved)

### Front-End
- Design HTML forms to perform CRUD operations
- View list of books in table format

### Back-End
- Implement Backend functionalities to perform CRUD operations
- Use pagination if the table grows too large
- Handle errors and return proper responses
- Validate and sanitize user input

### Array-Handling
- Group books by genre using PHP arrays.

## Running Project
1. Add config/database.php with the following fields:
- $db_host
- $username
- $password 

2. Run the command 

    `php -S localhost:8000 -t public`

3. Access `localhost:8000` on the browser