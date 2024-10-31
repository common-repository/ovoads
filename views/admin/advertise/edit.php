<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$html = '<a href="' . esc_url(ovoads_route_link('admin.advertise.index', pageName: ovoads_request()->page)) . '" class="btn btn--primary"><i class="las la-arrow-left"></i> ' . __('Back', 'ovoads') . '</a>';;

ovoads_admin_top($pageTitle, $html);?>
<form action="<?php echo esc_url(ovoads_route_link('admin.advertise.update', pageName: ovoads_request()->page)); ?>" method="POST">
    <input type="hidden" value="<?php echo esc_attr(ovoads_request()->id); ?>" name="id" />
    <div class="card">
        <div class="card-header">
            <h5><?php echo esc_html_e('Select ad size', 'ovoads'); ?></h5>
        </div>
        <div class="card-body">
            <?php echo esc_html(ovoads_nonce_field('admin.advertise.update')); ?>
            <div class="row">
                <?php foreach ($adSizes as $key => $size) : ?>
                    <div class="col-lg-2 col-md-4 col-sm-4 cl">
                        <div class="plans">
                            <label class="plan basic-plan" for="basic<?php echo absint($size->id) ?>">
                                <input type="radio" <?php echo esc_attr($size->id == $ad->ad_size_id ? 'checked' : ''); ?> name="size_id" id="basic<?php echo intval($size->id); ?>" value="<?php echo esc_attr($size->id); ?>" />
                                <div class="plan-content">
                                    <div class="plan-details">
                                        <span><?php printf(esc_html__('%s', 'ovoads'), esc_html($size->name)); ?></span>
                                        <small><?php esc_html_e('Width:', 'ovoads') ?> <?php printf(esc_html__('%s', 'ovoads'), esc_html($size->width)); ?></small><br>
                                        <small><?php esc_html_e('Height:', 'ovoads') ?> <?php printf(esc_html__('%s', 'ovoads'), esc_html($size->height)); ?></small><br>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- card end -->
    <div class="card mt-2 rounded shadow-md">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col=md-6">
                    <div class="form-group">
                        <label class="form--label"><?php esc_html_e('Ad Title', 'ovoads') ?></label>
                        <input type="text" class="form-control form--control" value="<?php echo esc_attr($ad->title); ?>" name="ad_title">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label class="form--label"><?php esc_html_e('Redirect URL', 'ovoads') ?></label>
                        <input type="url" class="form-control form--control" name="ad_redirect_url" value="<?php echo esc_attr($ad->redirect_url); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <div class="ovoads_media_uploader">
                            <button class="ovoads_wp_media_btn custom_wp_media_btn"><?php esc_html_e('Ad Image', 'ovoads') ?></button>
                            <img src="<?php echo esc_url(ovoads_get_media_file($ad->ad_image)) ?>" alt="" class="ovoads_media_upload" width="100">
                            <input type="hidden" class="ovoads_media_input" value="<?php echo esc_attr($ad->ad_image); ?>" name="ad_image" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Keywords', 'ovoads'); ?></label>
                        <select class="mw-100 form-control form--control select2-auto-tokenize" name="keywords[]" multiple="multiple" required>
                            <?php  
                            $selected_keywords = json_decode($ad->keywords); 
                            foreach($activeKeywords as $keyword) {
                                echo '<option value="' . esc_attr($keyword->keyword) . '" ' . (in_array($keyword->keyword, $selected_keywords) ? 'selected' : '') . '>' . esc_html($keyword->keyword) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn--primary"><?php esc_html_e('Save', 'ovoads') ?></button>
            </div>
        </div>
    </div>
</form>

<?php
ovoads_admin_bottom();
?>

<script>
    jQuery(document).ready(function($) {
        'use strict';
        $('.select2-basic').select2();
        $('.select2-multi-select').select2();
        $('.select2-auto-tokenize').select2({
            tags: true,
            tokenSeparators: [',']
        });
    });
</script>