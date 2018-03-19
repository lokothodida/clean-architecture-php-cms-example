setup:
	composer install

test: phpcs phpspec

phpcs:
	vendor/bin/phpcs --standard=PSR2 Adapters ViewModel

phpcbf:
	vendor/bin/phpcbf --standard=PSR2 Adapters ViewModel

phpspec:
	vendor/bin/phpspec run
