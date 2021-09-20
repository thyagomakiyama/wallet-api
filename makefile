up:
	@docker-compose up -d

build:
	@docker-compose up -d --build --force-recreate
	@docker exec app php html/artisan migrate

stop:
	@docker-compose stop

down:
	@docker-compose down

migrate:
	@docker exec app php html/artisan migrate

test:
	@docker exec app html/vendor/bin/phpunit
