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

        let iteratorParts = getNameKey(parts[0]);
        let iterator = iteratorParts.iterator;
        let key = iteratorParts.key;

        if (data[iterator] === undefined) {
            data[iterator] = {};
        }
        data[iterator][key] = decodeURI(parts[1]);
    }

    return prepareData(form, data);
}

let prepareData = function (form, data) {
    if (form.find(':input[type="file"]').length === 0) {
        return {list: data};
    }

    form.find(':input[type="file"]').each(function() {
        let name = $(this)[0].name;
        let file = $(this)[0].files[0];

        let iteratorParts = getNameKey(name);
        let iterator = iteratorParts.iterator;
        let key = iteratorParts.key;
        data[iterator][key] = file;
    });

    let formData = new FormData();
    for (let index in data) {
        for (let key in data[index]) {
            let name = 'list[' + index + '][' + key + ']';
            formData.append(name, data[index][key]);
        }
    }

    return formData;
}

let getNameKey = function (inputName) {
    let iteratorParts = inputName.split('-');
    let iterator = iteratorParts[iteratorParts.length - 1];
    let key = inputName.replace('-' + iterator, '');

    return {iterator: iterator, key: key};
}
