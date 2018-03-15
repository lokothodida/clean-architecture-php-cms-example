# "Cleanly Architected PHP CMS Example"
This project is an attempt at building the core of a Content Management System
(here realized as just a "Page Management System") obeying the principles of
Robert C. Martin's [Clean Architecture](https://8thlight.com/blog/uncle-bob/2012/08/13/the-clean-architecture.html).

The structure of the project is as follows:

# `/application`
The core of the application. This houses the Entities and Use Cases: it guards
the central business rules and exposes a small API for communicating to the
entities. The use cases include:

* Page creation (slug/id, title, content)
* Updating a page's title and content
* Renaming a page's slug
* Deleting a page

An example of one of the business rules is that slugs can only consist of
alphanumeric characters and hyphens. An example of one of the application rules
is that a slug cannot be renamed to that of a taken slug.

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

# Exercises
1. Use an API framework of your choice for the endpoints
2. Use a JS view model framework of your choice
3. Implement a different persistence mechanism (SQL, NoSQL, Contentful)