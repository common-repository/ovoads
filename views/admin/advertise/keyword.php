<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$html = '<button data-bs-toggle="modal" data-bs-target="#CreateNewKeyword" class="btn btn--primary"><i class="las la-plus"></i> ' . __('Add New', 'ovoads') . '</button>';
ovoads_admin_top($pageTitle, $html); ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card p-0">
            <div class="card-header d-flex align-items-center flex-wrap justify-content-between gap-2">
                <h6 class="mb-0"><?php esc_html_e('List Of Keywords', 'ovoads') ?></h6>
                <form method="GET" action="<?php echo esc_url(ovoads_route_link('admin.ad.keyword.index', pageName: ovoads_request()->page)); ?>" class="table-search-form d-flex justify-content-end">
                    <div class="form-group">
                        <input type="hidden" name="page" value="ovoads_keywords">
                        <input class="form-control form--control" type="text" name="search" placeholder="<?php esc_html_e('Search by keyword', 'ovoads') ?>" value="<?php echo esc_attr(ovoads_request()->search); ?>">
                        <button type="submit" class="search-btn"><i class="las la-search"></i></button>
                    </div>
                </form>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Keyword', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Status', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Created At', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Action', 'ovoads'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($keywords->data as $item) {
                            ?>
                                <tr>
                                    <td><?php echo esc_html($item->keyword); ?></td>
                                    <td>
                                        <?php
                                        if ($item->status == 1) { ?>
                                            <span class="badge bg--success"><?php esc_html_e('Active', 'ovoads') ?></span>
                                        <?php } else { ?>
                                            <span class="badge bg--danger"><?php esc_html_e('Inactive', 'ovoads') ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo esc_html(gmdate('d-m-Y, h:i a', strtotime($item->created_at))); ?></td>
                                    <td>
                                        <button class="btn btn--primary editBtn" data-id="<?php echo absint($item->id) ?>" data-content='<?php echo wp_json_encode($item) ?>' data-bs-toggle="modal" data-bs-target="#editModal"><i class="la la-pencil"></i></button>

                                        <button class="btn btn--<?php echo ($item->status == 1) ? 'danger' : 'success' ?> actionBtn" data-id="<?php echo absint($item->id) ?>" data-content='<?php echo wp_json_encode($item) ?>' data-bs-toggle="modal" data-bs-target="#statusConfirmation"><i class="la la-eye<?php echo ($item->status == 1) ? '-slash' : '' ?>"></i> </button>

                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (ovoads_check_empty($keywords->data)) { ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('No ads created yet.', 'ovoads'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <?php if ($keywords->pagination) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($keywords->pagination, ovoads_allowed_html()); ?>
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
                <a class="btn btn--primary action-btn" id="confirmBtn"> <?php esc_html_e('Yes', 'ovoads'); ?> </a>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> <?php esc_html_e('No', 'ovoads'); ?> </button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="CreateNewKeyword" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CreateNewKeywordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-area">
                    <h4><?php esc_html_e('Add Keyword', 'ovoads') ?></h4>
                    <p><?php esc_html_e('This keyword will be used to create advertisements and add domains. Advertisements will be shown to the domain according to these keywords.', 'ovoads') ?></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo esc_url(ovoads_route_link('admin.ad.keyword.store', pageName: ovoads_request()->page)); ?>" method="POST">
                    <?php echo esc_html(ovoads_nonce_field('admin.ad.keyword.store')); ?>
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Keyword Name', 'ovoads') ?></label>
                        <input type="text" class="form-control form--control" name="keyword" required value="<?php echo esc_attr(ovoads_old('keyword')) ?>">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn--primary"><?php esc_html_e('Save', 'ovoads') ?></button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="editModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <input type="hidden" name="modalId">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-area">
                    <h4><?php esc_html_e('Edit Keyword', 'ovoads') ?></h4>
                    <p><?php esc_html_e('Update the keyword if you think that the current keyword is not perfect', 'ovoads') ?></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo esc_url(ovoads_route_link('admin.ad.keyword.update', pageName: ovoads_request()->page)); ?>" method="POST">
                    <?php echo esc_html(ovoads_nonce_field('admin.ad.keyword.update')); ?>
                    <input type="hidden" name="id" class="keyword-id-input">
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Keyword Name', 'ovoads') ?></label>
                        <input type="text" class="form-control form--control keyword-name-input" name="keyword" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn--primary"><?php esc_html_e('Update', 'ovoads'); ?></button>
                    </div>
                </form>
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

        $('.editBtn').click(function() {
            var modal = $('editModal');
            modal.find('[name=modalId]').val(jQuery(this).data('id'));
            modal.modal('show');
            var content = $(this).data('content');
            $('.keyword-id-input').val(content.id);
            $('.keyword-name-input').val(content.keyword);
        });

        //for status change
        $('.actionBtn').click(function() {
            var modal = $('#statusConfirmation');
            modal.find('#adId').val($(this).data('id'));

            var content = $(this).data('content');
            var delete_action = $('#confirmBtn');
            var url = '<?php echo esc_url(ovoads_route_link('admin.ad.keyword.status', ['pageName' => 'ovoads_keywords'])); ?>&id=' + content.id;
            url = url.replace(/#038;/g, '');
            delete_action.attr('href', url);

            // Set the title based on the action
            var confirmationTitle = modal.find('#confirmationTitle');
            var confirmationMessage = modal.find('#confirmationMessage');
            if (content.status == 1) {
                confirmationTitle.text('Are you sure to disable?');
                confirmationMessage.text('Once you disable the keyword, it will not appear anywhere. But you will be able to enable the keyword again.');
            } else {
                confirmationTitle.text('Are you sure to enable?');
                confirmationMessage.text('If you enable the keyword, it will appear everywhere. But you will be able to disable the keyword again.');
            }

            modal.modal('show');
        });

    })(jQuery)
</script>

