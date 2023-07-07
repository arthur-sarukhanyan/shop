import CreateForm from '../defaults/create.js';

$(document).ready(function (){
    const addFormButton = '#add-filter-group-create-form';
    const submitFormButton = '#filter-groups-save';
    const formContainerClass = 'filter-group-create';
    const formId = '#create-filter-groups-form';
    const itemType = 'filter-groups';

    let form = new CreateForm(addFormButton, submitFormButton, formContainerClass, formId, itemType);
    let fields = [
        {type: 'text', key: 'name', label: 'Name'}
    ];

    form.setFormFields(fields);
    form.init();
});
