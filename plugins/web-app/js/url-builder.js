define([], () => {
    class UrlBuilder {
        constructor(baseUrl) {
            this.baseUrl = baseUrl;
        }

        viewAllPages() {
            return this.baseUrl + 'admin/';
        }

        createPage() {
            return this.baseUrl + 'admin/create-page.html';
        }

        updatePage(slug) {
            return this.baseUrl + 'admin/update-page.html?slug=' + slug;
        }

        renameSlug(slug) {
            return this.baseUrl + 'admin/rename-slug.html?slug=' + slug;
        }

        deletePage(slug) {
            return this.baseUrl + 'admin/delete-page.html?slug=' + slug;
        }

        viewPage(slug) {
            return this.baseUrl + 'index.html?slug=' + slug;
        }
    }

    return UrlBuilder;
});
