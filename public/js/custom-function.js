//Axios get data and display in Select2

function pushDataList(routeLink, idSelector) {
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
