# Simple Task Management Module

## Setup Instructions

```bash
git clone https://github.com/shubham1273/task_management.git
cd task_management
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev
php artisan serve


## Database Setup
make a database name taskmanager
locate taskmanager.sql file in the project  and import it
use credentials

email -> shubhamjaiswal1273@gmail.com
password -> 123456789