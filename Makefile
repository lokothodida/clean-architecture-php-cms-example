setup: setup-application setup-plugins
test: test-application test-plugins

setup-application:
	cd application && make setup

setup-plugins: setup-database setup-api-gateway setup-web-app

setup-database:
	cd plugins/database && make setup

setup-api-gateway:
	cd plugins/api-gateway && make setup

setup-web-app:
	cd plugins/web-app

test-application:
	cd application && make test

test-plugins: test-database

test-database:
	cd plugins/database && make test