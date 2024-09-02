Containerizing PHP,Apache, and MySQL
===================================
### steps to follow Execution 
1.docker pull mysql

2.docker compose up

3.docker compose down

### PHP CRUD application

We'll use the following PHP application to demonstrate everything:

"dump.sql" creates a table 'employees' in the mydb database. 

"config.php" connects the php code with the 'employees' table of mydb database.

"index.php" creates the frontend grid which displays records from "employees" table.

"create.php" generates web form that is used to insert records in the employees table.

"read.php" retrieves the records from the employees table.

"update.php" updates records in employees table.

"delete.php" deletes records in employees table.

"error.php" will be displyed if a request is invalid.

