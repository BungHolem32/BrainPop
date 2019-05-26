## Brain Pop Backend Development Exam - Laravel

# Summary:

The goal of this exam is to create a working REST API for accessing and manipulating school
entities, using the Laravel PHP framework.

### Structure:
#### The Entities:

- Teachers: id, username, password, full name, email
- Students: id, username, password, full name, grade (0-12)
- Periods: id, name

#### Entities relationships:

- A period has only one teacher
- A teacher can teach several periods
- A student can be registered to several periods

## Required endpoints:  

- Full CRUD operations for all entities, including adding a student to a period and
  removing a student from a period.
- Fetch all students in a given period.
- Fetch all periods associated with a given teacher
- Fetch all students that are linked to a teacher via period
- Login capabilities for both teacher and student
- All responses should return a JSON.
- With the exception of create teacher and student, all endpoints are limited to
  authenticated users.


How To Use:

clone git repository by typing -> `git clone `


