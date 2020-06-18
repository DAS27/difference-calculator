install:
	composer install

console:
	composer exec psysh

lint:
	composer exec phpcs -- --standard=PSR12 src bin

lint-fix:
	composer exec phpcbf -- --standard=PSR12 src

test:
	composer phpunit tests

test-coverage:
	composer phpunit tests -- --coverage-clover build/logs/clover.xml