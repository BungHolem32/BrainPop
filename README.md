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

### Endpoints:

#### specific endpoints:
  ```
1. {yourhost:port}/api/periods/{period_id}/students
   
    Fetch all students in a given period
   
    - Method: GET
    - Params: `Query`=> ['period_id'] integer, `Query` => ['token'] valid jwt-token from login results
 
2. `{yourhost:port}/api/teachers/{teacher_id}/periods` 

    Fetch all periods associated with a given teacher
    
    - Method: GET
    - Params: `Url` => ['teacher_id'] integer, `Query` => ['token'] valid jwt-token from login results
 
3. `{yourhost:port}/api/linked_users` 
    
    Fetch all students that are linked to a teacher via period

    - Method: GET
    - Params: `Query` => ['token'] valid jwt-token from login results

CRUD ENDPOINTS

1. `localhost/api/teachers`
 
   Fetch all teachers.
   
   - Method: GET
   - Params: `Query` => ['token'] valid jwt-token from login results

2. `localhost/api/teachers/{teacher_id}`

    Fetch specific teacher according to his id.
    
    - Method: GET
    - Params: `Url` => ['teacher_id'] integer, `Query` => ['token'] valid jwt-token from login results
    
3. `localhost/api/teachers`
  
   Store new teacher
   
   - Method: POST
   - Params: `Body` => ['username','password','full_name','metadata["email"]'], `Query` => ['token'] valid jwt-token from login results
  
4. `localhost/api/teachers/{teacher_id}` 
  
   Update teacher
  
  - Method: PUT
  - Params: `Url` ['teacher_id'], `Body` => ['username','password','full_name','metadata["email"]'], `Query` => ['token'] valid jwt-token from login results
  
  
5. `localhost/api/teachers/{teacher_id}` 
  
   Destroy teacher
   
   - Method: Delete
   - Params: `Url` ['teacher_id'], `Query` => ['token'] valid jwt-token from login results
   ```
   
   

### How To Use:

- open terminal
- cd into your selected project folder
- clone git repository by typing -> `git clone https://github.com/BungHolem32/BrainPop.git`
- type `cp .env.exmple .env`

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
- edit your info in the '.env' file
- you will need to create database according to your setting below
- type composer install
- for migration and seeds type `artisan migrate --seed`
- you are ready to go

