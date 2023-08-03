class UpdateForm {
    submitFormButton;
    formId;
    itemType;
    multiField = null;
    values = [];
    formFields = [];
    id;
    select2Fields = ['filter_id'];

    constructor(submitFormButton, formId, itemType, values, multiField = null) {
        this.submitFormButton = submitFormButton;
        this.formId = formId;
        this.itemType = itemType;
        this.multiField = multiField;
        this.id = values.id;
        delete values.id;
        this.values = values;
    }

    init() {
        this.addCreateForm();
        this.setFormSubmit();
        this.setFormValues();
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
        let container = $(this.formId);

        let fields = this.createFormFields();
        for (let field of fields) {
            container.append(field);
        }
    }

    submitCreateForm() {
        this.stringifySelect2Values();
        let data = $.getFormData($(this.formId));
        let url = '/admin/' + this.itemType + '/update/' + this.id;
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

        for (let item of this.formFields) {
            let data = [];
            if (item.data) {
                data = item.data;
            }

            let parsed = $.createFormElement(item.type, item.key, item.label, data, this.formId);
            res.push(parsed);
        }

        return res;
    }

    setImageHandler() {
        $.initImagePreview(this.formId);
    }

    setFormValues() {
        let container = $(this.formId);
        let multiKey = null;
        if (this.multiField) {
            multiKey = this.multiField.replace('#', '');
        }

        for (let key in this.values) {
            if (key === multiKey) {
                continue;
            }

            if (key === 'img') {
                container.find(key).attr('src', this.values[key]);
            } else if (key === 'parent_id') {
                $('.list-group-item').trigger('set-value', JSON.stringify(this.values[key]));
            } else if (this.select2Fields.includes(key)) {
                $('#' + key).val(this.values[key]).trigger('change');
            } else {
                container.find('#' + key).val(this.values[key]);
            }
        }

        if (this.multiField) {
            $(this.formId).trigger('set-value', JSON.stringify(this.values[multiKey]));
        }
    }

    stringifySelect2Values() {
        for (let item of this.select2Fields) {
            let el = $('#' + item);
            if (el.length) {
                let val = JSON.stringify(el.val());
                el.parent().find('.select2').remove();
                el.remove();
                let tmpInput = `<input type="hidden" id="${item}" name="${item}">`;
                $(this.formId).append(tmpInput);
                $('#' + item).val(val);
            }
        }
    }
}

export default UpdateForm;
