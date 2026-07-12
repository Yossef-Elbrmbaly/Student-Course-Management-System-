# Student Course Management System

A comprehensive web application designed to manage academic student records, built from scratch using raw **PHP** following the **MVC (Model-View-Controller)** architectural pattern and strict Object-Oriented Programming (OOP) principles[cite: 1, 10]. The system provides a seamless, secure, and intuitive control panel to manage students, academic departments, courses, and student course enrollment or dropping operations.

---

## Technologies Used

*   **Back-End:** PHP 8.x utilizing pure OOP and Namespaces.
*   **Database:** MySQL database managed securely using **PDO (PHP Data Objects)**.
*   **Front-End Stack:**
    *   **Bootstrap 5.3.3** for responsive and modern UI layout structures[cite: 12].
    *   **DataTables 2.0.8** to provide advanced client-side searching, sorting, and pagination functionality[cite: 14].
    *   **jQuery 3.7.1** to support client-side interactive scripts and DataTables integration[cite: 14].
    *   **Bootstrap Icons 1.11.3** for comprehensive visual iconography across dashboards[cite: 12].

---

## 🚀 Key Features

*   **Student Management:** Complete CRUD system to add, edit, delete, and view student records seamlessly by their assigned IDs.
*   **Academic Student Profile View:** A dedicated profile screen displaying basic communication data (Name, Email, Phone), the student's assigned department, and an active list of enrolled courses with direct functionality to drop any course.
*   **Department Management:** Manage academic departments (CRUD operations) with relational mapping to link students to their specific departments (One-to-Many relationship).
*   **Course Management:** Complete CRUD workflow for managing educational courses, including course names and academic codes.
*   **Smart Enrollment System:** Relate students to various courses (Many-to-Many relationship using a pivot table) with robust backend validation to prevent duplicate course enrollments.
*   **Data Security:** Full application immunity against SQL Injection attacks achieved by utilizing **Prepared Statements** across all model queries.

---

## Project Structure

The project code is strictly structured to ensure a clean separation of concerns:

├── config/
│   └── Database.php              # PDO Database configuration and connection setup
|
|
├── controllers/                  # Directs application logic and requests (Controllers)
│   ├── StudentController.php     # Handles student operations and profiles
│   ├── DepartmentController.php  # Handles academic department actions
│   ├── CourseController.php      # Handles course details and definitions
│   └── EnrollmentController.php  # Handles academic enrollment and dropping courses
|
|
├── models/                       # Manages database interactions and schemas (Models)
│   ├── Student.php               # Queries the 'students' table
│   ├── Department.php            # Queries the 'departments' table
│   ├── Course.php                # Queries the 'courses' table
│   └── Enrollment.php            # Queries the pivot 'course_student' table
|
|
├── views/                        # Responsive User Interface files (Views)
│   └── students/
│   |   ├── index.php             # Main student grid data table (powered by DataTables)
│   |   ├── create.php            # Form interface to add a new student
│   |   ├── edit.php              # Form interface to modify student details
│   |   └── show.php              # Detailed academic student profile dashboard
|   |
|   └── courses/
│   |   ├── index.php             # Lists all available academic course
│   |   ├── create.php            # Form interface to create and add a new course
│   |   ├── edit.php              # Form interface to modify course names and codes
|   |
|   | 
|   └── departments/
│   |   ├── index.php             # Lists all registered academic departments
│   |   ├── create.php            # Form interface to create a new department
│   |   ├── edit.php              # Form interface to update department details
│   |   
│   |                 
|   └── enrollments/
│   |   ├── index.php             # Displays active student-to-course registration logs
│   |   ├── create.php            # Form interface to enroll a student into a specific course
|
|
└── public/
    └── index.php                 # App entry point acting as the central router (Front Controller)               

---

## Database Schema

Create a local database named student_management and run the following SQL script to set up the structure matching the models:

CREATE DATABASE student_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_management;

-- 1. Academic Departments Table
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- 2. Students Table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

-- 3. Academic Courses Table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) NOT NULL
);

-- 4. Enrollment Pivot Table (Many-to-Many Relationship)
CREATE TABLE course_student (
    student_id INT,
    course_id INT,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

---

## Installation & Setup

1- Clone/Download the Project: Move your complete project directory into your local server root path (e.g., htdocs in XAMPP or www in WampServer).

2- Setup Database:
   - Open your local administration interface phpMyAdmin.
   - Create a new database named student_management.
   - Import or run the SQL queries provided above to create the required tables and constraints.  

3- Configure Database Connection: If your local server database user credentials vary from the defaults, adjust the connection string directly inside config/Database.php.

4- Run the Application:
   Access the system directory via your browser by pointing to the entry routing file:
   http://localhost/YOUR_PROJECT_FOLDER/public/index.php

---

## Routing System Reference

The application dynamically directs traffic using custom query parameters (page and action) passed via the URL to matching controller destinations:

    Target Page                                               URL Routing Format
Main Students Directory                             index.php?page=students&action=index  
Add New Student Form                                index.php?page=students&action=create  
Student Profile View                                index.php?page=students&action=show&id={ID}
Edit Student Form                                   index.php?page=students&action=edit&id={ID}
Departments Dashboard                               index.php?page=departments
Courses Dashboard                                   index.php?page=courses
Enrollments Management                              index.php?page=enrollments