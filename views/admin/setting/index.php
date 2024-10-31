<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
 ovoads_admin_top($pageTitle); ?>
<div class="row">
    <div class="col-12">
        <div class="card custom--card">
            <form action="<?php echo esc_url(ovoads_route_link('admin.setting.store'));?>" method="post">
                <?php echo esc_html(ovoads_nonce_field('admin.setting.store'));?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="form-label"><?php esc_html_e('API Key', 'ovoads');?></label>
                                <input type="text" class="form-control form--control" name="ovoads_apikey" value="<?php echo esc_attr(get_option('ovoads_apikey'));?>" required>
                                <small><i class="las la-info-circle"></i> <?php esc_html_e('Ipinfo.io api key input field', 'ovoads');?></small>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn--primary"> <i class="las la-check-circle"></i> <?php esc_html_e('Save', 'ovoads');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php ovoads_admin_bottom(); ?>