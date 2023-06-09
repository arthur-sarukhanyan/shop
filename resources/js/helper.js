$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json',
    }
});

$.getFormData = function (form) {
    let serialized = form.serialize();
    let items = serialized.split('&');

    let data = [];
    for (let item of items) {
        let parts = item.split('=');
        if (parts[0] === '_token') {
            continue;
        }

        let iteratorParts = parts[0].split('-');
        let iterator = iteratorParts[iteratorParts.length - 1];
        let key = parts[0].replace('-' + iterator, '');

        if (data[iterator] === undefined) {
            data[iterator] = {};
        }
        data[iterator][key] = decodeURI(parts[1]);
    }

    return data;
}
