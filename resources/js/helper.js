$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json',
    }
});

/**
 *  Creating post data from objects/file-objects
 **/
$.getFormData = function (form) {
    let serialized = form.serialize();
    let items = serialized.split('&');

    let data = [];
    let multiple = true;

    for (let item of items) {
        let parts = item.split('=');
        if (parts[0] === '_token') {
            continue;
        }

        if (parts[1].indexOf('%2C') !== -1) {
            parts[1] = parts[1].split('%2C').join(',');
        }

        let iteratorParts = getNameKey(parts[0]);
        let iterator = iteratorParts.iterator;
        let key = iteratorParts.key;

        if (iterator !== key) {
            if (data[iterator] === undefined) {
                data[iterator] = {};
            }
            data[iterator][key] = decodeURI(parts[1]);
        } else {
            multiple = false;
            data[key] = decodeURI(parts[1]);
        }
    }

    if (multiple) {
        return prepareData(form, data);
    } else {
        return prepareSingleData(form, data);
    }
}

let prepareData = function (form, data) {
    if (form.find(':input[type="file"]').length === 0) {
        return {list: data};
    }

    form.find(':input[type="file"]').each(function() {
        let name = $(this)[0].name;
        let file = $(this)[0].files[0];
        if (file) {
            let iteratorParts = getNameKey(name);
            let iterator = iteratorParts.iterator;
            let key = iteratorParts.key;
            if (iterator !== key) {
                data[iterator][key] = file;
            } else {
                data[key] = file;
            }
        }
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

let prepareSingleData = function (form, data) {
    if (form.find(':input[type="file"]').length === 0) {
        return Object.assign({}, data);
    }

    let fileInput = form.find(':input[type="file"]');

    let name = fileInput[0].name;
    let file = fileInput[0].files[0];
    if (file) {
        let iteratorParts = getNameKey(name);
        let key = iteratorParts.key;
        data[key] = file;
    }

    let formData = new FormData();

    for (let key in data) {
        formData.append(key, data[key]);
    }

    return formData;
}

let getNameKey = function (inputName) {
    let iteratorParts = inputName.split('-');
    let iterator = iteratorParts[iteratorParts.length - 1];
    let key = inputName.replace('-' + iterator, '');

    return {iterator: iterator, key: key};
}

/**
 *  Generating nested options for select
 **/
$.getDefaultSelectOptions = function (data) {
    let res = '';

    for (let item of data) {
        res += `<option value="${item.id}"> ${item.name}</option>`;
    }

    return res;
}

/**
 *  Show validation errors
 **/

$.displayValidationErrors = function (messages) {
    let container = $('.errors');

    if (!container.length) {
        return;
    }

    container.empty();

    for (let key in messages) {
        for (let error of messages[key]) {
            container.append(`<p>${error}</p>`);
        }
    }
}

/**
 *  Working with url params
 **/
$.getUrlParams = function () {
    let url = window.location.href;
    if (url.indexOf('?') === -1) {
        return [];
    }

    let queryString = url.substring(url.lastIndexOf("?") + 1);

    let data = queryString.split('&').map(function(sParam) {
        let param = sParam.split('=');

        return {
            name: param[0],
            value: decodeURIComponent(param[1])
        };
    });

    return data;
}

$.setUrlParams = function (params) {
    let existingUrlParams = $.getUrlParams();

    let url = window.location.href;
    let queryString = url.split('?')[0];

    let paramsString = '?';
    let paramsArray = [];

    for (let param of existingUrlParams) {
        if (param.value.length) {
            paramsArray[param.name] = param.value;
        }
    }

    for (let param of params) {
        if (param.value.length) {
            paramsArray[param.name] = param.value;
        } else {
            delete paramsArray[param.name];
        }
    }

    paramsArray = Object.assign({}, paramsArray);
    paramsString += $.param(paramsArray);

    if (paramsString === '?') {
        paramsString = '';
    }

    return queryString + paramsString;
}
