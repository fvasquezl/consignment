function getData(url){
    let result = '';
    let request = $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        async: false
    });
    request.done(function(ret) {
        return result = ret;
    });
    return result;
}

function currencyFormat(num) {
    return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

$(function () {
    'use strict';

    let ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    };

    let mode      = 'index';
    let intersect = true;
    let sales = getData('/getTotalSales');
    let products = getData('/getProducts');

    $('#profit').append(currencyFormat(sales.profit));
    $('#totalProducts').append(products.qtyProducts);



    let $productsChart = $('#products-chart');
    let productsChart  = new Chart($productsChart, {
        type   : 'bar',
        data   : {
            labels  : products.months,
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor    : '#007bff',
                    data           : products.qtySold
                },
                // {
                //     backgroundColor: '#ced4da',
                //     borderColor    : '#ced4da',
                //     data           : sales.totalCost
                // }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips           : {
                mode     : mode,
                intersect: intersect
            },
            hover              : {
                mode     : mode,
                intersect: intersect
            },
            legend             : {
                display: false
            },
            scales             : {
                yAxes: [{
                    // display: false,
                    gridLines: {
                        display      : true,
                        lineWidth    : '4px',
                        color        : 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks    : $.extend({
                        beginAtZero: true,
                    }, ticksStyle)
                }],
                xAxes: [{
                    display  : true,
                    gridLines: {
                        display: false
                    },
                    ticks    : ticksStyle
                }]
            }
        }
    });




    let $salesChart = $('#sales-chart')
    let salesChart  = new Chart($salesChart, {
        data   : {
            labels  : sales.months,
            datasets: [{
                type                : 'line',
                data                : sales.totalSales,
                backgroundColor     : 'transparent',
                borderColor         : '#007bff',
                pointBorderColor    : '#007bff',
                pointBackgroundColor: '#007bff',
                fill                : false
                // pointHoverBackgroundColor: '#007bff',
                // pointHoverBorderColor    : '#007bff'
            },
                {
                    type                : 'line',
                    data                : sales.totalCost,
                    backgroundColor     : 'tansparent',
                    borderColor         : '#ced4da',
                    pointBorderColor    : '#ced4da',
                    pointBackgroundColor: '#ced4da',
                    fill                : false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips           : {
                mode     : mode,
                intersect: intersect
            },
            hover              : {
                mode     : mode,
                intersect: intersect
            },
            legend             : {
                display: false
            },
            scales             : {
                yAxes: [{
                    // display: false,
                    gridLines: {
                        display      : true,
                        lineWidth    : '4px',
                        color        : 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks    : $.extend({
                        beginAtZero: true,

                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            if (value >= 1000) {
                                value /= 1000
                                value += 'k'
                            }
                            return '$' + value
                        }
                    }, ticksStyle)
                }],
                xAxes: [{
                    display  : true,
                    gridLines: {
                        display: false
                    },
                    ticks    : ticksStyle
                }]
            }
        }
    })

});

