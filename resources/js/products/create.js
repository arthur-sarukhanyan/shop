import CreateForm from '../defaults/create.js';

$(document).ready(function (){
    const addFormButton = '#add-product-create-form';
    const submitFormButton = '#products-save';
    const formContainerClass = 'product-create';
    const formId = '#create-products-form';
    const itemType = 'products';
    const multiField = '#category_id';

    let form = new CreateForm(addFormButton, submitFormButton, formContainerClass, formId, itemType, multiField);
    let fields = [
        {type: 'image', key: 'image', label: 'Image'},
        {type: 'categoriesSelect', key: 'category_id', label: 'Categories', data: list},
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'textarea', key: 'description', label: 'Description'},
        {type: 'number', key: 'price', label: 'Price'},
    ];

    form.setFormFields(fields);
    form.init();
    form.setImageHandler();
});
