# 🐾 Paws Haven - Dog Adoption Platform

**Paws Haven** is a full stack web application that allows users to register, log in, upload dogs for adoption, filter through available dogs by breed, training, or medical status, and view their adoption history.

## 📂 Technologies Used

### Frontend
- HTML5
- CSS3 / Bootstrap 5
- JavaScript (Fetch API)

### Backend
- PHP (REST-style)
- PostgreSQL
- PHP Sessions for authentication

### Database Design
- `Owner` table: stores user credentials and profile information.
- `Dog` table: contains all dog details including optional medical records and uploaded image paths.
- `Adoption` table: links dogs to their owners (adopters).
  
## 📦 Features

- ✅ User registration and login system (passwords hashed securely)
- ✅ Session-based authentication
- ✅ Dog upload form (with image upload and optional medical info)
- ✅ Image preview and storage under `/assets/` folder
- ✅ Adoption filtering by:
  - Breed (dropdown populated from DB)
  - Training status
  - Medical records presence
- ✅ Modal view for detailed medical info
- ✅ Logged-in user can view their full adoption history
- ✅ Protection of routes and actions for non-authenticated users

## 📸 File Upload

- Images are uploaded using a `FormData` object and stored under the `/assets/` directory.
- If deploying to production (e.g., Railway or similar), consider using a remote storage solution (Firebase, AWS S3) for public accessibility.

## 🧠 Session Logic

- PHP `$_SESSION` is used to store the user's ID and username after successful login.
- Pages validate session existence before performing any sensitive actions (like uploading or adopting).

## 🛡 Security Measures

- Passwords are hashed using `password_hash()`.
- PDO with prepared statements is used throughout to prevent SQL injection.
- Custom error responses and status codes ensure robustness.

## 🧪 Example Routes & Files

| Route                     | Description                                 |
|--------------------------|---------------------------------------------|
| `Register.html`          | Registration form                           |
| `Login.html`             | Login form                                  |
| `Put_up_for_adoption.html` | Upload dog form                            |
| `GetAdoptionHistory.html` | Shows user's adoption history              |
| `Dogs.html`              | Displays all adoptable dogs with filters    |

## 🚀 Deployment Notes

- Make sure `/assets` is included on the server and writable (`chmod 777` for testing).
- Will be deployed to Railway
