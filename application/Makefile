setup:
	composer install

test: phpcs phpspec

phpcs:
	vendor/bin/phpcs --standard=PSR2 Entities Infrastructure UseCases

phpcbf:
	vendor/bin/phpcbf --standard=PSR2 Entities Infrastructure UseCases

phpspec:
	vendor/bin/phpspec run
