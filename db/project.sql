drop database if exists easymanage;
create database easymanage;
use easymanage;

CREATE TABLE admin (
  admin_id					integer not null PRIMARY KEY auto_increment,
  admin_name				varchar(100) not null,
  username					varchar(100) not null,
  password 					varchar(50)
);


CREATE TABLE year (
  year_id        			integer not null,
  primary key (year_id)
);

 
CREATE TABLE worker (
  wrk_id        			integer not null auto_increment,
  wrk_name      			varchar(100) not null,
  starting_year_id       	integer, 
  password 					varchar(50),
  
  primary key (wrk_id),
   foreign key (starting_year_id) references year(year_id)
);


CREATE TABLE hourly_work (
  wrk_id					integer ,
  hourly_salary              integer not null,
   primary key (wrk_id),
   foreign key (wrk_id) references worker(wrk_id)
   on delete cascade
   on update cascade
);


CREATE TABLE salary_work (
  wrk_id					integer ,
  annual_salary              integer not null,
   primary key (wrk_id),
   foreign key (wrk_id) references worker(wrk_id)
);

CREATE TABLE department (
  dept_name					varchar(50),
   primary key (dept_name)
);


CREATE TABLE employee (
emp_wrk_id					integer ,
  works_for_dept_name					varchar(50),
   primary key (emp_wrk_id),
  foreign key (emp_wrk_id) references worker(wrk_id)
  on delete cascade
  on update cascade,
  foreign key (works_for_dept_name) references department(dept_name)
  on delete set null
  on update cascade
);

CREATE TABLE director (
director_wrk_id					integer ,
  primary key (director_wrk_id),
  foreign key (director_wrk_id) references worker(wrk_id)
  on delete cascade
  on update cascade
);

CREATE TABLE manager (
manager_wrk_id					integer ,
   primary key (manager_wrk_id),
  foreign key (manager_wrk_id) references worker(wrk_id)
  on delete cascade
  on update cascade
);


CREATE TABLE employee_management (
emp_wrk_id					integer ,
  manager_wrk_id					integer ,
   primary key (emp_wrk_id,manager_wrk_id),
  foreign key (emp_wrk_id) references employee(emp_wrk_id)
  On Delete Cascade
  On Update Cascade,
  foreign key (manager_wrk_id) references manager(manager_wrk_id)
  On Delete Cascade
  On Update Cascade
);

CREATE TABLE department_head (
dh_wrk_id					integer ,
leads_dept_name					varchar(50),
 primary key (dh_wrk_id),
  foreign key (dh_wrk_id) references manager(manager_wrk_id)
  On Delete Cascade
  On Update Cascade,
  foreign key (leads_dept_name) references department(dept_name)
  On Delete Cascade
  On Update Cascade
);


CREATE TABLE bonus(
   bonus_id       	   integer not null auto_increment,
   amount               integer,
   
   receiver_wrk_id          integer,
   giver_wrk_id        integer,
   
  primary key (bonus_id,receiver_wrk_id,giver_wrk_id),
 
  foreign key (giver_wrk_id) references worker(wrk_id) 
  On Update Cascade
On Delete Cascade,
  foreign key (receiver_wrk_id) references worker(wrk_id)
  On Update Cascade
On Delete Cascade
);

CREATE TABLE perf_review(
   perf_id       	    integer not null auto_increment,
   receiver_wrk_id          integer,
   giver_wrk_id             integer,
   perf_rating               integer,
  primary key (perf_id,receiver_wrk_id,giver_wrk_id),
 
  foreign key (receiver_wrk_id) references worker(wrk_id)
  On delete cascade
  On Update cascade,
  foreign key (giver_wrk_id) references worker(wrk_id)
   On delete cascade
  On Update cascade
);

CREATE TABLE project(
  proj_id       	    integer not null auto_increment,
  proj_name     	    varchar(100) ,
   proj_due_date        date,
 proj_status          varchar(50),
 supervisor_dh_wrk_id        integer,

  primary key (proj_id,proj_name),
  foreign key (supervisor_dh_wrk_id) references department_head(dh_wrk_id)
  On Delete Set Null
  On update cascade
);

CREATE TABLE task(
   task_id       	   integer not null auto_increment,
   task_name     	    varchar(100) ,
   task_due_date        date,
   task_status          varchar(50),
   proj_id        integer,
   assigned_emp_wrk_id       integer,
   supervisior_manager_wrk_id  integer,
   
  primary key (task_id,proj_id),
 
  foreign key (proj_id) references project(proj_id)
  On Update Cascade
  On Delete Cascade,
  foreign key (assigned_emp_wrk_id) references employee(emp_wrk_id)
  On Delete Set Null
  On Update Cascade,
 foreign key (supervisior_manager_wrk_id) references manager(manager_wrk_id)
 On Delete Set Null
  On Update Cascade
);


CREATE TABLE worklog(
   log_id       	  integer not null auto_increment,
   desp   	    varchar(250) ,
   entry_date             date,
   hours                integer,
  proj_id        integer,
   task_id            integer,
  
   
  primary key (log_id,task_id,proj_id),
  foreign key (task_id, proj_id) references task(task_id,proj_id)
  On Update Cascade
  On Delete Cascade
);

CREATE TABLE proj_management(
  proj_id       	    integer ,
  manager_wrk_id        integer,

  primary key (proj_id,manager_wrk_id),
  foreign key (proj_id) references project(proj_id)
  On Update Cascade
  On Delete Cascade,
  foreign key (manager_wrk_id) references manager(manager_wrk_id)
  On Update Cascade
  On delete Cascade
);

CREATE TABLE task_worklog(
   log_id       	    integer ,
   task_id            integer,
   proj_id            integer,
  
  primary key (log_id,task_id),
  foreign key (task_id,proj_id) references task(task_id,proj_id)
  On update cascade
  On delete cascade,
  foreign key (log_id) references worklog(log_id)
  On update cascade
  On delete cascade

);

CREATE TABLE proj_tasks(
   proj_id       	    integer ,
   task_id            integer,
  
  primary key (proj_id,task_id),
  foreign key (task_id) references task(task_id)
  On update cascade
  On delete cascade,
  foreign key (proj_id) references project(proj_id)
  On update cascade
  On delete cascade

);
CREATE TABLE yearly_bonus(
   year_id       	    integer,
  bonus_id              integer,
   receiver_wrk_id          integer,
   giver_wrk_id        integer,
   
  primary key (bonus_id,receiver_wrk_id,giver_wrk_id,year_id),
  
  foreign key (bonus_id,receiver_wrk_id,giver_wrk_id) references bonus(bonus_id,receiver_wrk_id,giver_wrk_id)
  On update cascade
  On delete cascade,
  
  foreign key (year_id) references year(year_id)
);

CREATE TABLE yearly_review(
   year_id       	    integer,
  perf_id              integer,
   receiver_wrk_id          integer,
   giver_wrk_id        integer,
   
  primary key (perf_id,receiver_wrk_id,giver_wrk_id,year_id),
  foreign key (perf_id,receiver_wrk_id,giver_wrk_id) references perf_review(perf_id,receiver_wrk_id,giver_wrk_id)
  On update cascade
  On delete cascade,
     foreign key (year_id) references year(year_id)
);

INSERT into year VALUES 
 (2010), (2011), (2012), (2013), (2014), (2015), (2016), (2017), (2018), (2019);
 
 INSERT INTO worker (wrk_name, starting_year_id, password) VALUES 
 ('Chaitanya Dasari', 2019, 'chay'),
('Yashwant Khade',2010, 'yash'),
 ('Zoie MacDougall',2010, 'MeowMeowMeow'),
 ('Kunika Mittal' ,2010, 'kunika'),
('Patrick Ngo', 2019, 'pat'),
('Sanghyun Ryu' ,2019, 'p-a-s-s-w-o-r-d'),
('Neha', 2013, 'this'),
('Mrinal',2013, 'mmr'),
('Venky',2014, 'Meoww'),
('Hitesh' ,2016, 'hit007'),
('Naren', 2013, 'naren'),
('Shambavi' ,2011, 'shambavi'),
('Kiran', 2010, 'this'),
('Kanika',2011, 'mmrsd'),
('Sairam',2018, 'Meowwfd'),
('Harsha' ,2015, 'hit007sdf');

INSERT INTO admin (admin_name, username, password) VALUES 
('Chaitanya Dasari',	'Chay',		'chay'),
('Yashwant Khade',		'Yash',		'yash'),
('Zoie MacDougall',		'Zoie',		'MeowMeowMeow'),
('Kunika Mittal',			'Kunika',	'kunika'),
('Patrick Ngo',				'pat',		'pat'),
('Sanghyun Ryu',			'Ricky',	'p-a-s-s-w-o-r-d');

INSERT INTO department (dept_name ) VALUES 
("Operations"),
("IT"),
("HR"),
("RnR"),
("Sales"),
("Marketing");

INSERT INTO director (director_wrk_id) Values
(1),(2),(3);

INSERT INTO employee (emp_wrk_id, works_for_dept_name) Values
(4, "HR"),(5, "RnR"),(6, "Operations"),(7, "IT"),(8, "Marketing"),(9, "Sales"),
(10, "HR"),(11, "RnR"),(12, "Operations"),(13, "IT"),(14, "Marketing"),(15, "Sales"),(16, "Sales");

INSERT INTO manager (manager_wrk_id) Values
(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16);

INSERT INTO department_head (dh_wrk_id, leads_dept_name) Values
(4, "HR"),(5, "RnR"),(6, "Operations"),(7, "IT"),(8, "Marketing"),(9, "Sales");

INSERT INTO worker (wrk_name, starting_year_id, password) VALUES 
 ('Ayush Mittal', 2019, 'ayush'),
('Vijay Goel',2010, 'vijay'),
 ('Meena Aggarwal',2010, 'meena'),
 ('Aditi Garg' ,2010, 'aditi'),
('Pat Rayan', 2019, 'patraya'),
('Ricky Morty' ,2019, 'ricky'),
('Suyash Garg', 2013, 'suyash'),
('Anita Bijjargi',2013, 'anita'),
('Suresh Kamthe',2014, 'suresh'),
('Himanshu' ,2016, 'hi7'),
('Narender', 2013, 'narender'),
('Omkar' ,2011, 'omkar'),
('Kirti Gupta', 2010, 'kirti'),
('Kasauti',2011, 'kasauti'),
('Sreenitha',2018, 'sri'),
('Sanjay' ,2015, 'sanjay');

INSERT INTO employee (emp_wrk_id, works_for_dept_name) Values
(17, "HR"),(18, "RnR"),(19, "Operations"),(20, "IT"),(21, "Marketing"),(22, "Sales"),
(23, "HR"),(24, "RnR"),(25, "Operations"),(26, "IT"),(27, "Marketing"),(28, "Sales"),(29, "Sales"),
(30, "HR"),(31, "RnR"),(32, "Operations");

Insert into salary_work (wrk_id,annual_salary ) Values
(1,90000),(2, 90000),(3, 90000),
(4,80000),(5, 80000),(6, 80000),(7,80000),(8, 80000),(9, 80000),
(10,70000),(11, 70000),(12, 70000),(13,70000),(14, 70000),(15, 70000),
(16,10000),(17, 10000),(18, 10000),(19,10000),(20, 10000),(21, 10000),(22, 10000),
(23,10000),(24, 10000),(25, 10000),(26, 10000);

Insert into salary_work (wrk_id,annual_salary ) Values
(27,5000),(28, 5000),(29, 5000),
(30,5000),(31, 5000),(32, 5000);

Insert into employee_management (emp_wrk_id,manager_wrk_id) Values
(17,10),(23,10),(30,10),(19,12),(25,12),(32,12),
(18,11),(24,11),(31,11),(20,13),(26,13),(21,14),(27,14),
(16,15),(22,15),(28,15),(29,15);

Insert into bonus (amount,receiver_wrk_id,giver_wrk_id ) Values
(2000,17,10),(2000,23,4),(3000,18,11),(3000,24,5),
(4000,16,15),(4000,22,9), (5000,19,12),(5000,25,6),
(6000,21,14),(6000,27,8),(7000,20,7),(7000,26,13);



INSERT INTO project( proj_name,proj_due_date,proj_status,supervisor_dh_wrk_id) VALUES 
('AI in DB','2017-06-05','Abandoned',4),
('Customer Churn Prediction','2018-07-15','Completed',5),
('Vertical Object Hiding','2016-08-05','In Progress',6),
('Fuse UI','2015-03-23','In Progress',7),
('Mass Update','2011-11-13','Not Started',8),
('Startup Investors','2019-10-27','Not Started',9);





INSERT INTO task(task_name,task_due_date,task_status,proj_id,assigned_emp_wrk_id,supervisior_manager_wrk_id) VALUES 
('CreateDB','2017-03-05','Abandoned',1,17,10),
('AIModule','2017-05-05','Abandoned',1,30,10),
('SVM','2018-03-05','Not Started',2,18,11),
('Data Modeling','2018-02-05','In Progress',2,24,11),
('Abstraction','2015-09-25','Not Started',3,19,12),
('Data Mining','2016-01-05','In Progress',3,25,12),   
('UI Mockup','2014-08-25','Not Started',4,20,13),
('ER Approval','2015-01-05','In Progress',4,26,13),   
('Rgression','2011-03-21','Abandoned',5,21,14),
('Code Changes','2011-01-05','In Progress',5,27,14),
('Router','2019-03-11','Completed',6,22,15),
('Candling','2019-07-05','In Progress',6,28,15);


Insert into proj_management (proj_id,manager_wrk_id) Values
(1,10),(2,11),(3,12),(4,13),(5,14),(6,15);



Insert into proj_tasks (proj_id,task_id) Values
(1,1),(1,2),(2,3),(2,4),(3,5),(3,6),(4,7),(4,8),(5,9),(5,10),(6,11),(6,12);

INSERT INTO worklog( desp, entry_date, hours,proj_id, task_id) VALUES 
('project is not required','2017-01-05',5,1,1),
('project is not required','2017-02-25',2,1,1),
('compelted poc','2017-01-05',25,1,2),
('project is not required','2017-02-25',2,1,2),
('waiting for inputs','2017-12-30',35,2,3),
('working on it','2018-01-15',23,2,3),
('data churning','2017-09-10',55,2,4),
('progress','2017-11-25',2,2,4),
('data input','2015-09-10',55,3,6),
('encapsualtion','2015-11-25',24,3,6),
('final draft','2013-07-30',35,4,7),
('bug fixing','2014-01-25',23,4,7),
('report sent','2014-03-11',55,4,8),
('approval pending','2015-01-01',24,4,8),
('Abandoned','2011-03-21',35,5,9),
('received code','2010-07-11',55,5,10),
('commit','2010-01-01',24,5,10),
('configuration','2018-10-30',87,6,11),
('Wiring','2019-01-14',23,6,11),
('Graph Analysis','2019-01-10',10,6,12),
('Package Sent','2019-02-25',24,6,12);

Insert into task_worklog (log_id,task_id,proj_id) Values
(1,1,1),(2,1,1),(3,2,1),(4,2,1),
(5,3,2),(6,3,2),(7,4,2),(8,4,2),
(9,6,3),(10,6,3),
(11,7,4),(12,7,4),(13,8,4),(14,8,4),
(15,9,5),(16,10,5),(17,10,5),
(18,11,6),(19,11,6),(20,12,6),(21,12,6);

INSERT INTO  perf_review(receiver_wrk_id,giver_wrk_id,perf_rating ) VALUES 
(17,10,1),(23,10,2),(30,10,3),
(18,11,4),(24,11,5),(31,11,1),
(19,12,2),(25,12,3),(32,12,4),
(20,13,5),(26,13,1),
(21,14,2),(27,14,3),
(16,15,4),(22,15,5),(28,15,1),(29,15,2),
(10,4,5),(15,9,5),(11,5,5),(12,6,5),(13,7,5),(14,8,5),
(4,1,5),(9,2,5),(5,3,5),(6,1,5),(7,2,5),(8,3,5);

INSERT INTO  yearly_review(year_id,perf_id, receiver_wrk_id,giver_wrk_id ) VALUES 
(2019,1,17,10),(2017,2,23,10),(2016,3,30,10),
(2013,4,18,11),(2014,5,24,11),(2018,6,31,11),
(2011,7,19,12),(2015,8,25,12),(2016,9,32,12),
(2010,10,20,13),(2016,11,26,13),(2012,12,21,14),
(2019,13,27,14),(2013,14,16,15);

INSERT INTO  yearly_bonus(year_id,bonus_id, receiver_wrk_id,giver_wrk_id ) VALUES 
(2019,1,17,10),(2013,2,23,4),(2014,3,18,11),(2019,4,24,5),
(2018,5,16,15),(2019,6,22,9), (2011,7,19,12),(2019,8,25,6),
(2019,9,21,14),(2015,10,27,8),(2016,11,20,7),(2017,12,26,13);