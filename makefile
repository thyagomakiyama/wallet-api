up:
	@docker-compose up -d

build:
	@docker-compose up -d --build --force-recreate

stop:
	@docker-compose stop

down:
	@docker-compose down

migrate:
	@docker exec app php artisan migrate

test:
	@docker exec app vendor/bin/phpunit
