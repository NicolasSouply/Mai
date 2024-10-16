# Mai restaurant
Maï is a final year project at 3W Academy. I developed this website to showcase the restaurant and facilitate takeout orders and table reservations. It also includes a login feature and a back-end section for site management. This project is a training assignment and is not intended for commercial use. The images used in this project are not free to use and may be subject to copyright restrictions.

## Online Version
An online version of the site is available at: [mai-restaurant](https://mai-restaurant.alwaysdata.net/index.php?route=home)

### Test credentials:
Email: JohnDoe@test.com
Password: Test01@test01

## Prerequisites
Before you begin, ensure you have the following software installed on your system:

- Wamp
- Composer
- Node.js

## Installation 
### Cloning the GitHub repository:

Copy the git clone code

https://github.com/NicolasSouply/Mai.git

### Using Wamp

Clone the GitHub repository into the `www` directory of your Wamp installation:

1. Make sure Wamp is running and the Apache server is started.

### Configuring Environment Variables

Create a `.env` file in the project root and configure it with your database information:

#### Database Info

```plaintext
DB_NAME="project"
DB_USER="johnDoe"
DB_PASSWORD="YourPassword"
DB_CHARSET="utf8"
DB_HOST="localhost"
````
Replace DB_USER, DB_PASSWORD, and DB_NAME with your own database credentials.

## Database setup
### Installing Composer (for PHP dependencies)
Import the project's database into your database management system (e.g., phpMyAdmin):

- Open phpMyAdmin or your preferred database management tool.
- Create a new database named project.
- Import the provided SQL file into the newly created database.

### Installing PHP Dependencies
Navigate to the project directory and install PHP dependencies using Composer:

```plaintext
composer install
````
update dependencies

```plaintext
composer update
````
### Installing JavaScript Dependencies
Navigate to the project directory and install JavaScript dependencies using npm:

```plaintext
npm install
````
### Running the Project
Ensure that Wamp is running and the Apache server is started. Open your web browser and navigate to http://localhost/your-project-directory.

### Troubleshooting
Wamp Issues: Ensure that no other programs are using the same port as Apache (usually port 80). Composer Issues: Make sure you have the latest version of Composer installed. Node.js Issues: Ensure that Node.js and npm are correctly installed and their versions are up to date.

### License
This project is licensed under the MIT License.
