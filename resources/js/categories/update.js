import UpdateForm from '../defaults/update.js';

$(document).ready(function (){
    const submitFormButton = '#category-save';
    const formId = '#update-category-form';
    const itemType = 'categories';
    let values = {
        id: item.id,
        name: item.name,
        parent_id: item.parent_id,
    };

    let form = new UpdateForm(submitFormButton, formId, itemType, values);
    let fields = [
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'categoriesSelect', key: 'parent_id', label: 'Parent category', data: list},
    ];

    form.setFormFields(fields);
    form.init();
});
