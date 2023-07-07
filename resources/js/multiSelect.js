class MultiSelect {
    container;
    data = [];
    closedBtn = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
      <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
    </svg>`;
    openBtn = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up" viewBox="0 0 16 16">
      <path d="M3.204 11h9.592L8 5.519 3.204 11zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659z"/>
    </svg>`;
    key;
    multiple = false;
    multiTypes = ['product'];
    values = [];

    constructor(container, data, key) {
        this.container = $(container);
        this.data = data;
        this.key = key;
        this.setMultiple(container);
    }

    init() {
        this.createListContainer();
        this.initOptions(null, '.list-container');
        this.initEventHandlers();
    }

    setMultiple(container) {
        for (let type of this.multiTypes) {
            if (container.indexOf(type) !== -1) {
                this.multiple = true;
                break;
            }
        }
    }

    createListContainer() {
        let listContainer = `<div class="list-container-wrapper mb-3">
            <div class="list-container-display">

            </div>
            <ul class="list-container list-group">
            </ul>
            <input type="text" style="display: none" class="list-container-input" name="${this.key}">
        </div>`;

        this.container.append(listContainer);
    }

    initOptions(id = null, selector) {
        let filteredOptions = [];
        for (let item of this.data) {
            if (item.parent_id === id) {
                filteredOptions.push(item);
            }
        }

        this.createListOption(filteredOptions, selector);
    }

    createListOption(options, selector) {
        let optionsHtml = '<ul>';

        for (let option of options) {
            let isSelected = this.isOptionSelected(option.id);

            optionsHtml += `<li class="list-group-item" data-value="${option.id}">
                <span class="option-name${isSelected ? ' st-selected' : ''}">${option.name}</span>
                <span class="option-toggle float-end st-closed">
                    ${this.closedBtn}
                </span>
            </li>`;
        }

        optionsHtml += '</ul>';
        this.container.find(selector).append(optionsHtml);
    }

    initEventHandlers() {
        $(this.container).on('click', '.list-group-item .option-toggle', (e) => {
            let el = $(e.currentTarget);
            if (!el.hasClass('option-toggle')) {
                return;
            }

            let status = el.hasClass('st-closed') ? 'closed' : 'open';

            if (status === 'closed') {
                el.html(this.openBtn);
                el.removeClass('st-closed');
                el.addClass('st-open');
                let id = el.parent().attr('data-value');
                this.initOptions(parseInt(id), 'li[data-value="' + id + '"]');
            } else {
                el.html(this.closedBtn);
                el.addClass('st-closed');
                el.removeClass('st-open');
                el.parent().find('ul').remove();
            }
        });

        $(this.container).on('click', '.list-group-item .option-name', (e) => {
            let el = $(e.currentTarget);
            if (!el.hasClass('option-name')) {
                return;
            }

            let status = el.hasClass('st-selected') ? 'selected' : 'not-selected';

            if (status === 'not-selected') {
                if (!this.multiple) {
                    this.container.find('.st-selected').each(function (){
                        $(this).removeClass('st-selected');
                    });
                }

                el.addClass('st-selected');
            } else {
                el.removeClass('st-selected');

                if (this.multiple) {
                    let index = this.values.indexOf(parseInt(el.parent().attr('data-value')));
                    this.values.splice(index, 1);
                }
            }

            this.initSelectedValues();
        });

        $(this.container).on('click', '.option-removable', (e) => {
            let el = $(e.currentTarget);
            let val = el.attr('data-value');
            let createdOption = this.container.find('li[data-value="' + val + '"] .option-name').first();

            let index = this.values.indexOf(parseInt(val));
            this.values.splice(index, 1);

            if (createdOption.length && createdOption.hasClass('st-selected')) {
                createdOption.removeClass('st-selected');
            }
            this.initSelectedValues();
        });

        $(this.container).on('set-value', '.list-group-item', (e, values) => {
            values = JSON.parse(values);

            if (typeof values === 'number') {
                this.values = values;
            } else {
                for (let item of values) {
                    this.values.push(item.id);
                }
            }

            this.initSelectedValues();
        })
    }

    initSelectedValues() {
        let displayNames = '';
        let values;
        if (this.multiple) {
            let slectedEl = this.container.find('.st-selected');
            slectedEl.each((e) => {
                let pt = $(slectedEl[e]).parent();
                let val = pt.attr('data-value');
                console.log(val);
                if (!this.values.includes(parseInt(val))) {
                    this.values.push(parseInt(val));
                }

                let name = pt.find('.option-name').first().text();
                displayNames += `<span class="option-removable" data-value="${val}"> ${name},</span>`;
            });

            if (slectedEl.length < this.values.length) {
                displayNames = this.getDisplayNamesFromData();
            }

            this.container.find('.list-container-display').empty();
            this.container.find('.list-container-display').append(displayNames);

            let lastText = this.container.find('.option-removable').last().text();
            lastText = lastText.substring(0, lastText.length - 1);
            this.container.find('.option-removable').last().text(lastText);

            values = JSON.stringify(this.values);
        } else {
            values = '';
            let selected = this.container.find('.st-selected');
            if (selected.length) {
                values = selected.parent().attr('data-value');
            } else if (this.values) {
                values = this.values;
            }
        }

        this.container.find('.list-container-input').val(values);
    }

    isOptionSelected(id) {
        let values = this.container.find('.list-container-input').val();
        if (!values || !values.length) {
            return false;
        }

        values = JSON.parse(values);

        if (typeof values === 'number') {
            return parseInt(values) === parseInt(id);
        }

        for (let val of values) {
            if (parseInt(val) === parseInt(id)) {
                return true;
            }
        }

        return false;
    }

    getDisplayNamesFromData() {
        let displayNames = '';

        for (let index of this.values) {
            for (let item of this.data) {
                if (item.id === index) {
                    displayNames += `<span class="option-removable" data-value="${item.id}"> ${item.name},</span>`;
                }
            }
        }

        return displayNames;
    }
}

export default MultiSelect;
