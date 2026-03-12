--Total Inventory Value: The sum of all book prices.
SELECT SUM(price) as total
FROM library_books;
--Stock Count: The total number of books currently marked as 'Available'.
SELECT COUNT(*) as total
FROM library_books
WHERE status ='Available';
--Price Extremes: The most expensive and the cheapest book in one query.
SELECT MAX(price) as most_expensive , MIN(price) as cheapest
FROM library_books;
--Average Cost: The average price of all books in your library.
SELECT AVG(price) as average_price
FROM library_books;
