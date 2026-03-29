# HR Management Dashboard

A modern, multi-role HR management system built with Laravel that streamlines employee management, leave requests, and payroll operations.

## Key Features

- **Multi-Role Authentication**: Separate dashboards for Admin, HR Manager, and Employee with role-based access control
- **Employee Management**: Complete CRUD operations for employee profiles, departments, and job positions
- **Leave Management**: Employees can request leaves; HR managers can approve or reject requests
- **Payroll System**: Track and manage employee payroll information
- **Holiday Calendar**: Configure and manage company holidays
- **Job History Tracking**: Maintain employee career progression and job changes
- **Profile Management**: Users can update personal profiles and change passwords
- **Real-time Dashboard**: Analytics and insights for HR managers

## Problem & Solution

### Problems Addressed
1. **Fragmented HR Processes**: Manual, scattered employee data management across multiple systems
2. **Inefficient Leave Approval**: No centralized workflow for leave requests leading to delays
3. **Complex Payroll Operations**: Difficulty tracking and managing employee salaries and benefits
4. **Limited Visibility**: HR managers lack real-time insights into workforce data
5. **Role Management**: No clear separation of access and permissions between roles

### Solutions Implemented
- **Centralized Dashboard**: Unified platform for all HR operations with role-based views
- **Automated Workflow**: Streamlined leave request and approval process with notifications
- **Database-Driven Payroll**: Organized payroll management with proper data relationships
- **Analytics Dashboard**: Real-time metrics and employee statistics for decision-making
- **Middleware Protection**: Custom authentication middleware ensures only authorized users access role-specific features

## Tech Stack

| Layer | Technologies |
|-------|--------------|
| **Backend** | Laravel 11, PHP 8.2+ |
| **Frontend** | Blade, Tailwind CSS, Alpine.js |
| **Build Tool** | Vite |
| **Database** | SQLite/MySQL |
| **Authentication** | Laravel Breeze |
| **Notifications** | PHP Flasher |

## Quick Start

```bash
# Clone repository
git clone <repository-url>
cd laravel_pro

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate

# Build assets
npm run build

# Run development server
php artisan serve
npm run dev
```

## Project Structure

```
laravel_pro/
├── app/Http/Controllers/
│   ├── hr_manager/          # HR Manager controllers
│   ├── employee/            # Employee controllers
│   └── admin/               # Admin controllers
├── routes/
│   ├── hr_manager_auth.php  # HR Manager routes
│   ├── employee_auth.php    # Employee routes
│   └── admin_auth.php       # Admin routes
├── resources/views/
│   ├── hr_manager/          # HR Manager templates
│   ├── employee/            # Employee templates
│   └── auth/                # Authentication views
└── database/
    ├── migrations/
    └── seeders/
```

## Access the Application

| Role | URL | Default Login |
|------|-----|----------------|
| **Admin** | `/admin/login` | Configure via migration |
| **HR Manager** | `/hr-manager/login` | Configure via migration |
| **Employee** | `/login` | Configure via migration |

## Future Enhancements

- Email notifications for leave requests
- Advanced reporting and export features
- Performance appraisal system
- Attendance tracking module
  
## License

MIT License - feel free to use this project for learning and development purposes.

---

**Built as a learning project** to demonstrate Laravel best practices, role-based access control, and modern HR system architecture.

⚠️ Project Focus: This is a dedicated HR Manager Dashboard
All core functionalities and features are built specifically for HR department operations 
and HR manager workflows. The system is optimized for managing employees, leaves, payroll, 
and other HR-specific tasks.


https://github.com/user-attachments/assets/5a977292-5c44-495e-a41e-19b504917ff6

