up:
	@docker-compose up -d

build:
	@docker-compose up -d --build --force-recreate
	@docker exec app php artisan migrate

stop:
	@docker-compose stop

down:
	@docker-compose down

migrate:
	@docker exec app php artisan migrate

test:
	@docker exec app vendor/bin/phpunit
