# TuneCenter

TuneCenter is a web application designed to assist music creators in their projects, providing an organized environment to store all the essential elements of the musical-creative process in one place. In addition to storage functionality, the platform facilitates collaboration among multiple creators in the same project.

## Installation Guide

Follow these steps to set up and run TuneCenter on your local machine:

1. **Download the source code**  
   Clone the repository from GitHub or download the ZIP file.

2. **Install Composer dependencies**  
   Run `composer install` in the root directory of the project.  
   This will install all PHP dependencies required for the Laravel backend.

3. **Install Node dependencies**  
   Run `npm install` in the root directory of the project.  
   This will install all JavaScript dependencies required for the Vue.js frontend.

4. **Build the frontend assets**  
   Run `npm run build`.  
   This compiles and bundles the frontend assets for production.

5. **Link storage**  
   Run `php artisan storage:link`.  
   This creates a symbolic link from `public/storage` to `storage/app/public` for public accessibility.

6. **Configure environment variables**  
   Duplicate the `.env.example` file and rename it to `.env`. The only important configurations that need to be changed are the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` fields. Adjust these values to match your database setup.

7. **Generate application key**  
    Run `php artisan key:generate`.
    This generates a new application key, which is used by Laravel to encrypt sensitive data.

8. **Run database migrations**  
   Run `php artisan migrate`.  
   This sets up the database tables required by the application.

9. **Start the Laravel development server**  
   Run `php artisan serve`.  
   This starts the local development server on `http://localhost:8000`.

## About the Developer

Connect with me:

- [GitHub](https://github.com/juanburillo)
- [LinkedIn](https://linkedin.com/in/juan-burillo)

Feel free to reach out for any questions or collaboration opportunities!

---

Thank you for using TuneCenter. Let's make music together!
