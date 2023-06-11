## Project Title: Credit Management System

Tech Stack:
- Backend: Laravel v10 (PHP framework)
- Frontend: Tailwind
- Database: MySQL
- Version Control: Git (with GitHub repository)

Installation:
1. Clone the repository: `git clone <repository-url>`
2. Run `composer install`
3. Run `npm install`
4. Run `npm run build`
5. Configure database connection in the `.env` file
6. Configure the maximum credit amount per client in .env file. You can see in .env.example: MAX_CREDIT_AMOUNT_PER_USER. Default is 80000.
7. Run database migrations: `php artisan migrate`
8. Run `php artisan key:generate`
9. Start the server: `php artisan serve`
10. Access the application in your web browser at `http://localhost:8000`
