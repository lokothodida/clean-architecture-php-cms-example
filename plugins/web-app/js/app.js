define([
    'api',
    'template',
    'url-builder'
], (Api, Template, UrlBuilder) => {
    return {
        api: new Api('/plugins/api-gateway'),
        urlBuilder: new UrlBuilder('/plugins/web-app/'),
        urlParams: new URLSearchParams(window.location.search),
        template: (selector) => {
            return new Template(document.querySelector(selector).innerHTML);
        }
    }
});
