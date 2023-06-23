$(document).ready(function (){
    initFilters();

    $('.list-filter').on('click', function () {
        let filters = [];

        $(this).parent().parent().find('input').each(function () {
            let val = $(this).val();
            let name = $(this).attr('name');
            let type = $(this).attr('data-type');

            if (type && val.length) {
                val += '|' + type;
            }

            filters.push({name:name, value:val});
        });

        filters.push({name:'page', value:1});

        window.location.href = $.setUrlParams(filters);
    });

    $('.list-pagination').on('click', function () {
        let page = $(this).attr('data-page');
        let filters = [{name:'page', value:page}];

        window.location.href = $.setUrlParams(filters);
    });
});

let initFilters = function () {
    let filters = $.getUrlParams();
    let pageSet = false;

    for (let filter of filters) {
        if (filter.name === 'page') {
            setPageActive(filter.value);
            pageSet = true;
        } else if(filter.name.indexOf('filters') !== -1) {
            let filterElement = $('[name="' + filter.name + '"]');
            if (filterElement.length) {
                let value = filter.value;
                if (value.indexOf('|') !== -1) {
                    value = value.split('|')[0];
                }

                filterElement.val(value);
            }
        }
    }

    if (!pageSet) {
        setPageActive(1);
    }
}

let setPageActive = function (page) {
    let pageElement = $('.page-link.list-pagination[data-page="' + page + '"]');

    if (pageElement.length) {
        pageElement.parent().addClass('active');
    }
}
