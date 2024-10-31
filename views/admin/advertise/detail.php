<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$html = '<a href="' . esc_url(ovoads_route_link('admin.advertise.index', pageName: ovoads_request()->page)) . '" class="btn btn--primary"><i class="las la-arrow-left"></i> ' . __('Back', 'ovoads') . '</a>';
ovoads_admin_top($pageTitle, $html);?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="h6"><?php esc_html_e('Total Clicks', 'ovoads'); ?></div>
                    <span class="h3 text-success font-bold"><?php printf(esc_html__('%s', 'ovoads'),  esc_html(ovoads_number_format($ad->clicks))); ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="h6"><?php echo esc_html_e('Total Impressions', 'ovoads') ?></div>
                    <span class="h3 text-success font-bold"><?php printf(esc_html__('%s', 'ovoads'),  esc_html(ovoads_number_format($ad->impressions))); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6><?php esc_html_e('Browser Statistics', 'ovoads') ?></h6>
                <div class="d-flex align-items-center justify-content-between">
                    <div></div>
                    <select name="data_show_type" class="form-control form--control me-2">
                        <option value="impression"><?php echo esc_html_e('Impressions','ovoads')?></option>
                        <option value="click"><?php echo esc_html_e('Clicks', 'ovoads')?></option>
                    </select>
                    <select id="browser_statisstics_time" class="form-control form--control">
                        <option value="<?php echo esc_attr('all') ?>"><?php esc_html_e('All Time', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('week') ?>"><?php esc_html_e('Current Week', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('month') ?>"><?php esc_html_e('Current Month', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('year') ?>"><?php esc_html_e('Current Year', 'ovoads') ?></option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <ul id="browser-info-data"></ul>
                    </div>
                    <div class="col-lg-7">
                        <div id="broswer_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6><?php esc_html_e('OS Statistics', 'ovoads') ?></h6>
                <div class="d-flex align-items-center justify-content-between">
                    <div></div>
                    <select name="data_show_type_for_os" class="form-control form--control me-2">
                        <option value="impression"><?php echo esc_html_e('Impressions', 'ovoads')?></option>
                        <option value="click"><?php echo esc_html_e('Clicks', 'ovoads')?></option>
                    </select>
                    <select id="os_statisstics_time" name="" class="form-control form--control">
                        <option value="<?php echo esc_attr('all') ?>"><?php esc_html_e('All Time', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('week') ?>"><?php esc_html_e('Current Week', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('month') ?>"><?php esc_html_e('Current Month', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('year') ?>"><?php esc_html_e('Current Year', 'ovoads') ?></option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <ul id="os-info-data"></ul>
                    </div>
                    <div class="col-lg-7">
                        <div id="os_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6><?php esc_html_e('Region Statistics', 'ovoads') ?></h6>
                <div class="d-flex align-items-center justify-content-between">
                    <div></div>
                    <select name="data_show_type_for_country" class="form-control form--control me-2">
                        <option value="impression"><?php echo esc_html_e('Impressions', 'ovoads')?></option>
                        <option value="click"><?php esc_html_e('Clicks', 'ovoads')?></option>
                    </select>
                    <select name="" id="country_statisstics_time" class="form-control form--control">
                        <option value="<?php echo esc_attr('all') ?>"><?php esc_html_e('All Time', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('week') ?>"><?php esc_html_e('Current Week', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('month') ?>"><?php esc_html_e('Current Month', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('year') ?>"><?php esc_html_e('Current Year', 'ovoads') ?></option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <ul id="country-info-data"></ul>
                    </div>
                    <div class="col-lg-7">
                        <div id="country_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6><?php esc_html_e('Domain Statistics', 'ovoads') ?></h6>
                <div class="d-flex align-items-center justify-content-between">
                    <div></div>
                    <select name="data_show_type_for_host" class="form-control form--control me-2">
                        <option value="impression"><?php echo esc_html_e('Impressions', 'ovoads')?></option>
                        <option value="click"><?php echo esc_html_e('Clicks', 'ovoads')?></option>
                    </select>
                    <select id="host_statisstics_time" class="form-control form--control">
                        <option value="<?php echo esc_attr('all') ?>"><?php esc_html_e('All Time', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('week') ?>"><?php esc_html_e('Current Week', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('month') ?>"><?php esc_html_e('Current Month', 'ovoads') ?></option>
                        <option value="<?php echo esc_attr('year') ?>"><?php esc_html_e('Current Year', 'ovoads') ?></option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <ul id="host-info-data"></ul>
                    </div>
                    <div class="col-lg-7">
                        <div id="host_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center flex-wrap justify-content-between gap-2">
                <h5><?php esc_html_e('IP Lists', 'ovoads') ?></h5>
                <div class="d-flex align-items-center flex-wrap justify-content-between gap-2">
                  
                    <div>
                        <select  id="ip_select_table" class="form-control form--control">
                            <option value="<?php echo esc_attr('all'); ?>"><?php esc_html_e('All Time', 'ovoads') ?></option>
                            <option value="<?php echo esc_attr('week'); ?>"><?php esc_html_e('Current Week', 'ovoads') ?></option>
                            <option value="<?php echo esc_attr('month'); ?>"><?php esc_html_e('Current Month', 'ovoads') ?></option>
                            <option value="<?php echo esc_attr('year'); ?>"><?php esc_html_e('Current Year', 'ovoads') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('IP', 'ovoads') ?></th>
                            <th><?php esc_html_e('Country', 'ovoads') ?></th>
                            <th><?php esc_html_e('Host', 'ovoads') ?></th>
                            <th><?php esc_html_e('Browser', 'ovoads') ?></th>
                            <th><?php esc_html_e('Action', 'ovoads') ?></th>
                        </tr>
                    </thead>
                    <tbody id="data-wrapper"></tbody>

                </table>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn--primary btn-sm loadMore"><?php esc_html_e('Load More', 'ovoads') ?></button>
            </div>
        </div>
    </div>
</div>

<?php
ovoads_admin_bottom();
?>
<script>
    (function($) {
        "use strict";

        function chartBarBgColors() {
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
        $('#browser_statisstics_time').on('change', function() {
            var time = $('#browser_statisstics_time').val();
            var showType = $('[name=data_show_type]').val();

            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    duration: time,
                    showType: showType,
                    action: "detailStatistic",
                    nonce: ajax.nonce
                },
                success: function(res) {
                    $('#broswer_chart').html('<canvas id="browser" width="100%" height="60px"></canvas>')

                    let browserInfo = '';
                    var counts = res.browser_count;
                    var sum = 0;
                    for (var i = 0; i < counts.length; i++) {
                        sum += counts[i];
                    }
                    var percentages = [];
                    for (var i = 0; i < counts.length; i++) {
                        var percentage = (counts[i] / sum) * 100;
                        percentages.push(percentage);
                    }


                    for (var i = 0; i < res.browser_name.length; i++) {
                        var browserName = res.browser_name[i];
                        var percentage = percentages[i];
                        browserInfo += `<li><i class="fas fa-arrow-right me-2 colorPoint"></i>${percentage.toFixed(2)}% - ${browserName}</li>`;
                    }

                    $('#browser-info-data').html(browserInfo);

                    var ctx = document.getElementById('browser');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: res.browser_name,
                            datasets: [{
                                data: res.browser_count,
                                backgroundColor: chartBarBgColors(),

                            }],
                        },
                        options: {
                            aspectRatio: 1,
                            responsive: true,
                            maintainAspectRatio: true,
                            elements: {
                                line: {
                                    tension: 0 // disables bezier curves
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: false
                                }]
                            },
                            legend: {
                                display: false,
                            }
                        }
                    });

                    var planPoints = $('.colorPoint');
                    planPoints.each(function(key, planPoint) {
                        var planPoint = $(planPoint)
                        planPoint.css('color', chartBarBgColors()[key])
                    })
                }
            })
        }).change();

        $('#os_statisstics_time').on('change', function() {
            var time = $('#os_statisstics_time').val();
            var showType = $('[name=data_show_type_for_os]').val();

            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    duration: time,
                    showType: showType,
                    action: "detailStatistic",
                    nonce: ajax.nonce
                },
                success: function(res) {
                    $('#os_chart').html('<canvas id="os" width="100%" height="60px"></canvas>');
                    var ctx = document.getElementById('os');
                    let osInfo = '';
                    var counts = res.os_count;
                    var sum = 0;
                    for (var i = 0; i < counts.length; i++) {
                        sum += counts[i];
                    }
                    var percentages = [];
                    for (var i = 0; i < counts.length; i++) {
                        var percentage = (counts[i] / sum) * 100;
                        percentages.push(percentage);
                    }


                    for (var i = 0; i < res.os_name.length; i++) {
                        var osName = res.os_name[i];
                        var percentage = percentages[i];
                        osInfo += `<li><i class="fas fa-arrow-right me-2 osColorPoint"></i>${percentage.toFixed(2)}% - ${osName}</li>`;
                    }

                    $('#os-info-data').html(osInfo);
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: res.os_name,
                            datasets: [{
                                data: res.os_count,
                                backgroundColor: chartBarBgColors(),

                            }],
                        },
                        options: {
                            aspectRatio: 1,
                            responsive: true,
                            maintainAspectRatio: true,
                            elements: {
                                line: {
                                    tension: 0 // disables bezier curves
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: false
                                }]
                            },
                            legend: {
                                display: false,
                            }
                        }
                    });

                    var planPoints = $('.osColorPoint');
                    planPoints.each(function(key, planPoint) {
                        var planPoint = $(planPoint)
                        planPoint.css('color', chartBarBgColors()[key])
                    })
                }

            });
        }).change();

        $('#country_statisstics_time').on('change', function() {
            var time = $('#country_statisstics_time').val();
            var showType = $('[name=data_show_type_for_country]').val();

            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    duration: time,
                    showType: showType,
                    action: "detailStatistic",
                    nonce: ajax.nonce
                },
                success: function(res) {

                    $('#country_chart').html('<canvas id="country" width="100%" height="60px"></canvas>')
                    let countryInfo = '';
                    var counts = res.country_count;
                    var sum = 0;
                    for (var i = 0; i < counts.length; i++) {
                        sum += counts[i];
                    }
                    var percentages = [];
                    for (var i = 0; i < counts.length; i++) {
                        var percentage = (counts[i] / sum) * 100;
                        percentages.push(percentage);
                    }


                    for (var i = 0; i < res.country_name.length; i++) {
                        var osName = res.country_name[i];
                        var percentage = percentages[i];
                        countryInfo += `<li><i class="fas fa-arrow-right me-2 regionColorPoint"></i>${percentage.toFixed(2)}% - ${osName}</li>`;
                    }

                    $('#country-info-data').html(countryInfo);
                    var ctx = document.getElementById('country');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: res.country_name,
                            datasets: [{
                                data: res.country_count,
                                backgroundColor: chartBarBgColors(),

                            }],
                        },
                        options: {
                            aspectRatio: 1,
                            responsive: true,
                            maintainAspectRatio: true,
                            elements: {
                                line: {
                                    tension: 0 // disables bezier curves
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: false
                                }]
                            },
                            legend: {
                                display: false,
                            }
                        }
                    });
                    var planPoints = $('.regionColorPoint');
                    planPoints.each(function(key, planPoint) {
                        var planPoint = $(planPoint)
                        planPoint.css('color', chartBarBgColors()[key])
                    })
                }
            })
        }).change();

        $('#host_statisstics_time').on('change', function() {
            var time = $('#host_statisstics_time').val();
            var showType = $('[name=data_show_type_for_host]').val();

            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    duration: time,
                    showType: showType,
                    action: "detailStatistic",
                    nonce: ajax.nonce
                },
                success: function(res) {
                    $('#host_chart').html('<canvas id="host" width="100%" height="60px"></canvas>');
                    let hostInfo = '';
                    var counts = res.host_count;
                    var sum = 0;
                    for (var i = 0; i < counts.length; i++) {
                        sum += counts[i];
                    }
                    var percentages = [];
                    for (var i = 0; i < counts.length; i++) {
                        var percentage = (counts[i] / sum) * 100;
                        percentages.push(percentage);
                    }


                    for (var i = 0; i < res.host_name.length; i++) {
                        var osName = res.host_name[i];
                        var percentage = percentages[i];
                        hostInfo += `<li><i class="fas fa-arrow-right me-2 hostColorPoint"></i>${percentage.toFixed(2)}% - ${osName}</li>`;
                    }

                    $('#host-info-data').html(hostInfo);
                    var ctx = document.getElementById('host');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: res.host_name,
                            datasets: [{
                                data: res.host_count,
                                backgroundColor: chartBarBgColors(),

                            }],
                        },
                        options: {
                            aspectRatio: 1,
                            responsive: true,
                            maintainAspectRatio: true,
                            elements: {
                                line: {
                                    tension: 0 // disables bezier curves
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: false
                                }]
                            },
                            legend: {
                                display: false,
                            }
                        }
                    });
                    var planPoints = $('.hostColorPoint');
                    planPoints.each(function(key, planPoint) {
                        var planPoint = $(planPoint)
                        planPoint.css('color', chartBarBgColors()[key])
                    })
                }
            });
        }).change()


        $('[name=data_show_type]').on('change', function() {
            $('#browser_statisstics_time').trigger('change');
        });
        $('[name=data_show_type_for_os]').on('change', function() {
            $('#os_statisstics_time').trigger('change');
        });
        $('[name=data_show_type_for_country]').on('change', function() {
            $('#country_statisstics_time').trigger('change');
        });
        $('[name=data_show_type_for_host]').on('change', function() {
            $('#host_statisstics_time').trigger('change');
        });
        
        $('#ip_select_table').on('change', function() {
            var time = $('#ip_select_table').val();
            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    skip: 0,
                    duration: time,
                    action: "ipList",
                    nonce: ajax.nonce
                },
                success: function(res) {
                    $('#data-wrapper').html(res.html);
                }
            });
        }).change();

        $('.loadMore').click(function() {
            var time = $('#ip_select_table').val();
            var len = $(document).find('#data-wrapper').find('tr').length;
            $(this).text('Loading...');
            $.ajax({
                type: "post",
                url: ajax.url,
                data: {
                    ad_id: <?php echo absint(ovoads_request()->id) ?>,
                    skip: len,
                    duration: time,
                    action: "ipList",
                    nonce: ajax.nonce
                },
                success: function(res) {
                    $('.loadMore').text('Load More');
                    if (!res.html) {
                        $('.loadMore').closest('.card-footer').remove();
                    }
                    $('#data-wrapper').append(res.html);
                }
            });
        });
    })(jQuery)
</script>