import UpdateForm from '../defaults/update.js';

$(document).ready(function (){
    const submitFormButton = '#filter-group-save';
    const formId = '#update-filter-group-form';
    const itemType = 'filter-groups';
    let values = {
        id: item.id,
        name: item.name,
    };

    let form = new UpdateForm(submitFormButton, formId, itemType, values);
    let fields = [
        {type: 'text', key: 'name', label: 'Name'},
    ];

    form.setFormFields(fields);
    form.init();
});
