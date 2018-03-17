# API Gateway (RESTful API)
This layer communicates to the database and exposes some simple endpoints for
managing page resources over HTTP.

These endpoints can be tested through [Postman](https://www.getpostman.com/)
using the exported `postman.json` file.

# Endpoints
## `GET /pages`
Gets a list of pages

## `GET /pages/:slug`
Gets an individual page

## `POST /pages`
Creates a page

## `PATCH /pages/:slug`
Updates a page

## `POST /pages/:slug`
Renames a page slug

## `DELETE /pages/:slug`
Deletes a page

# Exercises
1. Reimplement the API Gateway using a framework of your choice, preserving the
   endpoint structure (e.g. `Laravel`, `Symfony`, `Slim`, etc...)