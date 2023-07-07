class CreateForm {
    addFormButton;
    submitFormButton;
    formContainerClass;
    formId;
    itemType;
    multiField = null;
    formFields = [];
    counter = 0;

    constructor(addFormButton, submitFormButton, formContainerClass, formId, itemType, multiField = null) {
        this.addFormButton = addFormButton;
        this.submitFormButton = submitFormButton;
        this.formContainerClass = formContainerClass;
        this.formId = formId;
        this.itemType = itemType;
        this.multiField = multiField;
    }

    init() {
        this.addCreateForm();
        this.setCounterIncrement();
        this.setCounterDecrement();
        this.setFormSubmit()
    }

    setCounterIncrement() {
        $(this.addFormButton).on('click', () => {
            this.addCreateForm();
        });
    }

    setCounterDecrement() {
        $('body').on('click', '.remove-form', (e) => {
            e.preventDefault();
            if (this.counter === 1) {
                return;
            }

            let number = $(this).attr('data-counter');
            $('.create-form-' + number).remove();
            --this.counter;
        });
    }

    setFormSubmit() {
        $(this.submitFormButton).on('click', () => {
            this.submitCreateForm();
        });
    }

    setFormFields(fields) {
        this.formFields = fields;
    }

    addCreateForm() {
        let container = `<div class="${this.formContainerClass} create-form-${this.counter}">
            <div class="create-form-actions">
                <button class="btn btn-danger remove-form" data-counter="${this.counter}">-</button>
            </div>
        </div>`;

        let pointer = $(this.formId);
        pointer.append(container);

        let fields = this.createFormFields();
        for (let field of fields) {
            $('.create-form-' + this.counter).append(field);
        }

        ++this.counter;
    }

    submitCreateForm() {
        let data = $.getFormData($(this.formId));
        let url = '/admin/' + this.itemType + '/create';
        let redirectUrl = '/admin/' + this.itemType;
        let contentType = 'application/x-www-form-urlencoded';
        let processData = true;

        if (data instanceof FormData) {
            contentType = false;
            processData = false;
        }

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            contentType: contentType,
            processData: processData,
            success: function (res) {
                window.location.href = redirectUrl;
            },
            error: function (err) {
                let messages = JSON.parse(err.responseText);
                $.displayValidationErrors(messages.errors);
            }
        });
    }

    createFormFields() {
        let res = [];
        let className = '.' + this.formContainerClass + '.create-form-' + this.counter;

        for (let item of this.formFields) {
            let data = [];
            if (item.data) {
                data = item.data;
            }

            let parsed = $.createFormElement(item.type, item.key + '-' + this.counter, item.label, data, className);
            res.push(parsed);
        }

        return res;
    }

    setImageHandler() {
        $.initImagePreview(this.formId);
    }
}

export default CreateForm;
