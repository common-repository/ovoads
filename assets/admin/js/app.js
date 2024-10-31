/* -- Chartjs - Pie Chart -- */

function planColors() {
    return [
        '#ff7675',
        '#6c5ce7',
        '#ffa62b',
        '#ffeaa7',
        '#D980FA',
        '#fccbcb',
        '#45aaf2',
        '#05dfd7',
        '#FF00F6',
        '#1e90ff',
        '#2ed573',
        '#eccc68',
        '#ff5200',
        '#cd84f1',
        '#7efff5',
        '#7158e2',
        '#fff200',
        '#ff9ff3',
        '#08ffc8',
        '#3742fa',
        '#1089ff',
        '#70FF61',
        '#bf9fee',
        '#574b90'
    ]
}

(function ($) {
    $('[name=deactivate_reason]').click(function () { 
        let v = $(this).val();
        $('.reason_input').addClass('d-none');
        if (v == 'found_better' || v == 'others') {
            $(this).closest('.form-check').find('.form-control').removeClass('d-none');
        }
        
    });

    $(document).on("click", ".ovoads_wp_media_btn", function(e) {
        e.preventDefault();
        var t = $(this);
        var n;
        if (n) {
            n.open();
            return
        }
        var m = wp.i18n.__;
        n = wp.media({
            title: m("Select or Upload Media Of Your Choice", "tutor"),
            button: {
                text: m("Upload media", "tutor")
            },
            multiple: false
        });
        n.on("select", function() {
            var e = n.state().get("selection").first().toJSON();
            t.closest('.ovoads_media_uploader').find('.ovoads_media_upload').removeClass('d-none');
            t.closest('.ovoads_media_uploader').find('.ovoads_media_upload').attr('src',e.url);
            t.closest('.ovoads_media_uploader').find('.ovoads_media_input').val(e.id);
        });
        n.open()
    });



    var ovoadsSideBar = $('#toplevel_page_ovoads .wp-submenu-wrap li:last');
    ovoadsSideBar.addClass('ovoads-admin-pro');
    ovoadsSideBar.find('a').attr('target','_blank');


})(jQuery)


jQuery(document).ready(function($) {
    "use strict";
    function notify(status, message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
});




// var ctx = document.getElementById('deposit_chart');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         datasets: [{
//             data: [
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//             ],
//             backgroundColor: [
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//             ],
//             borderColor: [
//                 'rgba(231, 80, 90, 0.75)'
//             ],
//             borderWidth: 0,

//         }],
//         labels: [
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//         ]
//     },
//     options: {
//         aspectRatio: 1,
//         responsive: true,
//         maintainAspectRatio: true,
//         elements: {
//             line: {
//                 tension: 0 // disables bezier curves
//             }
//         },
//         scales: {
//             xAxes: [{
//                 display: false
//             }],
//             yAxes: [{
//                 display: false
//             }]
//         },
//         legend: {
//             display: false,
//         },
//         tooltips: {
//             callbacks: {
//                 label: (tooltipItem, data) => data.datasets[0].data[
//                     tooltipItem.index] + ' USD'
//             }
//         }
//     }
// });


// var ctx = document.getElementById('withdraw_chart');
// var myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         datasets: [{
//             data: [
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//                 1500,
//                 1800,
//                 1600,
//                 1400,
//                 1700,
//                 1300,
//                 1700,
//                 1400,
//                 1900,
//                 1800,
//             ],
//             backgroundColor: [
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//                 '#6c5ce7',
//             ],
//             borderColor: [
//                 'rgba(231, 80, 90, 0.75)'
//             ],
//             borderWidth: 0,

//         }],
//         labels: [
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//             'Slivesto',
//         ]
//     },
//     options: {
//         aspectRatio: 1,
//         responsive: true,
//         maintainAspectRatio: true,
//         elements: {
//             line: {
//                 tension: 0 // disables bezier curves
//             }
//         },
//         scales: {
//             xAxes: [{
//                 display: false
//             }],
//             yAxes: [{
//                 display: false
//             }]
//         },
//         legend: {
//             display: false,
//         },
//         tooltips: {
//             callbacks: {
//                 label: (tooltipItem, data) => data.datasets[0].data[
//                     tooltipItem.index] + ' USD'
//             }
//         }
//     }
// });