define([], () => {
    class MockApi {
        constructor() {
            this.pages = [
                {
                    slug: 'test-title',
                    title: 'Test title',
                    content: 'Test Content'
                }
            ];
        }

        getAllPages() {
            return new Promise((resolve, reject) => {
                resolve(this.pages);
            });
        }

        getPage(slug) {
            return new Promise((resolve, reject) => {
                resolve(this.pages[0]);
            });
        }

        createPage(title, content) {
            return new Promise((resolve, reject) => {
                reject('Not implemented');
            });
        }

        updatePage(slug, title, content) {
            return new Promise((resolve, reject) => {
                reject('Not implemented');
            });
        }

        renameSlug(oldSlug, newSlug) {
            return new Promise((resolve, reject) => {
                reject('Not implemented');
            });
        }
    }

    return MockApi;
});
