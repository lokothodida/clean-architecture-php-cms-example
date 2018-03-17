setup:
	composer install

test: phpcs phpspec

phpcs:
	vendor/bin/phpcs --standard=PSR2 Http ./index.php

phpcbf:
	vendor/bin/phpcbf --standard=PSR2 Http ./index.php

phpspec:
	vendor/bin/phpspec run
