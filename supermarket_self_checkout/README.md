# SmartMart Secure Supermarket Self-Checkout

A responsive PHP/MySQL system for customer self-checkout, verified registration, live camera capture, receipt QR codes, product stock, payments, receipts, audit logging and administrator product management.

## Run with XAMPP on Windows

1. Extract the ZIP into `C:\xampp\htdocs\smartmart`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open `http://localhost/phpmyadmin`, choose **Import**, and import `install.sql`.
4. Open `http://localhost/smartmart/` in Chrome or Edge and allow camera access.
5. Register. In demonstration mode, the six-digit verification code is shown on screen.
6. To make your account an administrator, run this in phpMyAdmin (replace the email):
   `UPDATE smartmart.users SET role='admin', verified_at=NOW() WHERE email='you@example.com';`

## Real email and SMS verification

`DEMO_VERIFICATION` is enabled in `config.php`. Before production, set it to `false` and connect an email service (SMTP/PHPMailer) and an SMS provider (Hubtel, Arkesel or another provider) in the registration section of `api.php`. Never display the OTP in production.

## Deployment and security notes

- Upload the extracted files to `htdocs`/`public_html`; create a MySQL database and update the four database constants in `config.php`.
- Camera access requires HTTPS except on `localhost`.
- The system uses password hashing, prepared SQL statements, CSRF protection, short-lived OTP hashes, session renewal, database transactions and role checks.
- Add payment-provider callbacks before accepting real Mobile Money/card payments. The supplied checkout records a simulated successful payment for testing.
- For production, keep uploads outside the public web root or deny script execution in that folder, enforce HTTPS, enable secure session cookies, configure backups, and use environment variables for secrets.

## Default data

The installer adds six sample products. No default administrator password is included, preventing a known credential from being abused.
