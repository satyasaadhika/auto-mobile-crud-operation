# Priyanshu Maurya Autos - CRUD Web Application

A simple web application for tracking automobiles built with **PHP**, **MySQL**, and **Bootstrap**. This project demonstrates basic **CRUD (Create, Read, Update, Delete)** operations with session-based authentication.

---

## Overview

This application allows users to manage automobile records. Users can:

- Log in securely using a predefined email and password  
- Add new automobile records  
- Edit existing records  
- Delete records  
- View all records in a responsive table  

All actions are logged with status messages and proper session handling to ensure a smooth user experience.

---

## Features

- **User Authentication:** Login system with password validation and session management  
- **Add Automobile:** Add new autos with `Make`, `Model`, `Year`, and `Mileage`  
- **Edit Automobile:** Update existing records with form validation  
- **Delete Automobile:** Confirm and delete records securely  
- **Dashboard:** View all automobile records with edit and delete options  
- **Responsive Design:** Built with **Bootstrap 3/5** for modern UI  
- **Status Messages:** Informative feedback for all operations  

---

## Technologies Used

- **PHP** - Backend scripting  
- **MySQL / MariaDB** - Database for storing automobile records  
- **PDO (PHP Data Objects)** - Secure database interaction  
- **Bootstrap** - Responsive UI design  
- **HTML / CSS** - Frontend markup and styling  
---

## Setup & Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/satyasaadhika/auto-mobile-crud-operation.git

2. **Set up the database:**

- Create a database called crud_db in phpMyAdmin or MySQL.

- Create a table autos using:
```bash 
CREATE TABLE autos (
    auto_id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(255),
    model VARCHAR(255),
    year INT,
    mileage INT
);
 ```
 3. **Configure PHP:**

- Ensure XAMPP / WAMP / Laragon is installed and running
- Place the project folder inside the htdocs (or www) directory
- Update PDO credentials in PHP files if needed

4. **Access the application:**

- Open a browser and go to: http://localhost/auto-mobile-crud-operation/login.php

5. **Login Credentials:**

- Email: any email
- Password: php123

