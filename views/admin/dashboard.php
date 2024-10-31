<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

ovoads_admin_top($pageTitle); ?>
<div class="row gy-4">
    <div class="col-lg-3 col-sm-6">
        <div class="widget widget-primary bg-white p-3">
            <div class="widget__top">
                <i class="fas fa-ad"></i>
                <p class="fw-bold"><?php esc_html_e('Total Ads', 'ovoads') ?></p>
            </div>
            <div class="widget__bottom mt-3">
                <h4 class="widget__number"><?php printf(esc_html__('%s', 'ovoads'), esc_html(ovoads_number_format($totalAds)))  ?></h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="widget widget-success bg-white p-3">
            <div class="widget__top">
                <i class="fas fa-eye"></i>
                <p class="fw-bold"><?php esc_html_e('Published Ads', 'ovoads') ?></p>
            </div>
            <div class="widget__bottom mt-3">
                <h4 class="widget__number"><?php printf(esc_html__('%s', 'ovoads'), esc_html(ovoads_number_format($activeAds))) ?></h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="widget widget-danger bg-white p-3">
            <div class="widget__top">
                <i class="fas fa-eye-slash"></i>
                <p class="fw-bold"><?php esc_html_e('Unpublished Ads', 'ovoads') ?></p>
            </div>
            <div class="widget__bottom mt-3">
                <h4 class="widget__number"><?php printf(esc_html__('%s', 'ovoads'), esc_html(ovoads_number_format($inactiveAds))); ?></h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="widget widget-dark bg-white p-3">
            <div class="widget__top">
                <i class="fas fa-hand-pointer"></i>
                <p class="fw-bold"><?php esc_html_e('Total Clicks', 'ovoads') ?></p>
            </div>
            <div class="widget__bottom mt-3">
                <h4 class="widget__number"><?php echo esc_html(ovoads_number_format($totalClicks), 'ovoads') ?></h4>
            </div>
        </div>
    </div>

</div>
<div class="row mt-3">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6><?php echo esc_html_e('Statistics', 'ovoads') ?></h6>
            </div>
            <div class="card-body">
                <div id="area-statistics" width="400" height="400"></div>
            </div>
        </div>
    </div>
</div>
<?php ovoads_admin_bottom() ?>
<script>
    window.onload = function() {
        jQuery.ajax({
            type: "post",
            url: ajax.url,
            data: {
                action: "showStatisticsOnDashboard",
                nonce: ajax.nonce
            },
            success: function(res) {
                var labelCount = [];
                for (var i = 1; i <= res.adsRowCount; i++) {
                    labelCount.push(i);
                }
                var options = {
                    series: [{
                        name: 'Clicks',
                        data: res.click
                    }, {
                        name: 'Impressions',
                        data: res.impression
                    }],
                    chart: {
                        type: 'bar',
                        height: 450,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '50%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: labelCount,
                    },
                    yaxis: {
                        title: {
                        
                            style: {
                                color: '#7c97bb'
                            }
                        }
                    },
                    grid: {
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                    },
                    fill: {
                        opacity: 1
                    },
                };
                var chart = new ApexCharts(document.querySelector("#area-statistics"), options);
                chart.render();
            }
        })
    }
</script>