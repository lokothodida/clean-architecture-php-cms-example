define([], () => {
    class Template {
        constructor(template) {
            this.template = template;
        }

        render(variables) {
            let template = this.template;

            for (let variable in variables) {
                template = template.replace(new RegExp('{{ ' + variable + ' }}', 'g'), variables[variable]);
            }

            return template;
        }
    }

    return Template;
});