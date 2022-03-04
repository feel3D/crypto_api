start:
	docker-compose up -d --build

stop:
	docker-compose down

bash:
	docker-compose exec php /bin/bash

migrate:
	docker-compose exec php bin/console doctrine:migrations:migrate

fixture:
	docker-compose exec php bin/console doctrine:fixtures:load
