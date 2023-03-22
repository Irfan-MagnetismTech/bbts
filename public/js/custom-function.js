//Axios get data and display in Select2

function fillSelect2Options(routeLink, idSelector) {
    axios.get(routeLink).then(function (response) {
        let data = response.data.map(function (item) {
            return {
                id: item.id,
                text: item.text,
            };
        });
        $(idSelector).select2({
            data: data,
        });
    });
}

/**
 * Axios change dropdown data list when select another dropdown
 * @param {string} routeLink
 * @param {string} queryString
 * @param {string} idSelector
 * @param {string} idSelectorChange
 * @param {string} method
 * @param {string} csrf
 */
function associativeDropdown(
    routeLink,
    queryString,
    idSelector,
    idSelectorChange,
    method = "get",
    csrf = null
) {
    $(idSelector).on("change", function () {
        let selector_id = $(this).val();
        axios[method](routeLink, {
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
            params: {
                [queryString]: selector_id,
            },
        })
            .then(function (response) {
                $(idSelectorChange).html("");
                var dropdownOptions = '<option value="">Select option</option>';
                response.data.map(function (dataValue) {
                    dropdownOptions += `<option value="${dataValue.id}">${dataValue.text}</option>`;
                });
                $(idSelectorChange).html(dropdownOptions);
            })
            .catch(function (error) {
                console.log(error);
            });
    });
}

function autocomplete(routeLink, idSelector, idSelectorChange) {
    $(idSelector).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: routeLink,
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {
                    response(data);
                },
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $(idSelectorChange).val(ui.item.id);
        },
    });
}

/**
 * Ajax select2 with custom query fields
 * Example Usage from Blade:
 * select2Ajax("{{ route('searchPopByBranch') }}", '#search_pop', '#branch_id', '#thana_id')
 *
 * @param {*} route
 * @param {*} element
 * @param  {...any} customQueryFields
 */
function select2Ajax(route, element, ...customQueryFields) {
    $(element).select2({
        ajax: {
            url: route,
            data: function (params) {
                var query = {
                    search: params.term,
                };
                customQueryFields.forEach(function (field) {
                    var fieldName = field.replace(/^#|^\.+/, "");
                    query[fieldName] = $(field).val();
                });

                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return { id: obj.id, text: obj.text };
                    }),
                };
            },
        },
        minimumInputLength: 1,
        placeholder: "Search",
    });
}

/**
 * Ajax autocomplete with jquery ui
 *
 * @param {*} triggerElement
 * @param {*} route
 * @param {*} callback
 * @param  {...any} customQueryFields
 */
function jquaryUiAjax(triggerElement, route, callback, ...customQueryFields) {
    $(triggerElement).on("keyup", function () {
        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: route,
                    type: "get",
                    dataType: "json",
                    data: {
                        search: request.term,
                        customQueryFields: customQueryFields[0],
                    },
                    success: function (data) {
                        if (data.length > 0) {
                            response(data);
                        } else {
                            response([
                                {
                                    label: "No Result Found",
                                    value: -1,
                                },
                            ]);
                        }
                    },
                });
            },
            select: function (event, ui) {
                if (ui.item.value == -1) {
                    $(this).val("");
                    return false;
                }
                callback(ui.item);
                return false;
            },
        });
    });
}
