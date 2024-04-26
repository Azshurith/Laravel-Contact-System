# 🌟 Laravel Docker 🐋 Environment with Artisan 🌟

[![License](https://img.shields.io/badge/license-GNU-blue.svg)](https://github.com/Azshurith/Dockerized-Laravel-Environment-Artisan/blob/main/LICENSE)

This repository contains a Docker environment for Laravel applications utilizing Artisan for streamlined development and deployment.

## 🛠️ Makefile Commands

```makefile
help                 Displays all available Commands
project_start        Starts the Project
project_stop         Stops the Project
project_destroy      Deletes the Project
```

## 📝 Environment Variables (.env)

Ensure to set up your environment variables in the .env file.

```dotenv
# Docker Configuration
PROJECT_NAME=
PROJECT_VERSION=1.0
PROJECT_REPOSITORY=

# Php Configurations
PHP_DOCKERFILE=.docker/Php/

# Database Configurations
MARIADB_CONNECTION=mysql
MARIADB_HOST=host.docker.internal
MARIADB_PORT=3306
MARIADB_DATABASE=Laravel
MARIADB_USERNAME=laravel
MARIADB_PASSWORD=laravel
MARIADB_DOCKERFILE=.docker/MariaDB/

# PhpMyAdmin Configurations
PHPMYADMIN_DOCKERFILE=.docker/PhpMyAdmin/
```
## 🚀 Getting Started

### Prerequisites 🛠️

- Docker: Install Docker on your system if you haven't already. You can download it [here](https://www.docker.com/get-started).

### Installation 📦

1. Copy the `.env.sample` and setup the variables thru executing `cp .env.sample .env`.
2. Start the docker project thru executing the command `make project_start`.
3. Download laravel project thru executing the command `make project_create`.
4. Shutdown docker thru running `make project_stop`.
5. Start docker thru running `make project_start`.
6. Access your Laravel application at http://localhost:8000.

## Contributing 🤝

Contributions are welcome! If you'd like to contribute to this project, please follow the [Contributing Guidelines](CONTRIBUTING.md).

## License 📝

This project is licensed under the GNU GENERAL PUBLIC LICENSE - see the [LICENSE](LICENSE) file for details.

## Acknowledgments 🙏

Special thanks to the open-source community for their valuable contributions and inspiration.

## Contact 📧

For questions or feedback, please feel free to reach out:

- GitHub: [Devitrax](https://github.com/Azshurith)

<p align="center">
  Made with ❤️ by Devitrax
</p>
