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
        console.log(counter);
        if (counter === 1) {
            return;
        }

        let number = $(this).attr('data-counter');
        $('.create-form-' + number).remove();
        --counter;
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

    return ++counter;
}

let submitCreateForm = function () {
    let data = $.getFormData($('#create-products-form'));

    $.ajax({
        type: 'POST',
        url: '/admin/products/create',
        data: {list:data},
        success: function (res) {
            console.log(res);
        },
        error: function (err) {
            let messages = JSON.parse(err.responseText);
            displayValidationErrors(messages.errors);
        }
    });
}

let displayValidationErrors = function (messages) {
    console.log(messages);

    let container = $('.errors');
    container.empty();

    for (let key in messages) {
        for (let error of messages[key]) {
            container.append(`<p>${error}</p>`);
        }
    }
}
