$(document).ready(function (){
    let container = $('#delete-modal');
    let id;

    $('.delete.actions').on('click', function () {
        id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        let text = `<p>Are you sure you want to delete Product ${name}?</p>`;

        let modalBody = container.find('.modal-body');

        modalBody.empty();
        modalBody.append(text);
        container.modal('show');
    });

    container.find('button.confirm').on('click', function () {
        submitDelete(id);
    });

    let submitDelete = function () {
        $.ajax({
            type: 'DELETE',
            url: '/admin/products/delete/' + id,
            success: function () {
                window.location.href = '/admin/products';
            },
            error: function (err) {
                let messages = JSON.parse(err.responseText);
                $.displayValidationErrors(messages.errors);
            }
        });
    }
});
