# URL Shorter  - Interview Task

A multi-tenant URL shortening service built with Laravel.

### 1. Install Laravel Installer
```bash
composer global require laravel/installer
```

### 2. Create New Project
```bash
laravel new interview_task

```bash
composer install
npm install
```

### 3. Configure Environment
- Rename `.env.example` to `.env`
- Set database credentials in `.env`:
  ```env
  DB_DATABASE=test
  DB_USERNAME=root
  DB_PASSWORD=
  ```

### 4. Database Migration & Seeding

```bash
php artisan migrate:fresh --seed
```

### 5. Run the Project
```bash
php artisan serve
```
`http://127.0.0.1:8000`

---

## Default Credentials

| Role | Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `superadmin@admin.com` | `12345678` |
| **Admin** | (As invited by SuperAdmin) | `password123` |
| **Member** | (As invited by Admin) | `password123` |

---

## Features & Rules
- **Super Admin**: Can create companies and invite the first Admin. Can view all links. Cannot create links.
- **Admin**: Can create short URLs and invite others to their own company. Can see only company links.
- **Member**: Can create short URLs. Can see only their own links.
- **Public Redirect**: All short URLs are publicly accessible via `/s/{code}`.

---

## Development Notes
- **Logic & Design**: All core backend logic including role assignments, multi-tenant company structure, and security validations were implemented logically by myself.
- **CSS**: ChatGPT was used to design the simple and clean UI.
- **Troubleshooting**: During development, I faced an issue where member links were not being generated properly or restricted correctly to the owner. This issue was resolved with the help of the **Google Antigravity tool**.

