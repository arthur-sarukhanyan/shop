import UpdateForm from '../defaults/update.js';

$(document).ready(function (){
    const submitFormButton = '#product-save';
    const formId = '#update-product-form';
    const itemType = 'products';
    const multiField = '#category_id';
    let values = {
        id: item.id,
        name: item.name,
        description: item.description,
        price: item.price,
        img: null,
        category_id: [],
    };

    for (let category of item.categories) {
        values.category_id.push({id: category.id, name: category.name});
    }

    if (item.image) {
        values.img = item.image.path;
    }
    console.log(values);
    let form = new UpdateForm(submitFormButton, formId, itemType, values, multiField);
    let fields = [
        {type: 'image', key: 'image', label: 'Image'},
        {type: 'categoriesSelect', key: 'category_id', label: 'Categories', data: listCategories},
        {type: 'text', key: 'name', label: 'Name'},
        {type: 'textarea', key: 'description', label: 'Description'},
        {type: 'number', key: 'price', label: 'Price'},
        {type: 'select', key: 'filter_id', label: 'Filters', data: listFilterGroups},
    ];

    form.setFormFields(fields);
    form.init();
    form.setImageHandler();

    let filtersData = [];
    for (let filterGroup of listFilterGroups) {
        let children = [];
        let obj = {
            text: filterGroup.name,
        };

        if (filterGroup.filters && filterGroup.filters.length) {
            for (let filter of filterGroup.filters) {
                children.push({id: filter.id, text: filter.name})
            }
        }

        obj.children = children;
        filtersData.push(obj);
    }

    $('#filter_id').empty();
    $('#filter_id').select2({
        multiple: true,
        data: filtersData,
    });

    let filters = [];
    for (let filter of item.filters) {
        filters.push(filter.id);
    }

    $('#filter_id').val(filters).trigger('change');
});
