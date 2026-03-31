# Valex Billing System

## 📌 Overview

**Valex** is a billing collection and management system designed to help businesses handle invoice payments efficiently.
It allows organizations to manage clients, services, invoices, and track payment statuses with detailed reporting and analytics.

---

## 🚀 Features

### 🏢 Company & Client Management

* Manage companies and institutions
* Assign services (products) to each company
* Track all related invoices

### 💼 Services (Products)

* Define services provided by companies
* Associate each service with billing operations

### 🧾 Invoice Management

* Create, update, and delete invoices
* Track invoice statuses:

  * Paid
  * Unpaid
  * Partially Paid
* Archive invoices for future reference

### 📊 Reports & Analytics

* Customer reports
* Invoice reports
* Dashboard with charts and statistics

### 📁 Export Options

* Export invoices as:

  * PDF
  * Excel

### 🔔 Notifications System

*  notifications for:

  * Adding invoices
  * Updating invoices
  * Deleting invoices
  * Archiving invoices
* Includes user name and action details

### 👥 User Roles & Permissions

* Role-based access control using **Spatie Laravel Permission**
* Assign permissions to users بسهولة
* Secure and flexible authorization system

---

## 🛠️ Technologies Used

* PHP (Laravel Framework)
* MySQL
* JavaScript
* Bootstrap
* Chart libraries (for dashboard analytics)

---

## ⚙️ Installation

1. Clone the repository:

```bash
git clone https://github.com/MOHAMED-ADEL-MA/Valex-billing-system.git
```

2. Navigate to the project directory:

```bash
cd Valex-billing-system
```

3. Install dependencies:

```bash
composer install
npm install
```

4. Copy `.env` file:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Configure your database in `.env`

7. Run migrations:

```bash
php artisan migrate
```

8. Start the server:

```bash
php artisan serve
```

---



## 📈 Future Improvements

* Online payment integration
* Advanced reporting filters
* Multi-language support
* API for mobile integration

---



## 📄 License

This project is open-source and available under the MIT License.

---

## 👨‍💻 Author

Developed by Mohamed Adel

---
