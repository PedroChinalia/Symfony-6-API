# Symfony 6 API

## Setup

Run ``` $ composer install ``` to install dependencies

To initialize the server run ``` $ symfony server:start ```

To migrate the database run ``` $ php bin/console doctrine:migrations:migrate ```

Be sure to name your database  "symfonyapi" or change the config in the .env file

# API Commands

### GET
<strong>Get all users:</strong> url + /api/user

<strong>Get user by id:</strong> url + /api/user/$id

### POST
<strong>Create new user:</strong> url + /api/user 

<strong>Body:</strong> form-data: {Key: name, email, password}, {Value: $name, $email, $password}

### PUT
<strong>Update user:</strong> url + /api/user/$id

<strong>Body:</strong> x-www-form-urlencoded: {Key: name, email, password}, {Value: $name, $email, $password}

### DELETE
<strong>Delete user:</strong> url + /api/user/$id 
