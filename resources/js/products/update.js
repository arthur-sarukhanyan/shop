$(document).ready(function (){
    let container = $('#update-product-form');

    let values = [];
    item.categories.map(function (category) {
        values.push({inner: category.name, value: category.id})
    });

    addCreateForm(container, values);
    initValues(item, container, values);

    $('#product-save').on('click', function () {
        submitUpdateForm(item.id);
    });

    $('body').on('change', '#update-product-form input[type="file"]', function (e) {
        let files = $(this)[0].files;
        if (files.length) {
            $(this).parent().find('img')[0].src = window.URL.createObjectURL(files[0]);
        }
    });
});

let addCreateForm = function (container, data = []) {

    let fields = [
        $.createFormElement('image', `image`, 'Image'),
        $.createFormElement('categoriesSelect', `category_id`, 'Categories', list),
        $.createFormElement('text', `name`, 'Name'),
        $.createFormElement('textarea', `description`, 'Description'),
        $.createFormElement('number', `price`, 'Price'),
    ];

    for (let field of fields) {
        container.append(field);
    }

    $.makeMultiSelect($('#category_id'), data);
}

let initValues = function (item, container, values) {
    container.find('img').attr('src', item.image.path);
    container.find('#name').val(item.name);
    container.find('#description').val(item.description);
    container.find('#price').val(item.price);

    $.setMultiSelectValues($('#category_id'), values);
}

let submitUpdateForm = function (id) {
    let data = $.getFormData($('#update-product-form'));

    $.ajax({
        type: 'POST',
        url: '/admin/products/update/' + id,
        processData: false,
        contentType: false,
        data: data,
        success: function (res) {
            window.location.href = '/admin/products';
        },
        error: function (err) {
            let messages = JSON.parse(err.responseText);
            $.displayValidationErrors(messages.errors);
        }
    });
}
