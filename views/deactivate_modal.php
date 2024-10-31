<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!-- Deactivate modal -->
<div class="ovoads-admin">
  <div class="modal ovoads-deactivate-modal" id="ovoadsDeactivateModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="modal-close-btn text--danger" data-bs-dismiss="modal"> <i class="fas fa-times"></i> </button>
        <div class="ovoads-dm-head">
          <h1 class="mb-3"><?php esc_html_e('Are you sure you want to deactivate?', 'ovoads') ?></h1>
          <p class="fs-20"><?php esc_html_e('Before you go, please share your feedback to us that why you\'re deactivating the plugin.', 'ovoads') ?></p>
        </div>
        <div class="modal-body">
          <form class="ovoads-deactivate-form">
            <div class="form-check">
              <input class="form-check-input" type="radio" checked name="deactivate_reason" value="<?php echo esc_attr('temporary', 'ovoads')?>" id="temporary">
              <label class="form-check-label" for="temporary"><?php esc_html_e('Temporary deactivation', 'ovoads')?></label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="deactivate_reason" value="<?php echo esc_attr('site_slow', 'ovoads')?>" id="site_slow">
              <label class="form-check-label" for="site_slow"><?php esc_html_e('It slowed down my site', 'ovoads')?></label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="deactivate_reason" value="<?php echo esc_attr('bugs', 'ovoads')?>" id="bugs">
              <label class="form-check-label" for="bugs"><?php esc_html_e('It\'s buggy','ovoads')?></label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="deactivate_reason" value="<?php echo esc_attr('found_better', 'ovoads')?>" id="found_better">
              <label class="form-check-label" for="found_better"><?php esc_html_e('I found a better plugin', 'ovoads')?></label>
              <input type="text" class="form-control form--control d-none reason_input mt-3" placeholder="Please, share the plugin name" name="reason">
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="deactivate_reason" value="<?php echo esc_attr('no_needs', 'ovoads')?>" id="no_needs">
              <label class="form-check-label" for="no_needs"><?php esc_html_e('I no longer need the plugin', 'ovoads')?></label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="deactivate_reason" value="<?php echo esc_attr('others', 'ovoads')?>" id="others">
              <label class="form-check-label" for="others"><?php esc_html_e('Others', 'ovoads')?></label>
              <input type="text" class="form-control form--control d-none reason_input mt-3" placeholder="Please, share the reason" name="reason">
            </div>
            <div class="d-flex justify-content-between ovoads-dm-footer">
              <a href="#" class="ovoads-skip-btn"><?php esc_html_e('Skip & Deactivate', 'ovoads')?></a>
              <button type="submit" class="btn btn--primary ovoads-submit-reason-btn"><?php esc_html_e('Submit & Deactivate', 'ovoads')?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Deactivate modal -->


<script>
  (function($) {
    "use strict";
    $('.ovoads-deactivate-link').click(function(e) {
      e.preventDefault();
      let modal = $('#ovoadsDeactivateModal');
      modal.modal('show');

      let actionUrl = $(this).attr('href');
      $('.ovoads-skip-btn').attr('href', actionUrl);

      $('.ovoads-deactivate-form').submit(function(e) {
        e.preventDefault();
        $('.ovoads-deactivate-modal').find('.ovoads-submit-reason-btn').text('Deactivating...')
        var deactivateCause = $('.ovoads-deactivate-modal').find('[name=deactivate_reason]:checked').val();
        var reason = $('.ovoads-deactivate-modal').find('[name=reason]').val();

        $.post("<?php echo esc_html(html_entity_decode(esc_url(ovoads_route_link('admin.deactivate.plugin')))) ?>", {
          cause:deactivateCause,
          reason:reason,
          nonce:"<?php echo esc_html(ovoads_nonce('admin.deactivate.plugin'))?>"
        },function (response) {
            window.location.href = actionUrl;
        });

      });

    });
  })(jQuery)
</script>