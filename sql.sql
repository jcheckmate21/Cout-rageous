-t

-- Table structure for table `players`

--



CREATE TABLE `players` (

`id` int(11) NOT NULL auto_increment,

`firstname` varchar(32) NOT NULL,

`lastname` varchar(32) NOT NULL,

PRIMARY KEY (`id`)

) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- Usingcount and distinct
SELECT count(distinct id) WHERE;





--

-- Dumping data for table `players`

--


v
INSERT INTO `players` VALUES(1, 'Bob', 'Baker');

INSERT INTO `players` VALUES(2, 'Tim', 'Thomas');

INSERT INTO `players` VALUES(3, 'Rachel', 'Roberts');

INSERT INTO `players` VALUES(4, 'Sam', 'Smith');




SELECT date, (DATE(NOW()) - INTERVAL 7 DAY) AS diff FROM attendance WHERE 
date >= (DATE(NOW()) - INTERVAL 7 DAY) ORDER BY date DESC




-- works
SELECT date 
  FROM attendance
 WHERE TIMESTAMPDIFF(DAY,date,now()) < 30   
ORDER BY date DESC


-- with distnict
SELECT distinct date 
  FROM attendance
 WHERE TIMESTAMPDIFF(DAY,date,now()) < 30   
ORDER BY date DESC


-- with union
(SELECT date FROM attendance WHERE TIMESTAMPDIFF(DAY,date,now()) < 30 ORDER BY date DESC)
union
(SELECT date FROM attendance WHERE TIMESTAMPDIFF(DAY,date,now()) < 30  group by date)


SELECT SUM( time_out - time_in ) as Total
FROM attendance
WHERE TIMESTAMPDIFF(DAY,date,now()) < 30  group by date



SELECT date, SUM( time_out - time_in ) as Total FROM attendance WHERE (date_field BETWEEN '2019-06-30' AND '2010-07-19') 
and anumber='A10485067'
group by date


SELECT date, SUM( time_out - time_in ) as Total FROM attendance WHERE (date BETWEEN '2019-06-30' AND '2019-07-19') and anumber='A10485067' group by date

DATE_FORMAT(`t`.`time_in`,'%r') AS `time_in`



-- for table with time in time out and total seconds
-- SELECT date, DATE_FORMAT(`time_in`,'%r') AS `time_in`,  DATE_FORMAT(`time_out`,'%r') AS `time_out`, SUM( time_out - time_in ) as Total FROM attendance WHERE (date BETWEEN '2019-06-30' AND '2019-07-19') and anumber='A10485067' group by date

-- for table with time in time out and total seconds (right)
SELECT date, DATE_FORMAT(`time_in`,'%h:%i %p') AS `time_in`,  DATE_FORMAT(`time_out`,'%h:%i %p') AS `time_out`, SUM( time_out - time_in ) as Total FROM attendance WHERE (date BETWEEN '2019-06-30' AND '2019-07-19') and anumber='A10485067' group by date


-- date in readable format
SELECT DATE_FORMAT(`date`, '%M %D, %Y') as `date`, DATE_FORMAT(`time_in`,'%h:%i %p') AS `time_in`,  DATE_FORMAT(`time_out`,'%h:%i %p') AS `time_out`, SUM( time_out - time_in ) as Total FROM attendance WHERE (date BETWEEN '2019-06-30' AND '2019-07-19') and anumber='A10485067' group by date

UPDATE attendance SET anumber = 'A888888' WHERE anumber= 'A10485067'




UPDATE attendance SET time_out = NOW(), memo = 'Signed out manually' WHERE id = '178'
SELECT * FROM `attendance`

select time_format(SUM(abs(timediff(time_out, time_in))),'%H:%i:%s') from attendance where id = '178'





-- multiple queries from multiple tables
SELECT a.anumber, b.anumber FROM attendance a, students b WHERE a.anumber = b.anumber



SELECT DATE_FORMAT(a.date, '%d/%m/%Y' ) as date, a.type, a.anumber, a.firstname, a.lastname, a.time_in, a.time_out, a.memo FROM attendance a, students s WHERE a.type = 'student' and a.anumber = s.anumber 


SELECT DATE_FORMAT(a.date, '%d/%m/%Y' ) as date, a.type, a.anumber, a.firstname, a.lastname, a.time_in, a.time_out, a.memo FROM  students s LEFT JOIN attendance a
ON a.type = 'student' and a.anumber = s.anumber and s.crn = '414678'

SELECT sum(TIMESTAMPDIFF(SECOND, a.time_in, a.time_out)) as hours, a.anumber, s.anumber  FROM  students s LEFT JOIN attendance a
ON a.type = 'student' and a.anumber = s.anumber and s.crn = '414678'


SELECT sum(TIMESTAMPDIFF(SECOND, a.time_in, a.time_out)) as hours, a.anumber, s.anumber FROM students s LEFT JOIN attendance a ON a.type = 'student' and a.anumber = s.anumber and s.crn LIKE '%414678%' group by a.date



SELECT a.date, sum(TIMESTAMPDIFF(SECOND, a.time_in, a.time_out)) as hours, a.anumber, s.anumber FROM students s LEFT JOIN attendance a ON a.type = 'student' and a.anumber = s.anumber and s.crn LIKE '%414678%' group by a.date




-- for instructor specified courses
SELECT a.date, sum(TIMESTAMPDIFF(SECOND, a.time_in, a.time_out)) as hours, a.anumber, s.anumber FROM students s LEFT JOIN attendance a ON a.type = 'student' and a.anumber = s.anumber and s.crn LIKE '%414678%' group by s.anumber

-- or this is right
SELECT a.date, sum(TIMESTAMPDIFF(MINUTE, a.time_in, a.time_out)) as hours,s.type, s.anumber, s.firstname, s.lastname, s.crn FROM students s LEFT JOIN attendance a ON a.type = 'student' AND a.anumber = s.anumber group by s.anumber HAVING s.type = 'student' and s.crn LIKE '%414678%'


SELECT a.date, sum(TIMESTAMPDIFF(MINUTE, a.time_in, a.time_out)) as hours,s.type, s.anumber, s.firstname, s.lastname, s.crn FROM attendance a INNER JOIN students s ON a.type = 'student' and a.anumber = s.anumber group by s.anumber having s.type = 'student' and s.crn LIKE '%414678%'


SELECT DATE_FORMAT(a.date, '%m/%d/%Y' ) as date,s.type, s.anumber, s.firstname, s.lastname, a.time_in, a.time_out, a.memo FROM attendance a INNER JOIN students s ON s.type = 'student' and a.anumber = s.anumber and s.crn LIKE '%414678%' and (a.date between '2019/07/01' and '2019/08/01')