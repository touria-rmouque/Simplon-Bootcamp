--Status Report: Show each status (Available, Borrowed, Lost) and how many books belong to each.
SELECT status , COUNT(status) as num
FROM library_books
GROUP BY status;
--Author Performance: Show the total value of books owned by each author.
SELECT author , COUNT(*) as total_books
FROM library_books
GROUP BY author;
--The Filter: Show only the authors whose total book value is greater than 500 MAD (use HAVING).
SELECT author , SUM(price) as total_book_value
FROM library_books
GROUP BY author
HAVING total_book_value>500;