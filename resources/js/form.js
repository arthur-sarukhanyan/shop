$.createFormElement = function (type, key, label, data = null) {
    let item = '';

    if ($.formElements[type]) {
        item = $.formElements[type];
        item = replaceVars(item, key, label);
    }

    if (type === 'categoriesSelect') {
        item = createCategoriesSelect(key, label, data);
        item = replaceVars(item, key, label);
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
}

let replaceVars = function (item, key, label) {
    item = item.split('{{LABEL}}').join(label);
    item = item.split('{{KEY}}').join(key);

    return item;
}

let createCategoriesSelect = function (key, label, list) {
    let options = $.sortSelectOptions(list, []);
    let isCategory = key.indexOf('category') !== -1;

    return `<div class="mb-3">
                <label for="{{KEY}}" class="form-label">{{LABEL}}</label>
                <select class="form-select form-control" id="{{KEY}}" ${isCategory ? '' : 'name="{{KEY}}"'}>
                  <option selected disabled>Choose category</option>
                  ${options}
                </select>
                <input style="display: none" type="text" class="form-control category-value" ${isCategory ? 'name="{{KEY}}"' : ''}>
            </div>`;
}
