$(document).ready(function (){
    var counter = 0;

    if (page === 'products-create') {
        counter = addCreateForm(counter);
    }

    $('#add-product-create-form').on('click', function () {
        counter = addCreateForm(counter);
    });

    $('body').on('click', '.remove-form', function (e) {
        e.preventDefault();
        if (counter === 1) {
            return;
        }

        let number = $(this).attr('data-counter');
        $('.create-form-' + number).remove();
        --counter;
    });

    $('body').on('change', '#create-products-form input[type="file"]', function (e) {
        let files = $(this)[0].files;
        if (files.length) {
            $(this).parent().find('img')[0].src = window.URL.createObjectURL(files[0]);
        }
    });

    $('#products-save').on('click', function () {
        submitCreateForm();
    });
});

let addCreateForm = function (counter, data = []) {
    let container = `<div class="product-create create-form-${counter}">
        <div class="create-form-actions">
            <button class="btn btn-danger remove-form" data-counter="${counter}">-</button>
        </div>
    </div>`;
    let fields = [
        $.createFormElement('image', `image-${counter}`, 'Image'),
        $.createFormElement('categoriesSelect', `category_id-${counter}`, 'Categories', list),
        $.createFormElement('text', `name-${counter}`, 'Name'),
        $.createFormElement('textarea', `description-${counter}`, 'Description'),
        $.createFormElement('number', `price-${counter}`, 'Price'),
    ];

    let pointer = $('#create-products-form');
    pointer.append(container);

    for (let field of fields) {
        $('.create-form-' + counter).append(field);
    }

    $.makeMultiSelect($('#category_id-' + counter));

    return ++counter;
}

let submitCreateForm = function () {
    let data = $.getFormData($('#create-products-form'));

    $.ajax({
        type: 'POST',
        url: '/admin/products/create',
        processData: false,
        contentType: false,
        data: data,
        success: function (res) {
            // window.location.href = '/admin/products';
        },
        error: function (err) {
            let messages = JSON.parse(err.responseText);
            $.displayValidationErrors(messages.errors);
        }
    });
}
