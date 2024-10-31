<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php
$html = '<button data-bs-toggle="modal" data-bs-target="#CreateNewDomain" class="btn btn--primary"><i class="las la-plus"></i> ' . __('Add New Domain', 'ovoads') . '</button>';

ovoads_admin_top($pageTitle, $html); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center flex-wrap justify-content-between gap-2">
                <h6 class="mb-0"><?php esc_html_e('List of your created domains', 'ovoads') ?></h6>
                <form method="GET" action="<?php echo esc_url(ovoads_route_link('admin.advertise.index', pageName: ovoads_request()->page)); ?>" class="table-search-form d-flex justify-content-end">
                    <div class="form-group">
                        <input type="hidden" name="page" value="ovoads_domain_list">
                        <input class="form-control form--control" type="text" name="search" placeholder="<?php esc_html_e('Search by domain name', 'ovoads') ?>" value="<?php echo esc_attr(ovoads_request()->search); ?>">
                        <button type="submit" class="search-btn"><i class="las la-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('#', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Domain', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Status', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Keywords', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Action', 'ovoads'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($domains->data as $k => $item) { ?>
                                <tr>
                                    <td><?php echo intval($k) + 1 ?></td>
                                    <td><?php echo esc_html($item->domain_name, 'ovoads') ?></td>
                                    <td>
                                        <?php
                                        if ($item->status == 1) { ?>
                                            <span class="badge bg--success"><?php esc_html_e('Active', 'ovoads') ?></span>
                                        <?php } else { ?>
                                            <span class="badge bg--danger"><?php esc_html_e('Inactive', 'ovoads') ?></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        $keywords = json_decode($item->keywords);
                                        if ($keywords) {
                                            foreach ($keywords as $k) {
                                                echo '<span class="badge bg--primary me-1">' . esc_html($k) . '</span>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo intval($item->id); ?>" data-content='<?php echo wp_json_encode($item) ?>' data-keywords='<?php echo wp_json_encode($keywords) ?>' class="btn btn-sm btn--primary edit-btn"><i class="la la-pencil"></i></button>

                                        <?php if ($item->status == 1) { ?>
                                            <button data-bs-toggle="modal" data-bs-target="#statusModal" data-id="<?php echo intval($item->id); ?>" data-content='<?php echo wp_json_encode($item) ?>' class="btn btn--danger btn-sm m-0 delete-btn"><i class="la la-eye-slash"></i></button>

                                        <?php } else { ?>
                                            <button data-bs-toggle="modal" data-bs-target="#statusModal" data-id="<?php echo intval($item->id); ?>" data-content='<?php echo wp_json_encode($item) ?>' class="btn btn--success btn-sm m-0 delete-btn"><i class="la la-eye"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (ovoads_check_empty($domains->data)) { ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('No domain created yet.', 'ovoads'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($domains->pagination) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($domains->pagination, ovoads_allowed_html()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal" id="CreateNewDomain" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CreateNewDomainLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-area">
                    <h4><?php esc_html_e('Add Domain', 'ovoads') ?></h4>
                    <p><?php esc_html_e('Your generated advertisement scripts will work only for these domains.', 'ovoads') ?></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo esc_url(ovoads_route_link('admin.ad.domain.store', pageName: ovoads_request()->page)) ?>" method="POST">
                    <?php echo esc_html(ovoads_nonce_field('admin.ad.domain.store')); ?>
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Domain Name', 'ovoads') ?></label>
                        <input type="text" class="form-control form--control" name="domain_name" placeholder="<?php esc_html_e('example.com', 'ovoads') ?>" required value="<?php echo esc_attr(ovoads_old('domain_name')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Keywords', 'ovoads'); ?></label>
                        <select class="mw-100 form-control form--control select2-auto-tokenize" name="keywords[]" multiple="multiple" required>
                            <?php foreach ($activeKeywords as $keyword) { ?>
                                <option value="<?php echo esc_attr($keyword->keyword); ?>"> <?php echo esc_html($keyword->keyword); ?></option>
                            <?php } ?>
                        </select>
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
                    <h4><?php esc_html_e('Edit Domain', 'ovoads') ?></h4>
                    <p><?php esc_html_e('Update the domain if you think that the current domain is not perfect', 'ovoads') ?></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo esc_url(ovoads_route_link('admin.ad.domain.update', pageName: ovoads_request()->page)); ?>" method="POST">
                    <?php echo esc_html(ovoads_nonce_field('admin.ad.domain.update')); ?>
                    <input type="hidden" name="id" class="domain-id-input">
                    <div class="form-group">
                        <label class="form-label"><?php echo esc_html_e('Domain Name', 'ovoads') ?></label>
                        <input type="text" class="form-control form--control domain-name-input" name="domain_name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Keywords', 'ovoads'); ?></label>
                        <select class="mw-100 form-control form--control select2-auto-tokenize" name="keywords[]" multiple="multiple" required id="editKeywordsSelect">
                            <option value=""></option>
                        </select>

                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn--primary"><?php esc_html_e('Update', 'ovoads') ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="statusModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <input type="hidden" name="deleteId">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4><?php esc_html_e('Confirmation', 'ovoads') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="confirmationTitle"></h5>
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer text-end">
                <a class="btn btn--primary delete-action-btn"> <?php esc_html_e('Yes', 'ovoads') ?> </a>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> <?php esc_html_e('No', 'ovoads') ?> </button>
            </div>
        </div>
    </div>
</div>


<?php ovoads_admin_bottom(); ?>

<script>
    (function($) {
        "use strict";

        $('.edit-btn').click(function() {
            var modal = $('#editModal');
            var content = $(this).data('content');
            modal.find('[name=modalId]').val($(this).data('id'));
            $('.domain-id-input').val(content.id);
            $('.domain-name-input').val(content.domain_name);
            var select2Element = $('#editKeywordsSelect');

            // Get the selected keywords and all available keywords
            var selectedKeywords = $(this).data('keywords');
            var allKeywords = <?php echo wp_json_encode($activeKeywords); ?>;

            // Create an array to hold options
            var options = [];

            // Loop through the selected keywords and create options
            for (var i = 0; i < selectedKeywords.length; i++) {
                var keyword = selectedKeywords[i];
                options.push(new Option(keyword, keyword, true, true));
            }

            // Loop through all available keywords and create options
            for (var i = 0; i < allKeywords.length; i++) {
                var keyword = allKeywords[i].keyword;
                // Check if the keyword is not already selected
                if (!selectedKeywords.includes(keyword)) {
                    options.push(new Option(keyword, keyword, false, false));
                }
            }

            // Clear the existing options in the select2
            select2Element.empty();

            // Append the options to the select2 element
            select2Element.append(options).trigger('change');

            // Initialize or update the select2
            select2Element.select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Select or enter keywords',
            });

            // Trigger a change event to update the select2's value
            select2Element.trigger('change');
        });



        $('.delete-btn').click(function() {
            var modal = $('#statusModal');
            modal.find('[name=deleteId]').val($(this).data('id'));
            modal.modal('show');
            var content = $(this).data('content');
            var delete_action = $('.delete-action-btn');


            var url = '<?php echo esc_url(ovoads_route_link('admin.ad.domain.status', array('pageName' => 'ovoads_domain_list'))); ?>&id=' + content.id;
            url = url.replace(/#038;/g, '');
            delete_action.attr('href', url);

            // Set the title based on the action
            var confirmationTitle = modal.find('#confirmationTitle');
            var confirmationMessage = modal.find('#confirmationMessage');
            if (content.status == 1) {
                confirmationTitle.text('Are you sure to disable?');
                confirmationMessage.text('Once you disable the domain, it will not appear anywhere. But you will be able to enable the domain again.');
            } else {
                confirmationTitle.text('Are you sure to enable?');
                confirmationMessage.text('If you enable the domain, it will appear everywhere. But you will be able to disable the domain again.');
            }

            modal.modal('show');
        });

        //for select2
        $(document).ready(function() {
            $('.select2-basic').select2();
            $('.select2-multi-select').select2();
            $('.select2-auto-tokenize').select2({
                tags: true,
                tokenSeparators: [',']
            });
        });

    })(jQuery)
</script>