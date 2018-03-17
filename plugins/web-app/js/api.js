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
            body: JSON.stringify(body)
        }).then(handleJsonResponse);
    }

    function patch(url, body) {
        return fetch(url, {
            method: 'PATCH',
            body: JSON.stringify(body)
        }).then(handleJsonResponse);
    }

    function del(url, body) {
        return fetch(url, {
            method: 'PUT',
            body: JSON.stringify(body)
        }).then(handleJsonResponse);
    }

    function handleJsonResponse(response) {
        return response.json().then((data) => {
           if (response.status >= 400) {
               console.log(data.error);
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
                throw new Error('Failed to load pages');
            });
        }

        getPage(slug) {
            return get(this.baseUrl + '/pages/' + slug).catch((err) => {
                throw new Error('Failed to load page ' + slug);
            });
        }

        createPage(title, content) {
            return post(this.baseUrl + '/pages/', {
                title: title,
                content: content
            }).catch((err) => {
                throw new Error('Failed to create page');
            });
        }

        updatePage(slug, title, content) {
            return patch(this.baseUrl + '/pages/' + slug, {
                title: title,
                content: content
            }).catch((err) => {
                throw new Error('Failed to update page ' + slug);
            });
        }

        renameSlug(oldSlug, newSlug) {
            return post(this.baseUrl + '/pages/' + oldSlug, {
                slug: newSlug
            }).catch((err) => {
                throw new Error('Failed to rename slug of ' + oldSlug);
            });
        }

        deletePage(slug) {
            return del(this.baseUrl + '/pages/' + slug, {
            }).catch((err) => {
                throw new Error('Failed to delete page ' + slug);
            });
        }
    }

    return Api;
});
