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
    for (let item of items) {
        let parts = item.split('=');
        if (parts[0] === '_token') {
            continue;
        }

        if(parts[0].indexOf('category_id') !== -1) {
            parts[1] = JSON.stringify(parts[1].split('%2C'));
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

/**
 *  Generating nested options for select
 **/
$.sortedSelectOptions = null;

$.sortSelectOptions = function (list, sorted = []) {
    if ($.sortedSelectOptions) {
        return $.sortedSelectOptions;
    }

    if (!sorted.length) {
        for (let item of list) {
            if (item.parent === null) {
                sorted.push(item);
            }
        }

        updateArrays(list, sorted);
    }

    for (let item of list) {
        for (let i = 0; i < sorted.length; i++) {
            if (sorted[i].id === item.parent_id) {
                sorted = addToArray(sorted, item, i);
            }
        }
    }

    updateArrays(list, sorted);

    $.sortedSelectOptions = getSelectOptions(sorted);
    return $.sortedSelectOptions;
}

let updateArrays = function (list, sorted) {
    for (let item of sorted) {
        for (let index in list) {
            if (item.id === list[index].id) {
                list.splice(index, 1);
            }
        }
    }

    return list;
}

let addToArray = function (list, item, index) {
    if (list.length < index + 1) {
        list.push(item);
        return list;
    }

    let firstChunk = list.slice(0, index + 1);
    let secondChunk = list.slice(index + 1, list.length);

    firstChunk.push(item);

    return firstChunk.concat(secondChunk);
}

let getSelectOptions = function (list, result = '', number = 0, parent = null, itemParentId = null) {
    if (!list.length) {
        return result;
    }

    let item = list[0];

    if (item.parent === null) {
        result += `<option value="${item.id}" class="fw-bold">${item.name}</option>`;
        number = 0;
        parent = item.id;
    } else {
        if (item.parent_id === parent) {
            ++number;
        } else {
            if (itemParentId !== item.parent_id) {
                number--;
            }
        }

        parent = item.id;
        result += `<option value="${item.id}">${getOptionSpaces(number)} ${item.name}</option>`;
    }

    list.shift();
    return getSelectOptions(list, result, number, parent, item.parent_id);
}

let getOptionSpaces = function (count) {
    let res = '';
    while (count > 0) {
        res += '\u00a0\u00a0';
        count--;
    }

    return res;
}

/**
 *  Create multi select from simple select
 **/
$.makeMultiSelect = function (element) {
    var values = [];
    let valueElement = `<option class="multiple-default" style="display: none" value=""></option>>`;

    element.on('change', function (e) {
        let exist = false;

        let valueToAdd = getSelectedCheckboxValues(element);

        values.map(function (item) {
           if (item.value === valueToAdd.value) {
               exist = true;
           }
        });

        if (exist) {
            return;
        }

        values.push(getSelectedCheckboxValues(element));

        let valueContainElement = element.parent().find('.category-value');

        let existingValueElement = element.find('.multiple-default');
        if (existingValueElement) {
            existingValueElement.remove();
        }

        element.append(valueElement);

        existingValueElement = element.find('.multiple-default');
        getMultiSelectDisplay(values, existingValueElement);
        existingValueElement.find('.option-removable').on('click', function (e) {
            $(this).remove();
        });

        let layer = createSelectLayer(element);
        layer.html(existingValueElement.html());

        layer.find('.option-removable').on('click', function () {
            let value = $(this).attr('data-value');
            $(this).remove();

            let firstOption = layer.find('.option-removable').first();
            let text = firstOption.text().replace(', ', '');
            firstOption.text(text);

            existingValueElement.find('span').each(function () {
                if ($(this).attr('data-value') === value) {
                    $(this).remove();
                }
            });

            values = values.filter(function (item) {
                return item.value !== value;
            });
            setSelectedOptionValues(valueContainElement, values);

            if (!layer.html().length) {
                layer.remove();
            }
        });

        setSelectedOptionValues(valueContainElement, values);

        // existingValueElement.text(text);
    });
}

let getSelectedCheckboxValues = function (selectElement) {
    let selected = selectElement.find(':selected');
    return {inner: selected.text(), value: selected.val()};
}

let getMultiSelectDisplay = function (data, element) {
    data.map(function (item, index) {
        let text = ', ' + item.inner;
        if (index === 0) {
            text = item.inner;
        }

        text = text.replace(/\s+/g,' ').trim();
        element.append(`<span class="option-removable" data-value="${item.value}">${text}</span>`);
    });
}

let createSelectLayer = function (element) {
    let layerElement = element.parent().find('.multi-select-layer');
    if (!layerElement.length) {
        element.parent().addClass('position-relative');
        element.parent().append(`<div class="position-absolute multi-select-layer" style="top: 0px; left: 100px;"></div>`);
        layerElement = element.parent().find('.multi-select-layer');

        layerElement.css({'height':(element.height()+'px'), 'width':(element.width()+'px')});
    }

    return layerElement;
}

let setSelectedOptionValues = function (element, values) {
    let selectedValues = [];
    values.map(function (item) {
        selectedValues.push(item.value);
    });

    element.val(selectedValues);
}
