import CreateForm from '../defaults/create.js';

$(document).ready(function (){
    const addFormButton = '#add-category-create-form';
    const submitFormButton = '#categories-save';
    const formContainerClass = 'category-create';
    const formId = '#create-categories-form';
    const itemType = 'categories';

    let form = new CreateForm(addFormButton, submitFormButton, formContainerClass, formId, itemType);
    let fields = [
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'categoriesSelect', key: 'parent_id', label: 'Parent category', data: list},
    ];

    form.setFormFields(fields);
    form.init();
});
