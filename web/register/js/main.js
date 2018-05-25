/**
 * Created by a_atahujaev on 10.04.2018.
 */
function getDistricts(value, container) {
    $.ajax({
        'method': 'get',
        'url': '/ajax/get-districts',
        'data': {regionId: value},
        'beforeSend': function () {
            $('.loader').fadeIn();
        },
        'error': function () {
            $('.loader').fadeOut();
        },
        'success': function (data) {
            $('.loader').fadeOut();
            if (data === "") {
                return;
            }
            data = JSON.parse(data);

            html = "";
            if (data.length) {
                data.forEach(function (element, index, array) {
                    html += '<option value="' + element.ID + '">' + element.Name + '</option>';
                });
            }
            $(container).html(html);
        }
    });
}
