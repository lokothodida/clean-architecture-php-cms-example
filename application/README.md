# Application Core
This houses the business and application rules.

# Entities
These are the business objects and value objects. In the case of this
application, there is only really one entity: the `Page`, and the `Slug`,
`Title` and `Content` are all value objects.

An example of one of the "business rules" is that slugs can only consist of
alphanumeric characters and hyphens. An example of one of the application rules
is that a slug cannot be renamed to that of a taken slug.

The `PageRepository` interface acts as a facade for persisted pages. Rather
than giving pages any knowledge of how they are persisted, it is the job of the
repository (and *only* the repository) to persist them. For the sake of the
tests, an `InMemoryPageRepository` is implemented, which simply keeps the pages
in an associative array.

# Use Cases
The use cases specify the different ways in which pages can be interacted with
by the users of the system. These cases include:

* User creates page
* User updates changes page content
* User renames page slug
* User deletes page

# Exercises
1. Create a guard for the page title (e.g. restrict the length or allowed characters)
2. Add a new property (e.g. Author, CreatedAt)