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
