(function (blocks, i18n, element, components) {
    var SelectControl = components.SelectControl;
    var blockStyle = { padding: '1px' };

    var el = element.createElement; // The wp.element.createElement() function to create elements.

    blocks.registerBlockType('easy-contact-form-builder/index', {
        title: 'GrandWP Forms',

        icon: 'feedback',

        category: 'easy-contact-form-builder',

        attributes: {
            form_id: {
                type: 'string'
            }
        },

        edit: function (props) {


            var focus = props.focus;

            props.attributes.form_id =  props.attributes.form_id &&  props.attributes.form_id != '0' ?  props.attributes.form_id : false;

            return el(
                SelectControl,
                {
                    label: 'Select GrandWP Form',
                    value: props.attributes.form_id ? parseInt(props.attributes.form_id) : 0,
                    instanceId: 'gd-forms-selector',
                    onChange: function (value) {
                        props.setAttributes({form_id: value});
                    },
                    options: gdformsbuilderblock.gdforms,
                }
            );

        },

        save: function (props) {
            return el('p', {style: blockStyle}, '[gdfrm_form id="'+props.attributes.form_id+'"]');
        },
    });
})(
    window.wp.blocks,
    window.wp.i18n,
    window.wp.element,
    window.wp.components
);