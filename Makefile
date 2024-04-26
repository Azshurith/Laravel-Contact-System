# Include Environment Variables
include .env

php_deploy: ## Execute Command to Server Container
	docker exec -it -u root ${PROJECT_NAME}-php /bin/bash

php_start: ## Start PHP Server
	docker exec -it -u root ${PROJECT_NAME}-php php artisan serve --host 0.0.0.0 --port 8000

php_migrate: ## Run Database Migrations
	docker exec -it -u root ${PROJECT_NAME}-php php artisan migrate:refresh

php_flush: ## Clear Artisan Config
	docker exec -it -u root ${PROJECT_NAME}-php php artisan optimize:clear

php_route: ## Clear Artisan Config
	docker exec -it -u root ${PROJECT_NAME}-php	php artisan route:list -v

project_create: ## Execute Command to Server Container
	docker exec -it -u root ${PROJECT_NAME}-php composer create-project laravel/laravel .

project_start: ## Starts the Project
	docker compose up -d

project_stop: ## Stops the Project
	docker compose down

project_destroy: ## Deletes the Project
	docker compose down -v
	docker rmi ${PROJECT_NAME}
