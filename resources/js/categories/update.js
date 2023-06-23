$(document).ready(function (){
    let container = $('#update-category-form');


    addCreateForm(container);
    initValues(item, container);

    $('#category-save').on('click', function () {
        submitUpdateForm(item.id);
    });
});

let addCreateForm = function (container) {
    let fields = [
        $.createFormElement('text', `name`, 'Name'),
        $.createFormElement('categoriesSelect', `parent_id`, 'Parent category', list),
    ];

    for (let field of fields) {
        container.append(field);
    }
}

let initValues = function (item, container) {
    container.find('#name').val(item.name);
    container.find('#parent_id').val(item.parent_id);
}

let submitUpdateForm = function (id) {
    let data = $.getFormData($('#update-category-form'));

    $.ajax({
        type: 'POST',
        url: '/admin/categories/update/' + id,
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
