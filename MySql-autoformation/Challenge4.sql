--Setup: Create a second table called categories with id (PK) and name.
CREATE TABLE categories (
    id INT PRIMARY KEY,
    name VARCHAR(150)
);
--link: In your library_books table, add a column category_id (INT).
ALTER TABLE library_books
ADD category_id INT;
ALTER TABLE library_books
ADD CONSTRAINT fk_category
FOREIGN KEY (category_id) REFERENCES categories(id);
--Action: Assign a category ID to each book in your database.
UPDATE library_books SET category_id = 1 WHERE id = 1;
UPDATE library_books SET category_id = 1 WHERE id = 2;
UPDATE library_books SET category_id = 2 WHERE id = 3;
UPDATE library_books SET category_id = 2 WHERE id = 4;
UPDATE library_books SET category_id = 3 WHERE id = 5;
UPDATE library_books SET category_id = 3 WHERE id = 6;
UPDATE library_books SET category_id = 1 WHERE id = 7;
UPDATE library_books SET category_id = 2 WHERE id = 8;
--The Query: Write a SELECT statement that joins both tables to show the Book Title and the Category Name side-by-side
SELECT l.title, c.name
FROM library_books l
JOIN categories c
ON l.category_id = c.id;