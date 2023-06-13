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
    let options = $.sortSelectOptions(list, []);

    let fields = [
        `<div class="mb-3">
            <label for="name-${counter}" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-${counter}" name="name-${counter}">
        </div>`,
        `<div class="mb-3">
            <label for="parent_id-${counter}" class="form-label">Parent category</label>
            <select class="form-select form-control" id="parent_id-${counter}" name="parent_id-${counter}">
              <option selected disabled>Choose parent category</option>
              ${options}
            </select>
            <div class="form-text">We'll never share your email with anyone else.</div>
        </div>`,
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
