# Acme Widget Co ThriveCart (MVC)

## Overview
This proof-of-concept implements the Acme Widget Co sales system using an MVC architecture. It demonstrates:
- A basket with an add method and a total method (that applies delivery and offer rules).
- Dependency injection and the strategy pattern for offers.
- Use of Composer for dependency management, PHPUnit for testing, PHPStan for static analysis, and Docker/Docker Compose for containerization.

## Folder Structure
(See the provided folder structure above.)

## Setup Instructions

1. **Install Dependencies:**
   ```bash
   composer install

2. **Run on local server:**
    ```bash
    php -S localhost:8080 -t public