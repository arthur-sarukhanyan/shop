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

let addCreateForm = function (counter) {
    let container = `<div class="product-create create-form-${counter}">
        <div class="create-form-actions">
            <button class="btn btn-danger remove-form" data-counter="${counter}">-</button>
        </div>
    </div>`;
    let fields = [
        `<div class="mb-3">
            <img src="/images/no-image.jpg" alt="your image" />
            <label for="image-${counter}" class="form-label">Image</label>
            <input accept="image/*" type="file" id="image-${counter}" name="image-${counter}"/>
        </div>`,
        createCategoriesSelect(counter),
        `<div class="mb-3">
            <label for="name-${counter}" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-${counter}" name="name-${counter}">
        </div>`,
        `<div class="mb-3">
            <label for="description-${counter}" class="form-label">Description</label>
            <textarea class="form-control" id="description-${counter}" name="description-${counter}"></textarea>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>`,
        `<div class="mb-3">
            <label for="price-${counter}" class="form-label">Price</label>
            <input type="number" class="form-control" id="price-${counter}" name="price-${counter}">
        </div>`,
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
            window.location.href = '/admin/products';
        },
        error: function (err) {
            let messages = JSON.parse(err.responseText);
            displayValidationErrors(messages.errors);
        }
    });
}

let displayValidationErrors = function (messages) {
    let container = $('.errors');
    container.empty();

    for (let key in messages) {
        for (let error of messages[key]) {
            container.append(`<p>${error}</p>`);
        }
    }
}

let createCategoriesSelect = function (counter) {
    let options = $.sortSelectOptions(list, []);

    return `<div class="mb-3">
                <label for="category_id-${counter}" class="form-label">Category</label>
                <select class="form-select form-control" id="category_id-${counter}" name="category_id-${counter}">
                  <option selected disabled>Choose category</option>
                  ${options}
                </select>
            </div>`;
}
