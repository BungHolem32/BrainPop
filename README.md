# Brain Pop Backend Development Exam - Laravel

## Summary:

The goal of this exam is to create a working REST API for accessing and manipulating school
entities, using the Laravel PHP framework.

### Structure:

##### The Entities:

- Teachers: id, username, password, full name, email
- Students: id, username, password, full name, grade (0-12)
- Periods: id, name

##### Entities relationships:

- A period has only one teacher
- A teacher can teach several periods
- A student can be registered to several periods

### Required endpoints:  

- Full CRUD operations for all entities, including adding a student to a period and
  removing a student from a period.
- Fetch all students in a given period.
- Fetch all periods associated with a given teacher
- Fetch all students that are linked to a teacher via period
- Login capabilities for both teacher and student
- All responses should return a JSON.
- With the exception of create teacher and student, all endpoints are limited to
  authenticated users.


### Basic Assumptions:
 - All requests except authentication endpoints required jwt-token authentication.
 - each period has teacher_id related to him so he can edit each period that assigned to him
 - role ids added for compatible (1 -admin , 2- teacher ,3 - user )
 
### Permissions:
Users:
- Teacher can: 
  
  - see all periods attached to him.
  - manipulate his own period.
  - manipulate his own entity. (teacher) 

- Student can:

  - manipulate his own entity.
  - add himself into a period.
  - remove himself from a period.
    
- Admin can:
  - do anything.  
  
### Api documentation:  

Click on the following [link](https://documenter.getpostman.com/view/895124/S1TR6La3?version=latest#intro) to see api documentations

### Installation:

#### Summary: 

1.  this project was build with the following: 
    - Laravel framework
    - Laradock - A full PHP development environment for Docker
    
    For more information on how to install Laradock, follow this [link](https://laradock.io/getting-started/) 

In case you want to insert this project inside your local environment follow these steps:

- open terminal
- cd into your selected project folder
- clone git repository by typing -> `git clone https://github.com/BungHolem32/BrainPop.git`
- type `cp .env.example .env`
- edit your db setting  in the '.env' file

```
APP_NAME=BrainPop
APP_ENV=local
APP_KEY=base64:hEf4mI1sljMa7nE6YoI2LGCwbtMYqD4Ec4vOKjT1b0o=
APP_DEBUG=true
APP_URL=http://laravel.local

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST={host_name}
DB_PORT=3306
DB_DATABASE={database_name}
DB_USERNAME={database_username}
DB_PASSWORD={databse_password}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=z1vn8ZLxTeSYMdQOwOHajPER3bgih47xp8N9DpSxpxPSuWQfvRjUvq4f4beyuW5D
```

- create database name according to the setting below
- type composer install
- migrate all tables, seed some data by typing `artisan migrate --seed`
- type `artisan serve`
- click on this  [http://localhost:8000](http://localhost:8000]) and you ready to go.

