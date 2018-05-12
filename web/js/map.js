$(document).ready(function () {
    $('#vmap').css(
        {
            'width': '650px',
            'height': '380px'
        }
    );

    $('.mapPoints a').click(function (e) {
        e.preventDefault();
    });

    $('.mapPoints a').hover(function () {
        filterRegions($(this).attr('href'));
    }, function () {
        filterRegions('');
    });
});

var regions = {
    to: 0,
    qo: 0,
    an: 0,
    bu: 0,
    qa: 0,
    no: 0,
    gu: 0,
    sa: 0,
    fa: 0,
    ji: 0,
    na: 0,
    te: 0,
    xo: 0
};

function filterRegions(regionId) {
    var regionsList = {};
    $.each(regions, function (key, value) {
        var elementColor = '#4da9ec';
        regionsList[key] = elementColor;
    });
    if (regionId.length > 0) {
        regionsList[regionId] = '';
    }
    $('#vmap').vectorMap('set', 'colors', regionsList);
    return false;
}
function makeMap(messages) {
    $('#vmap').html('');
    $('.jqvmap-label').remove();
    $('#vmap').vectorMap({
        map: 'uzbekistan',
        backgroundColor: '',
        color: '#00bfff',
        hoverColor: '#0394c4',
        enableZoom: false,
        showTooltip: true,
        borderColor: '#fff',
        borderWidth: 1,
        borderOpacity: 1,

        'stroke-width': 1,
        onLabelShow: function (event, label, code) {
            $('#mapLabels').html(messages[code]('code'));
        },
        onRegionOut: function () {

            $('#mapLabels').html('');

        },
        onRegionClick: function (element, code, region) {
            console.log(messages[code]('id'));
            // console.log(element);
            // console.log(code);
            // console.log(element);
            // document.location.href = 'http://' + location.hostname + '/pensionpoint/region?code=' + code;
        },

    });
}