import CreateForm from '../defaults/create.js';

$(document).ready(function (){
    const addFormButton = '#add-filter-create-form';
    const submitFormButton = '#filters-save';
    const formContainerClass = 'filter-create';
    const formId = '#create-filters-form';
    const itemType = 'filters';

    let form = new CreateForm(addFormButton, submitFormButton, formContainerClass, formId, itemType);
    let fields = [
        {type: 'select', key: 'filter_group_id', label: 'Filter group', data: list},
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'text', key: 'attr_1', label: 'Attr 1'},
        {type: 'text', key: 'attr_2', label: 'Attr 2'},
    ];

    form.setFormFields(fields);
    form.init();
});
