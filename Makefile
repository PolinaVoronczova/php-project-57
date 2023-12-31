install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec phpunit tests -- --coverage-clover ./build/logs/coverage.xml