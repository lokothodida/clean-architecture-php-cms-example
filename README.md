# "Cleanly Architected PHP CMS Example" [![Build Status](https://travis-ci.org/lokothodida/clean-architecture-php-cms-example.svg?branch=master)](https://travis-ci.org/lokothodida/clean-architecture-php-cms-example)
This project is an attempt at building the core of a Content Management System
(here realized as just a "Page Management System") obeying the principles of
Robert C. Martin's [Clean Architecture](https://8thlight.com/blog/uncle-bob/2012/08/13/the-clean-architecture.html).

# Installation
Requires

* PHP 7.1+
* [Composer](https://getcomposer.org/)
* [Make](https://en.wikipedia.org/wiki/Make_(software))

1. Run:

    ```
    make setup
    ```

2. Start a web server (e.g. at `localhost:8000`):

    ```
    php -S localhost:8000 -t foo/
    ```

3. Visit http://localhost:8000/plugins/web-app/ to view the web app.
4. Run tests:
    ```
    make test
    ```

# Project Structure
# `/application`
The core of the application. This houses the Entities and Use Cases: it guards
the central business rules and exposes a small API for communicating to the
entities.

One of the exposed API elements is a `PageRepository` interface, which expects
the logic of persisting a page when implemented.

# `/plugins`
All other functionality of the application is "plugged in" to the core as a
module.

## `/database`
Implements the `PageRepository` with a simple file based persistence mechanism.

## `/api-gateway`
Uses the "database" to expose "RESTful" endpoints to be used by the front end.

## `/web-app`
The web-facing interface. This has the pages of the front-end application: for
creating, updating, deleting and renaming pages, as well as viewing an
individual page.
