# Student Registration System

Beginner-friendly PHP + MySQL CRUD app for XAMPP or Homebrew MySQL.

## Project Folder

Place the folder here if you are using XAMPP:

`htdocs/student_crud`

For this workspace, the project is already in:

`PHP/student_crud`

## 1. Install PHP and MySQL with Homebrew

```bash
brew install php
brew install mysql
```

## 2. Start MySQL

```bash
brew services start mysql
```

## 3. Create the database and table

Use either phpMyAdmin or the MySQL command line.

### Option A: MySQL command line

```bash
mysql -u root
```

Then run:

```sql
SOURCE /full/path/to/PHP/student_crud/setup.sql;
```

### Option B: phpMyAdmin

Open phpMyAdmin and import `setup.sql`.

`setup.sql` only creates the `student_db` database and `students` table. It does not create extra MySQL users, which keeps the import simple and avoids privilege errors.

## 4. Database credentials

The app first tries:

- `root` with `Root@12345!`
- `root` with blank password
- `root` with `root`
- `student_user` with `student123`

If your MySQL password is different, edit `db.php` and replace the first password with your actual root password.

## 5. Run the app

Go to the project folder:

```bash
cd /Users/ameynitintarmale/Desktop/FSDL/PHP/student_crud
php -S localhost:8000
```

Open in browser:

```text
http://localhost:8000/index.php
```

If you are using Apache/XAMPP, place the folder in `htdocs` and use:

```text
http://localhost/student_crud
```

## 6. Files

- `index.php` - form page
- `insert.php` - insert logic
- `display.php` - show records
- `update.php` - update contact number
- `delete.php` - delete record
- `db.php` - database connection
- `style.css` - simple styling
- `setup.sql` - database and table creation
