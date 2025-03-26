# 🏆 Tournament Management API 🎮

## 📋 Project Overview

A comprehensive Laravel-powered API for tournament management, designed to streamline tournament organization, player registration, and match tracking.

---

## 🛠 Project Architecture

### 🔧 Technical Stack
- **Framework**: ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
- **Database**: ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
- **Authentication**: ![Laravel Sanctum](https://img.shields.io/badge/Laravel%20Sanctum-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
- **Testing**: ![PHPUnit](https://img.shields.io/badge/PHPUnit-777BB4?style=for-the-badge&logo=php&logoColor=white)

### 🔒 Security Features
- Secure authentication via Laravel Sanctum
- Input validation and protection against common web vulnerabilities
- Middleware-based endpoint protection

---

## 🚦 API Endpoints

### 🔐 Authentication Endpoints
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/register` | 👤 User Registration |
| `POST` | `/api/login` | 🔓 User Login |
| `POST` | `/api/logout` | 🚪 User Logout |
| `GET` | `/api/user` | 📋 Get User Profile |

### 🏁 Tournament Management
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/tournaments` | 🆕 Create Tournament |
| `GET` | `/api/tournaments` | 📜 List Tournaments |
| `GET` | `/api/tournaments/{id}` | 🔍 Tournament Details |
| `PUT` | `/api/tournaments/{id}` | ✏️ Update Tournament |
| `DELETE` | `/api/tournaments/{id}` | 🗑️ Delete Tournament |

### 👥 Player Registration
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/tournaments/{tournament_id}/players` | 📝 Register Player |
| `GET` | `/api/tournaments/{tournament_id}/players` | 📋 List Tournament Players |
| `DELETE` | `/api/tournaments/{tournament_id}/players/{player_id}` | ❌ Unregister Player |

### 🏸 Match Management
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/matches` | 🆕 Create Match |
| `GET` | `/api/matches` | 📜 List Matches |
| `GET` | `/api/matches/{id}` | 🔍 Match Details |
| `PUT` | `/api/matches/{id}` | ✏️ Update Match |
| `DELETE` | `/api/matches/{id}` | 🗑️ Delete Match |
| `POST` | `/api/matches/{id}/scores` | 📊 Add Match Scores |
| `PUT` | `/api/matches/{id}/scores` | 🔢 Update Match Scores |

---

## 🧪 Testing Strategy

### 🔬 Test-Driven Development (TDD)
- Comprehensive test coverage using PHPUnit
- Unit and integration tests for all endpoints
- Automated testing in CI/CD pipeline

---

## 📚 Documentation

### 🌐 API Documentation
- Swagger/OpenAPI specification
- Detailed request/response examples
- Interactive API documentation

---

## 🔒 Security Principles

1. 🛡️ Input Validation
2. 🔐 Authentication Middleware
3. 🚫 Prevention of SQL Injection
4. 🛡️ Cross-Site Scripting (XSS) Protection

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.1+
- Composer
- PostgreSQL
- Laravel 10+

### Installation
```bash
# Clone the repository
git clone https://github.com/yourusername/tournament-api.git

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate

# Run tests
php artisan test
```

---

## 🤝 Contributing
1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

---

## 📄 License
![License](https://img.shields.io/badge/License-MIT-yellow.svg)

Made with ❤️ by Mahjoubech