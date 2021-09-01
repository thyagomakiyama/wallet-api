up:
	@docker-compose up -d

build:
	@docker-compose up -d --build --force-recreate
	@docker exec app php artisan migrate

down:
	@docker-compose down

migrate:
	@docker exec app php artisan migrate
