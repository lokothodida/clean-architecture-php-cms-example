/* global fetch */
define([], () => {
    function get(url, body) {
        return fetch(url, {
            method: 'GET',
        }).then(handleJsonResponse);
    }

    function post(url, body) {
        return fetch(url, {
            method: 'POST',
            body: createFormData(body)
        }).then(handleJsonResponse);
    }

    function createFormData(body = {}) {
        const formData = new FormData();

        for (let param in body) {
            formData.append(param, body[param]);
        }

        return formData;
    }

    function handleJsonResponse(response) {
        return response.json().then((data) => {
           if (response.status >= 400) {
               throw new Error(data.error);
           }

           return data.data;
        });
    }

    class Api {
        constructor(baseUrl) {
            this.baseUrl = baseUrl;
        }

        getAllPages() {
            return get(this.baseUrl + '/').catch((err) => {
                console.log(err);
                throw new Error('Failed to load pages');
            });
        }

        getPage(slug) {
            return get(this.baseUrl + '/?action=view-page&slug=' + slug).catch((err) => {
                console.log(err);
                throw new Error('Failed to load page ' + slug);
            });
        }

        createPage(title, content) {
            return post(this.baseUrl + '/?action=create-page', {
                action: 'create-page',
                title: title,
                content: content
            }).catch((err) => {
                console.log(err);
                throw new Error('Failed to create page');
            });
        }

        updatePage(slug, title, content) {
            return post(this.baseUrl + '/?action=update-page&slug=' + slug, {
                action: 'update-page',
                title: title,
                content: content
            }).catch((err) => {
                console.log(err);
                throw new Error('Failed to update page ' + slug);
            });
        }

        renameSlug(oldSlug, newSlug) {
            return post(this.baseUrl + '/?action=rename-slug&slug=' + oldSlug, {
                action: 'rename-slug',
                slug: newSlug
            }).catch((err) => {
                console.log(err);
                throw new Error('Failed to rename slug of ' + oldSlug);
            });
        }

        deletePage(slug) {
            return post(this.baseUrl + '/?action=delete-page&slug=' + slug, {
                action: 'delete-page',
            }).catch((err) => {
                console.log(err);
                throw new Error('Failed to delete page ' + slug);
            });
        }
    }

    return Api;
});
