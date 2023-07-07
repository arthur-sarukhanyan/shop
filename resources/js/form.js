import MultiSelect from "./multiSelect.js";

$.createFormElement = function (type, key, label, data = null, formContainerClass = '') {
    let item = '';

    if ($.formElements[type]) {
        item = $.formElements[type];
        if (type === 'select') {
            let options = $.getDefaultSelectOptions(data);
            item = replaceVars(item, key, label, options);
        } else {
            item = replaceVars(item, key, label);
        }
    }

    if (type === 'categoriesSelect') {
        let multiSelect = new MultiSelect(formContainerClass, data, key);
        multiSelect.init();
    }

    return item;
}

$.formElements = {
    image: `<div class="mb-3">
                <img src="/images/no-image.jpg" alt="image" class="preview-image" />
                <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                <input accept="image/*" type="file" id="{{KEY}}" name="{{KEY}}"/>
            </div>`,

    text: `<div class="mb-3">
               <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
               <input type="text" class="form-control" id="{{KEY}}" name="{{KEY}}">
           </div>`,

    textarea: `<div class="mb-3">
                  <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                  <textarea class="form-control" id="{{KEY}}" name="{{KEY}}"></textarea>
              </div>`,

    number: `<div class="mb-3">
                 <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                 <input type="number" class="form-control" id="{{KEY}}" name="{{KEY}}">
             </div>`,
    select: `<div class="mb-3">
                <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                <select class="form-select form-control" id="{{KEY}}" name="{{KEY}}">
                  <option selected disabled>Choose {{LABEL}}</option>
                  {{DATA}}
                </select>
            </div>`,
}

let replaceVars = function (item, key, label, data = null) {
    item = item.split('{{LABEL}}').join(label);
    item = item.split('{{KEY}}').join(key);
    if (data) {
        item = item.split('{{DATA}}').join(data);
    }

    return item;
}

let createCategoriesSelect = function (key, label, list) {
    return `<div class="mb-3">
                <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                <select class="form-select form-control" id="{{KEY}}" ${isCategory ? '' : 'name="{{KEY}}"'}>
                  <option selected disabled>Choose category</option>
                  ${options}
                </select>
                <input style="display: none" type="text" class="form-control category-value" ${isCategory ? 'name="{{KEY}}"' : ''}>
            </div>`;
}

$.initImagePreview = function (selector) {
    $('body').on('change', selector + ' input[type="file"]', function () {
        let files = $(this)[0].files;
        if (files.length) {
            $(this).parent().find('img')[0].src = window.URL.createObjectURL(files[0]);
        }
    });
}
