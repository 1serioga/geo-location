require('../css/app.css');

var $ = require('jquery');

const url = '/api/ip-location?ipAddress=';

$('.btn').click(function () {
    $.getJSON(url + $('.btn').attr('attr-ip'), function (result) {
        $('.city').text(result.city);
        $('.country').text(result.country);
    });
});
