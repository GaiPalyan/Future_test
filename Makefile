start:
	php artisan serve --host 0.0.0.0
setup:
	composer install
	cp -n .env.example .env || true
	touch database/database.sqlite || true
	php artisan key:gen --ansi
migrate:
	php artisan migrate
seed:
	php artisan migrate:refresh
	php artisan db:see
log:
	tail -f storage/logs/laravel.log
clear:
	php artisan route:clear
	php artisan view:clear
	php artisan cache:clear
	php artisan config:clear
test:
	php artisan config:clear
	php artisan test
analyse:
	composer phpstan
lint:
	composer phpcs
lint-fix:
	composer phpcbf
