(function (blocks, element, components, editor, data) {
    var el = element.createElement;
    var __ = wp.i18n.__;
    var withSelect = wp.data.withSelect;

    blocks.registerBlockType('wordpress-portfolio/projects-portfolio', {
        title: __('Projects Portfolio', 'textdomain'),
        icon: 'portfolio',
        category: 'common',
        edit: withSelect(function (select) {
            return {
                projects: select('core').getEntityRecords('postType', 'projects', { per_page: -1 }),
            };
        })(function (props) {
            if (!props.projects) {
                return el('p', { className: props.className }, __('Loading...', 'textdomain'));
            }

            if (props.projects.length === 0) {
                return el('p', { className: props.className }, __('No projects found.', 'textdomain'));
            }

            return el('div', { className: props.className },
                el('ul', {}, props.projects.map(function (project) {
                    return el('li', {},
                        el('a', { href: project.link }, project.title.rendered)
                    );
                }))
            );
        }),
        save: function () {
            return null; // Rendered on the server
        },
    });
})(window.wp.blocks, window.wp.element, window.wp.components, window.wp.blockEditor, window.wp.data);