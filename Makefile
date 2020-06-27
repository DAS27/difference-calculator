install:
	composer install

console:
	composer exec psysh

lint:
	composer exec phpcs -- --standard=PSR12 src tests

lint-fix:
	composer exec phpcbf -- --standard=PSR12 src tests

test:
	composer phpunit tests

test-coverage:
	composer phpunit tests -- --coverage-clover build/logs/clover.xml