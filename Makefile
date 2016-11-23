it: cs test

composer:
	composer self-update
	composer validate
	composer install

coverage: composer
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text --columns max

cs: composer
	vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --diff

integration: composer
	vendor/bin/phpunit --configuration=test/Integration/phpunit.xml --columns max

test: unit integration

unit: composer
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml --columns max
