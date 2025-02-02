phpstan:
	docker compose exec web vendor/bin/phpstan analyse src

bash:
	docker compose exec web bash

clear-cache:
	docker compose exec web bin/console cache:clear

tests:
	docker compose exec web bin/phpunit
