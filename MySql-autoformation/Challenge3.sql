--The Catalog: List all books, but only show the title, author, and price.
SELECT title , author, price 
FROM library_books;
--The Budget Filter: Find all books that cost between 100 MAD and 300 MAD.
SELECT *
FROM library_books
WHERE price BETWEEN 100 AND 300;
--The Modernist: Find all books published after the year 2020.
SELECT * 
FROM library_books
WHERE published_year > 2020;
--The Search Bar: Find all books that have the word "PHP" anywhere in their title.
SELECT * 
FROM library_books
WHERE title LIKE '%PHP%';
--The Availability Check: List all books that are NOT currently 'Lost', sorted by the most recent published_year.
SELECT *
FROM library_books
WHERE NOT status ='Lost'
ORDER BY published_year DESC;
--The Author Audit: List all unique (DISTINCT) authors in the library.
SELECT DISTINCT (author)
FROM library_books;
--The Formatting: Show the book titles in UPPERCASE and the price rounded to the nearest whole number.
SELECT UPPER(title) as title, ROUND(price) as price
FROM library_books;