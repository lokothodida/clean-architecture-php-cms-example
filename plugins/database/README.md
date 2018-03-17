# Database
This layer of the application implements the `PageRepository` so that pages
can be persisted.

Currently it implements a `JsonPageRepository` which serializes the page into
a JSON file. The file system is further abstracted away using a `FileSystem`
interface so that the `JsonPageRepository` can be tested without touching the
actual file system.

There is also a `PagePresenterRepository` which is used for getting the page
data in a presentable way for other APIs (rather than directly using the `Page`
entity).

# Exercises
1. Implement another local flat-file repository (e.g. `XmlPageRepository`)
2. Implement a relational database page repository (e.g.`MySqlPageRepository`)
3. Implement a non-relational database page repository
   (e.g. `MongoDbPageRepository`)
4. Implement a repository which communicates to some external service
   (e.g. `ContentfulPageRepository`)
