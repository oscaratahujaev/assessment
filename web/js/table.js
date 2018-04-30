/**
 * Created by m_toshpolatov on 24.04.2018.
 */
var categoryID;
var regionID;
var year;
var quarter;
$('#category, #region, #year, #quarter').change(function () {
    categoryID = $("#category").val();
    year = $("#year").val();
    regionID = $("#region").val();
    quarter = $("#quarter").val();
    $("#addUrl").attr('href', '/data/add?categoryID='
        + categoryID
        + '&regionID=' + regionID +
        '&year=' + year +
        '&quarter=' + quarter);
});



