<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

ovoads_admin_top($pageTitle); ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card p-0">
            <div class="card-header d-flex align-items-center flex-wrap justify-content-between gap-2">
                <h6 class="mb-0"><?php esc_html_e('List Of Advertise Ip', 'ovoads') ?></h6>
                <form method="GET" action="<?php echo esc_url(ovoads_route_link('admin.ad.ip.log.index', pageName: ovoads_request()->page)); ?>" class="table-search-form d-flex justify-content-end">
                    <div class="form-group">
                        <input type="hidden" name="page" value="ovoads_ip_logs">
                        <input class="form-control form--control" type="text" name="search" placeholder="<?php esc_html_e('Search by ip', 'ovoads') ?>" value="<?php echo esc_attr(ovoads_request()->search); ?>">
                        <button type="submit" class="search-btn"><i class="las la-search"></i></button>
                    </div>
                </form>

            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('IP', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Ad', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Country', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Time', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Date', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Action', 'ovoads'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ipLogs->data as $item) {

                            ?>
                                <tr>
                                    <td><?php echo esc_html($item->ip); ?></td>
                                    <td>
                                        <?php printf(esc_html__('%s', 'ovoads'), esc_html($item->ad->title)); ?>
                                    </td>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html($item->country)); ?></td>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html(gmdate('h:i a', strtotime($item->created_at)))); ?></td>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html(gmdate('d-m-Y', strtotime($item->created_at)))); ?></td>
                                    <td>
                                        <button class="btn btn--<?php echo ($item->ip_status == 1) ? 'danger' : 'success' ?> actionBtn" data-id="<?php echo absint($item->id) ?>" data-content='<?php echo wp_json_encode($item) ?>' data-bs-toggle="modal" data-bs-target="#statusConfirmation"><i class="la la-eye<?php echo ($item->ip_status == 1) ? '-slash' : '' ?>"></i><?php echo ($item->ip_status == 1) ? esc_html_e(' Block', 'ovoads') : esc_html_e(' Unblock', 'ovoads') ?> </button>

                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (ovoads_check_empty($ipLogs->data)) { ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('No ads created yet.', 'ovoads'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <?php if ($ipLogs->pagination) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($ipLogs->pagination, ovoads_allowed_html()); ?>
                </div>
            <?php } ?>
        </div><!-- card end -->
    </div>
</div>
<!-- Modal -->
<div class="modal" id="statusConfirmation" data-bs-keyboard="false" tabindex="-1" aria-labelledby="statusConfirmationLabel" aria-hidden="true">
    <input type="hidden" name="adId" id="adId">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php esc_html_e('Confirmation', 'ovoads') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="confirmationTitle"></h5>
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer text-end">
                <a class="btn btn--primary action-btn" id="confirmBtn"> <?php esc_html_e('Yes', 'ovoads') ?> </a>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> <?php esc_html_e('No', 'ovoads') ?> </button>
            </div>
        </div>
    </div>
</div>
<?php ovoads_admin_bottom(); ?>
<script>
    (function($) {
        "use strict";
         //for status change
         $('.actionBtn').click(function() {
            var modal = $('#statusConfirmation');
            modal.find('#adId').val($(this).data('id'));

            var content = $(this).data('content');
            var delete_action = $('#confirmBtn');
            var url = '<?php echo esc_url(ovoads_route_link('admin.ad.report.ip.status', pageName: 'ovoads_ip_logs')); ?>&id=' + content.id;
            url = url.replace(/#038;/g, '');
            delete_action.attr('href', url);

            // Set the title based on the action
            var confirmationTitle = modal.find('#confirmationTitle');
            var confirmationMessage = modal.find('#confirmationMessage');
            if (content.ip_status == 1) {
                confirmationTitle.text('Are you sure to block?');
                confirmationMessage.text('Once you block the advertise, it can not access again. But you will be able to unblock the advertise again.');
            } else {
                confirmationTitle.text('Are you sure to unblock?');
                confirmationMessage.text('If you unblock the advertise, it can access again. But you will be able to block the advertise again.');
            }

            modal.modal('show');
        });

    })(jQuery)
</script>