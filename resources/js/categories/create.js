$(document).ready(function (){
    var counter = 0;

    if (page === 'categories-create') {
        counter = addCreateForm(counter);
    }

    $('#add-category-create-form').on('click', function () {
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

    $('#categories-save').on('click', function () {
        submitCreateForm();
    });
});

let addCreateForm = function (counter) {
    let container = `<div class="category-create create-form-${counter}">
        <div class="create-form-actions">
            <button class="btn btn-danger remove-form" data-counter="${counter}">-</button>
        </div>
    </div>`;

    let fields = [
        $.createFormElement('text', `name-${counter}`, 'Name'),
        $.createFormElement('categoriesSelect', `parent_id-${counter}`, 'Parent category', list),
    ];

    let pointer = $('#create-categories-form');
    pointer.append(container);

    for (let field of fields) {
        $('.create-form-' + counter).append(field);
    }

    return ++counter;
}

let submitCreateForm = function () {
    let data = $.getFormData($('#create-categories-form'));

    $.ajax({
        type: 'POST',
        url: '/admin/categories/create',
        data: data,
        success: function (res) {
            window.location.href = '/admin/categories';
        },
        error: function (err) {
            let messages = JSON.parse(err.responseText);
            $.displayValidationErrors(messages.errors);
        }
    });
}
