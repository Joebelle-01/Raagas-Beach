# 🏖️ Raagas Beach Resort Setup Guide

This guide provides a comprehensive step-by-step walkthrough to set up and run the **Raagas Beach Resort** system on a new computer.

---

## 🛠️ 1. Prerequisites

Before starting, ensure the following software is installed on the target computer:

1. **PHP (version 8.2 or higher)**:
   * Make sure the `sqlite3`, `pdo_sqlite`, `bcmath`, `curl`, and `mbstring` extensions are enabled in your `php.ini`.
2. **Composer**: The PHP dependency manager.
3. **Node.js & npm (LTS Version)**: Used for compiling TailwindCSS/Vite frontend assets.
4. **GitHub Desktop**: To clone and manage the repository easily.

---

## 🚀 2. Step-by-Step Setup

### Step 1: Clone the Repository via GitHub Desktop
1. Open **GitHub Desktop** on the new computer.
2. Click on **File** > **Clone repository...** (or press `Ctrl + Shift + O`).
3. Select the **URL** tab, enter the repository link: `https://github.com/Joebelle-01/Raagas-Beach.git`, choose your desired local folder path, and click **Clone**.
4. Once cloned, click the **Open in Terminal** or **Open in VS Code** button in GitHub Desktop to open the project workspace.

---

### Step 2: Set Up the Environment Configuration (`.env`)
Laravel uses a `.env` file to store environment settings.
1. Open your terminal in the project directory.
2. Copy the example configuration file to create your active environment file:
   * **On Windows (PowerShell)**:
     ```powershell
     Copy-Item .env.example .env
     ```
   * **On Windows (Command Prompt)**:
     ```cmd
     copy .env.example .env
     ```
   * **On macOS/Linux**:
     ```bash
     cp .env.example .env
     ```

---

### Step 3: Install Backend (Composer) Dependencies
Install all Laravel framework dependencies:
```bash
composer install
```

---

### Step 4: Install Frontend (NPM) Dependencies
Install Vite, TailwindCSS, and other client-side tools:
```bash
npm install
```

---

### Step 5: Generate the Application Encryption Key
Generate a secure encryption key for your local application instance:
```bash
php artisan key:generate
```

---

### Step 6: Create and Initialize the SQLite Database
The system uses a highly portable, lightweight SQLite database.
1. Create a blank database file:
   * **On Windows (PowerShell)**:
     ```powershell
     New-Item -ItemType File -Path database/database.sqlite -Force
     ```
   * **On Windows (Command Prompt)**:
     ```cmd
     type nul > database\database.sqlite
     ```
   * **On macOS/Linux**:
     ```bash
     touch database/database.sqlite
     ```
2. Run the database migrations and seed the database with signature cottages, admin users, and mock payments:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

### Step 7: Create the Public Storage Symlink
This step is **critical** for cottage images and payment proofs to load successfully on the website:
```bash
php artisan storage:link
```
> [!IMPORTANT]
> If a directory named `public/storage` already exists on the new computer, delete it first before running the `storage:link` command to avoid duplicate or broken symbolic link targets.

---

## 💻 3. Running the System Locally

To run the application, you need to start **two servers** simultaneously: the frontend compiler (Vite) and the backend processor (Laravel).

### 1. Start the Frontend Development Server (Vite)
Open a terminal in the project folder and run:
```bash
npm run dev
```
*(Leave this terminal window open running in the background).*

### 2. Start the Backend Development Server (Laravel Artisan)
Open a **second terminal** window in the project folder and run:
```bash
php artisan serve
```
*(Leave this terminal window open running in the background).*

### 3. Open in Browser
Now, open your browser and navigate to:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔐 4. Default Login Credentials

Once seeded, you can log in immediately using the following accounts:

* **Administrator Portal**:
  * **Email**: `admin@raagas.com`
  * **Password**: `password`
* **Staff Portal**:
  * **Email**: `staff@raagas.com`
  * **Password**: `password`

---

## 💡 Troubleshooting

* **Broken cottage or receipt images**:
  * Run `php artisan storage:link` again.
  * Make sure `APP_URL` in your `.env` is set to `http://127.0.0.1:8000`.
* **Changes in styles not appearing**:
  * Keep the terminal running `npm run dev` active. It listens to file modifications and injects changes in real-time.
  * Run `php artisan view:clear` to clear compiled cache templates.
