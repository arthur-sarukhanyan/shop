import UpdateForm from '../defaults/update.js';

$(document).ready(function (){
    const submitFormButton = '#filter-save';
    const formId = '#update-filter-form';
    const itemType = 'filters';
    let values = {
        id: item.id,
        name: item.name,
        attr_1: item.attr_1,
        attr_2: item.attr_2,
        filter_group_id: item.filter_group_id,
    };

    let form = new UpdateForm(submitFormButton, formId, itemType, values);
    let fields = [
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'text', key: 'attr_1', label: 'Attr 1'},
        {type: 'text', key: 'attr_2', label: 'Attr 2'},
        {type: 'select', key: 'filter_group_id', label: 'Filter group', data: list},
    ];

    form.setFormFields(fields);
    form.init();
});
