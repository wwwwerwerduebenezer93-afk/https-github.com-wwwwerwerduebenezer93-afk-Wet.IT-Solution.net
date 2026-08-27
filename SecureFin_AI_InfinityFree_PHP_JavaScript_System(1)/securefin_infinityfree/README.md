# SecureFin AI — Financial Services Security Prototype

An academic, InfinityFree-ready PHP/MySQL application using HTML, CSS and JavaScript (often casually called “Java” in web projects). It demonstrates email verification, password hashing, one-time login codes, live-camera enrollment, QR identity links, audit logging and explainable transaction-risk scoring.

> This is a learning prototype, not a bank or payment processor. It never moves real money. A qualified security professional must review it before any real-world use.

## Included security controls

- `password_hash()`/`password_verify()` and strong-password rules
- Expiring email-verification links; only their SHA-256 hashes are stored
- Expiring six-digit OTP after the password step; only an HMAC is stored
- Lockout for 15 minutes after five failed password attempts
- PDO prepared statements, output escaping and CSRF tokens
- Secure, HttpOnly, SameSite session cookie and 30-minute inactivity expiry
- Live camera capture requiring HTTPS and browser consent
- Server-side image type/size validation; private folder blocks web access
- Random QR identity link that reveals only a masked name and verified status
- Admin role checks and privacy-preserving IP audit hashes
- Explainable risk scoring: amount, transaction time and short-term velocity

## InfinityFree installation

1. Create an InfinityFree account, hosting account, domain/subdomain and MySQL database.
2. In phpMyAdmin, select the new database and import `database.sql`.
3. Copy `config.example.php` to `config.php`. Enter the database host, name, username, password and your exact HTTPS site URL.
4. Generate `app_secret` locally, for example: `php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"`.
5. Keep `dev_show_tokens` false on a public site.
6. Upload the contents of this folder into InfinityFree’s `htdocs` folder using its file manager or FTP. Do not upload your `.git` folder.
7. Confirm HTTPS works, then register and test camera permission, email verification, OTP and QR scanning.

InfinityFree’s PHP `mail()` support/deliverability may be restricted. If messages do not arrive, connect a reputable SMTP provider with PHPMailer. Never expose SMTP passwords in GitHub; place them in the ignored `config.php` or hosting secrets.

To make your account an administrator after registration, run this in phpMyAdmin with your own email:

```sql
UPDATE users SET role='admin' WHERE email='you@example.com';
```

## GitHub deployment

GitHub is excellent for storing and presenting the source. Push the project but never commit `config.php` or captured images. GitHub Pages cannot run PHP/MySQL, so it can host only a static project page; the functioning application belongs on InfinityFree or another PHP host.

```bash
git init
git add .
git commit -m "Initial SecureFin AI prototype"
git branch -M main
git remote add origin https://github.com/YOUR-NAME/securefin-ai.git
git push -u origin main
```

## Test checklist

- Registration rejects weak passwords and duplicate email.
- An expired verification token fails.
- Password login leads to OTP rather than immediate access.
- Five wrong passwords temporarily lock the account.
- Camera denial is handled without blocking registration.
- QR scan reveals no email, photo, balance or password.
- High-value or rapid transactions are held for review.
- A normal user receives HTTP 403 on `admin.php`.
- `config.php`, `database.sql` and uploaded images cannot be downloaded.

## Production improvements

Use SMTP with delivery monitoring; encrypt sensitive profile data at rest; add recovery codes and TOTP/WebAuthn; rotate QR tokens; add consent/retention/deletion workflows for identity images; add rate limiting at the web server; replace the illustrative risk rules with a validated, monitored model; conduct privacy, bias, threat-model and penetration-testing reviews; follow Bank of Ghana and Ghana Data Protection Act obligations where applicable.

## Project structure

`includes/` contains the security/bootstrap layer, `assets/` contains CSS and JavaScript, `uploads/private/` stores blocked camera images, and the root PHP pages implement the user flow. `database.sql` creates the database tables.
