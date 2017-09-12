-- Select all fields From the table book where the id=3;
SELECT * FROM book WHERE id=3;

-- Select the title and isbn From the table book where the id=3;
SELECT title, isbn FROM book WHERE id=3

-- You don't have to use ` around the fieldname or table name, but it's good practice to do so.

-- Select all fields From the table book and the publisher's name where the id=3;
SELECT `b`.*, `p`.`name` FROM `book` AS `b`
JOIN `publisher` AS `p` ON `p`.`id`=`b`.`publisherid`
WHERE `b`.`id`=3;

UPDATE `book` SET `yearpublished`=2005 WHERE `id`=3;

INSERT INTO `book` (`title`, `yearpublished`, `isbn`, `publisherid`) VALUES ('My book', 2006, 1234556, 11);

SELECT `b`.*, `p`.`name` FROM `book` AS `b`
JOIN `publisher` AS `p` ON `p`.`id`=`b`.`publisherid`
WHERE `b`.`title` LIKE '%book%';

DELETE FROM `book` WHERE `title` LIKE '%book%';

SELECT `b`.*, `p`.`name` FROM `book` AS `b`
JOIN `publisher` AS `p` ON `p`.`id`=`b`.`publisherid`
WHERE `b`.`title` LIKE '%book%';
