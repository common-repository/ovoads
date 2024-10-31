<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$html = '<a href="' . esc_url(ovoads_route_link('admin.advertise.create', pageName: ovoads_request()->page)) . '" class="btn btn--primary"><i class="las la-plus"></i> ' . __('Create New Ad', 'ovoads') . '</a>';

ovoads_admin_top($pageTitle, $html);?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card p-0">
            <div class="card-header d-flex align-items-center flex-wrap justify-content-between gap-2">
                <h6 class="mb-0"><?php esc_html_e('List of your created advertises', 'ovoads') ?></h6>
                <form method="GET" action="<?php echo esc_url(ovoads_route_link('admin.advertise.index', pageName: ovoads_request()->page)); ?>" class="table-search-form d-flex justify-content-end">
                    <div class="form-group">
                        <input type="hidden" name="page" value="ovoads_advertise">
                        <input class="form-control form--control" type="text" name="search" placeholder="<?php esc_html_e('Search by title', 'ovoads') ?>" value="<?php echo esc_attr(ovoads_request()->search); ?>">
                        <button type="submit" class="search-btn"><i class="las la-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Title', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Status', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Clicks', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Impressions', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Keywords', 'ovoads'); ?></th>
                                <th><?php esc_html_e('Action', 'ovoads'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($advertises->data as $advertise) { 
                                   
                                ?>
                                <tr>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html($advertise->title)); ?></td>
                                    <td>
                                        <?php
                                        if ($advertise->status == 1) { ?>
                                            <span class="badge bg--success"><?php esc_html_e('Active', 'ovoads'); ?></span>
                                        <?php } else { ?>
                                            <span class="badge bg--danger"><?php esc_html_e('Inactive', 'ovoads'); ?></span>

                                        <?php } ?>
                                    </td>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html($advertise->clicks)); ?></td>
                                    <td><?php printf(esc_html__('%s', 'ovoads'), esc_html($advertise->impressions)); ?></td>
                                    <td>
                                        <?php 
                                            $keywords = json_decode($advertise->keywords);
                                            if($keywords){
                                                foreach($keywords as $k){
                                                    echo '<span class="badge bg--primary me-1">'.esc_html($k).'</span>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn--primary copy-code-btn" data-id="<?php echo intval($advertise->id); ?>"  data-bs-toggle="modal"
                                        data-script="<div class='advertisementDiv' data-ad='<?php echo esc_attr($advertise->ad_code); ?>' data-adsize='<?php echo esc_attr($advertise->ad_size_id); ?>'></div><script class='adInnerScriptClass' src='<?php echo esc_url(ovoads_asset("public/js/ad.js")) ?>'></script>"
                                        data-bs-target="#copyScriptModal"><i class="la la-code"></i></button>

                                        <a class="btn btn--primary" href="<?php echo esc_url(ovoads_route_link('admin.advertise.edit', pageName: ovoads_request()->page)) ?>&id=<?php echo intval($advertise->id) ?>"><i class="la la-pencil"></i></a>
                                        <a class="btn btn--secondary " href="<?php echo esc_url(ovoads_route_link('admin.advertise.detail', pageName: ovoads_request()->page)); ?>&id=<?php echo intval($advertise->id) ?>"><i class="la la-chart-bar"></i> </a>
                                       
                                        <button class="btn btn--<?php echo ($advertise->status == 1) ? 'danger' : 'success' ?> actionBtn" data-id="<?php echo intval($advertise->id); ?>" data-content='<?php echo wp_json_encode($advertise) ?>' data-bs-toggle="modal" data-bs-target="#statusConfirmation"><i class="la la-eye<?php echo ($advertise->status == 1) ? '-slash' : '' ?>"></i> </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (ovoads_check_empty($advertises->data)) { ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('No ads created yet.', 'ovoads'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <?php if ($advertises->pagination) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($advertises->pagination, ovoads_allowed_html()); ?>
                </div>
            <?php } ?>
        </div><!-- card end -->
    </div>
</div>
<!-- Modal -->
<div class="modal" id="copyScriptModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="copyScriptModalLabel" aria-hidden="true">
    <input type="hidden" name="id">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="copyScriptModalLabel"><?php esc_html_e('Your ad script, copy and paste where you want', 'ovoads') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ovoads-textarea-content">
                    <div class="ad-script-textarea"></div>
                    <div class="textarea-detail">
                        <p id="copytext"><?php esc_html_e('Copy', 'ovoads');?></p>
                    </div>
                    <textarea spellcheck="false" class="form-control form--control copy-textarea-content" readonly cols="30" rows="7"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

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

<?php
ovoads_admin_bottom();
?>

<script>
    (function($) {
        "use strict";
        $('.copy-code-btn').click(function() {
            var modal = $('copyScriptModal');
            modal.find('[name=id]').val(jQuery(this).data('id'));
            modal.modal('show');
            var textarea = $('.copy-textarea-content');
            var textarea_value = $(this).data('script');
            textarea.val(textarea_value);
        });
        $('.ovoads-textarea-content').click(function(){
            var textarea_content = $('.copy-textarea-content');
            textarea_content.select();
            document.execCommand('copy');
            $('#copytext').text('Copied');
        });

           //for status change
           $('.actionBtn').click(function() {
            var modal = $('#statusConfirmation');
            modal.find('#adId').val($(this).data('id'));

            var content = $(this).data('content');
            var delete_action = $('#confirmBtn');
            var url = '<?php echo esc_url(ovoads_route_link('admin.advertise.status', pageName: 'ovoads_advertise')); ?>&id=' + content.id;
            url = url.replace(/#038;/g, '');
            delete_action.attr('href', url);

            // Set the title based on the action
            var confirmationTitle = modal.find('#confirmationTitle');
            var confirmationMessage = modal.find('#confirmationMessage');
            if (content.status == 1) {
                confirmationTitle.text('Are you sure to disable?');
                confirmationMessage.text('Once you disable the advertise, it will not appear anywhere. But you will be able to enable the advertise again.');
            } else {
                confirmationTitle.text('Are you sure to enable?');
                confirmationMessage.text('If you enable the advertise, it will appear everywhere. But you will be able to disable the advertise again.');
            }

            modal.modal('show');
        });
    })(jQuery)
</script>