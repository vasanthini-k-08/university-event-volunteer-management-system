# ITUM Event Volunteer Management System

A starter PHP/MySQL web application for the Institute of Technology, University of Moratuwa (ITUM).
This is an independent academic project starter, not an official university system.

## Technology
- HTML5, CSS3, JavaScript
- PHP 8+
- MySQL / MariaDB
- Apache (XAMPP)

## Setup (XAMPP)
1. Extract `ITUM_Event_Volunteer_Management_System.zip`.
2. Copy the `ITUM_Event_Volunteer_Management_System` folder into `C:\xampp\htdocs\`.
3. Start **Apache** and **MySQL** in the XAMPP Control Panel.
4. Open `http://localhost/phpmyadmin`.
5. Import `database/itum_volunteer.sql`.
6. Open `config/database.php` and confirm the database settings:
   - host: `localhost`
   - database: `itum_volunteer`
   - username: `root`
   - password: empty (default XAMPP setting)
7. Visit `http://localhost/ITUM_Event_Volunteer_Management_System/`.
8. Create a student account using **Register**.
9. Create the first administrator:
   - Visit `http://localhost/ITUM_Event_Volunteer_Management_System/setup_admin.php`
   - Email: `admin@itum.local`
   - Password: `ChangeMe@123`
   - Then log in and change the password immediately.
10. **Delete `setup_admin.php` after creating the administrator.**

## Roles
- Admin: create events, review volunteer applications, assign tasks, view attendance.
- Organizer: view assigned events, manage tasks and attendance.
- Student/Volunteer: register, browse events, apply, view tasks, submit feedback.

## Important notes
- This is a learning/MVP project. Review and test it before any real deployment.
- Change the default database credentials and administrator password.
- Use HTTPS, secure session settings, backups, and proper access controls before deployment.
- Email notifications, QR attendance, certificates, and advanced reporting are not included yet.
