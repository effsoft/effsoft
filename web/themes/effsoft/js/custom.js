/*!
 * jQuery Swapsie Plugin
 * Examples and documentation at: http://biostall.com/swap-and-re-order-divs-smoothly-using-jquery-swapsie-plugin
 * Copyright (c) 2010 Steve Marks - info@biostall.com
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 * Version: 1 (09-JULY-2010)
 */

var swapping = false;

(function ($) {
    $.fn.extend({
        swap: function (options) {

            var defaults = {
                target: "",
                speed: 1000,
                opacity: "1",
                callback: function () {
                }
            };
            var options = $.extend(defaults, options);

            return this.each(function () {

                var obj = $(this);

                if (options.target != "" && !swapping) {

                    swapping = true;

                    // set primary and secondary elements to relative if not already specified a positon CSS attribute
                    var current_primary_pos = obj.css("position");
                    var current_secondary_pos = options.target.css("position");
                    if (current_primary_pos != "relative" && current_primary_pos != "absolute") {
                        obj.css("position", "relative");
                    }
                    if (current_secondary_pos != "relative" && current_secondary_pos != "absolute") {
                        options.target.css("position", "relative");
                    }
                    //

                    // calculate y-axis movement
                    var current_primary_position = obj.offset();
                    var current_primary_top = current_primary_position.top;
                    var current_secondary_position = options.target.offset();
                    var current_secondary_top = current_secondary_position.top;
                    var direction_primary_y = '-';
                    var direction_secondary_y = '-';
                    if (current_primary_top <= current_secondary_top) { // if primary above secondary
                        var direction_primary_y = '+';
                        var total_y = current_secondary_top - current_primary_top;
                    } else { // if primary below secondary
                        var total_y = current_primary_top - current_secondary_top;
                    }
                    if (direction_primary_y == '-') {
                        direction_secondary_y = '+';
                    } else {
                        direction_secondary_y = '-';
                    }
                    //

                    // calculate x-axis movement
                    var current_primary_position = obj.offset();
                    var current_primary_left = current_primary_position.left;
                    var current_secondary_position = options.target.offset();
                    var current_secondary_left = current_secondary_position.left;
                    var direction_primary_x = '-';
                    var direction_secondary_x = '-';
                    if (current_primary_left <= current_secondary_left) { // if primary left of secondary
                        var direction_primary_x = '+';
                        var total_x = current_secondary_left - current_primary_left;
                    } else { // if primary below secondary
                        var total_x = current_primary_left - current_secondary_left;
                    }
                    if (direction_primary_x == '-') {
                        direction_secondary_x = '+';
                    } else {
                        direction_secondary_x = '-';
                    }
                    //

                    // do swapping
                    obj.animate({
                        opacity: options.opacity
                    }, 100, function () {
                        obj.animate({
                            top: direction_primary_y + "=" + (total_y) + "px",
                            left: direction_primary_x + "=" + (total_x) + "px"
                        }, options.speed, function () {
                            obj.animate({
                                opacity: "1"
                            }, 100);
                        });
                    });
                    options.target.animate({
                        opacity: options.opacity
                    }, 100, function () {
                        options.target.animate({
                            top: direction_secondary_y + "=" + (total_y) + "px",
                            left: direction_secondary_x + "=" + (total_x) + "px"
                        }, options.speed, function () {
                            options.target.animate({
                                opacity: "1"
                            }, 100, function () {
                                swapping = false; // call the callback and apply the scope:
                                options.callback.call(this);
                            });
                        });
                    });

                }

            });


        }
    });
})(jQuery);

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
if (ctx) {
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Earnings",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return '$' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
}

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
if (ctx) {
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Direct", "Referral", "Social"],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
if (ctx) {
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Revenue",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: [4215, 5312, 6251, 7841, 9821, 14984],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 15000,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return '$' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                    }
                }
            },
        }
    });
}

var get_tinymce_element_identity = function(uuid, name){
  return md5(uuid + name);
};

var get_tinymce_loading = function (uuid) {
    return '<div id="' + uuid + '"><span style="display:inline-block;width:10rem;">' +
        '<div class="progress fixed-top">' +
        '<div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
        '<i class="fa fa-circle-notch fa-spin fa-fw"></i>&nbsp;<span class="percent">0%</span>' +
        '</span></div>';
};

function uuidv4_v2() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    )
}

function uuidv4_v1() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

$.ajaxSetup({
    headers: {
        '_csrf': $('meta[name="csrf-token"]').attr("content"),
    },
    data:{
        '_csrf':$('meta[name="csrf-token"]').attr("content"),
    }
});

var get_uuid = function () {
    // Math.random should be unique because of its seeding algorithm.
    // Convert it to base 36 (numbers + letters), and grab the first 9 characters
    // after the decimal.
    if (uuidv4_v2()) {
        return uuidv4_v2().toUpperCase();
    }
    if (uuidv4_v1()) {
        return uuidv4_v1().toUpperCase();
    }
    return '_' + Math.random().toString(36).substr(2, 9).toUpperCase();
};

$.postJSON = function (url, data, func) {
    $.post(url, data, func, 'json');
}