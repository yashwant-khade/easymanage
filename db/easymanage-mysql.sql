drop database if exists easymanage;
create database easymanage;
use easymanage;

CREATE TABLE year (
  year_id        			integer not null,
  primary key (year_id),
  unique (year_id)
);

CREATE TABLE worker (
  wrk_id        			integer not null auto_increment,
  wrk_name      			varchar(100) not null,
  starting_year_id       	integer, 
  password 					varchar(50),
  primary key (wrk_id),
  unique (wrk_id),
  foreign key (starting_year_id) references year(year_id)
);

INSERT year VALUES
(2010), (2011), (2012), (2013), (2014), (2015), (2016), (2017), (2018), (2019);

INSERT INTO worker (wrk_name, starting_year_id, password) VALUES 
('Chaitanya Dasari', 2019, 'thisIsMyPassword'),
('Yashwant Khade', 2010, 'yash'),
('Zoie MacDougall', 2010, 'MeowMeowMeow'),
('Kunika Mittal', 2010, 'kunika'),
('Patrick Ngo', 2019, 'pat'),
('Sanghyun Ryu', 2019, 'p-a-s-s-w-o-r-d');





CREATE TABLE admin (
  admin_id					integer not null PRIMARY KEY auto_increment,
  admin_name				varchar(100) not null,
  username					varchar(100) not null,
  password 					varchar(50)
);

INSERT INTO admin (admin_name, username, password) VALUES 
('Chaitanya Dasari',	'Chai',		'thisIsMyPassword'),
('Yashwant Khade',		'Yash',		'yash'),
('Zoie MacDougall',		'Zoie',		'MeowMeowMeow'),
('Kunika Mittal',			'Kunika',	'kunika'),
('Patrick Ngo',				'pat',		'pat'),
('Sanghyun Ryu',			'Ricky',	'p-a-s-s-w-o-r-d');














