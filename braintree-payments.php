<?php
/*
Plugin Name: Braintree Payments
Plugin URI: https://www.brontobytes.com/blog/braintree-payments-free-wordpress-plugin/
Description: Seamlessly accept one-time payments on your site using Braintree's Drop-in UI.
Author: Brontobytes
Author URI: https://www.brontobytes.com/
Version: 1.0
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

function braintree_payments_menu() {
	add_options_page('Braintree Payments Settings', 'Braintree Payments', 'administrator', 'braintree-payments-settings', 'braintree_payments_settings_page', 'dashicons-admin-generic');
}
add_action('admin_menu', 'braintree_payments_menu');

function braintree_payments_settings_page() { ?>
<div class="wrap">
<h2>Braintree Payments Settings</h2>
<p>This plugin allows you to seamlessly accept one-time payments on your site using your Braintree account.</p>
<form method="post" action="options.php">
    <?php
		settings_fields( 'braintree-payments-settings' );
		do_settings_sections( 'braintree-payments-settings' );
	?>
    <table class="form-table">
        <tr valign="top">
			<th scope="row"><label for="braintree_payments_id">Payment ID</label></th>
			<td>
				<input type="text" size="10" name="braintree_payments_id" value="<?php echo esc_attr( get_option('braintree_payments_id') ); ?>" /> <small>Ex. Inv1001<br /><strong>IMPORTANT! You can then access the payment form at https://YourWordpressWebsite.com/#bt-<i>Inv1001</i></strong></small>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="braintree_payments_amount">Amount</label></th>
			<td>
				<input type="text" size="10" name="braintree_payments_amount" value="<?php echo esc_attr( get_option('braintree_payments_amount') ); ?>" /> <small>Ex. 11.20</small>
			</td>
        </tr>
		<tr valign="top">
			<th scope="row"><label for="braintree_payments_currency">Currency</label></th>
			<td>
				<input type="text" size="10" name="braintree_payments_currency" value="<?php echo esc_attr( get_option('braintree_payments_currency') ); ?>" /> <small>Ex. USD<br />More info at <a href="https://developers.braintreepayments.com/reference/general/currencies">https://developers.braintreepayments.com/reference/general/currencies</a></small>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="braintree_payments_locale">Locale</label></th>
			<td>
				<input type="text" size="10" name="braintree_payments_locale" value="<?php echo esc_attr( get_option('braintree_payments_locale') ); ?>" /> <small>Ex. en_US<br />Supported locales include: da_DK, de_DE, en_AU, en_GB, en_US, es_ES, fr_CA, fr_FR, id_ID, it_IT, ja_JP, ko_KR, nl_NL, no_NO, pl_PL, pt_BR, pt_PT, ru_RU, sv_SE, th_TH, zh_CN, zh_HK, zh_TW</small>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="braintree_payments_auth">Tokenization Key</label></th>
			<td>
				<input type="text" size="50" name="braintree_payments_auth" value="<?php echo esc_attr( get_option('braintree_payments_auth') ); ?>" /> <small>Ex. production_1tu5c9mn_hgh5y6t3juipa12c<br />Log into either the <a href="https://www.braintreegateway.com/login">production Control Panel</a> or the <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a>, depending on which environment you are working in and navigate to Settings > API Keys<br />More info at <a href="https://developers.braintreepayments.com/guides/authorization/tokenization-key/javascript/v3">https://developers.braintreepayments.com/guides/authorization/tokenization-key/javascript/v3</a></small>
			</td>
        </tr>
		<tr valign="top">
			<th scope="row"><label for="braintree_payments_paypal">Show PayPal Option</label></th>
			<td>
				<input type="checkbox" name="braintree_payments_paypal" value="true" <?php echo ( get_option('braintree_payments_paypal') == true ) ? ' checked="checked" />' : ' />'; ?><br /><small>PayPal option should be first enabled in your braintree account<br /> More info at <a href="https://articles.braintreepayments.com/guides/payment-methods/paypal/setup-guide">https://articles.braintreepayments.com/guides/payment-methods/paypal/setup-guide</a></small>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="braintree_payments_powered_by">Discreet 'powered by' link</label></th>
			<td>
				<input type="checkbox" name="braintree_payments_powered_by" value="true" <?php echo ( get_option('braintree_payments_powered_by') == true ) ? ' checked="checked" />' : ' />'; ?><br /><small>We are very happy to be able to provide this and other <a href="https://www.brontobytes.com/blog/c/wordpress-plugins/">free WordPress plugins</a></small>
			</td>
		</tr>
    </table>
    <?php submit_button(); ?>
</form>
<p>Plugin developed by <a href="https://www.brontobytes.com/"><img width="100" style="vertical-align:middle" src="<?php echo plugins_url( 'images/brontobytes.svg', __FILE__ ) ?>" alt="Web hosting provider"></a></p>
</div>
<?php }

function braintree_payments_settings() {
	register_setting( 'braintree-payments-settings', 'braintree_payments_id' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_amount' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_currency' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_locale' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_auth' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_paypal' );
	register_setting( 'braintree-payments-settings', 'braintree_payments_powered_by' );
}
add_action( 'admin_init', 'braintree_payments_settings' );

function braintree_payments_deactivation() {
    delete_option( 'braintree_payments_id' );
    delete_option( 'braintree_payments_amount' );
    delete_option( 'braintree_payments_currency' );
    delete_option( 'braintree_payments_locale' );
    delete_option( 'braintree_payments_auth' );
    delete_option( 'braintree_payments_paypal' );
    delete_option( 'braintree_payments_powered_by' );
}
register_deactivation_hook( __FILE__, 'braintree_payments_deactivation' );

function braintree_payments_dependencies() {
	wp_register_script( 'braintree-payments-index', plugins_url('js/index.js', __FILE__),  array('jquery'), '', true );
	wp_enqueue_script( 'braintree-payments-index' );
	wp_register_style( 'braintree-payments-style', plugins_url('css/style.css', __FILE__) );
	wp_enqueue_style( 'braintree-payments-style' );
}
add_action( 'wp_enqueue_scripts', 'braintree_payments_dependencies' );

function sendContactFormToSiteAdmin () {
  try {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['tel'])) {
      throw new Exception('Bad form parameters. Check the markup to make sure you are naming the inputs correctly.');
    }
    if (!is_email($_POST['email'])) {
      throw new Exception('Email address not formatted correctly.');
    }
	
    $subject = 'Braintree Payments: ' . sanitize_text_field($_POST['name']) . ' - ' . sanitize_text_field(get_option('braintree_payments_amount')) . sanitize_text_field(get_option('braintree_payments_currency'));
	$headers = array('From: ' . sanitize_text_field(get_option('blogname')) . ' <' . sanitize_email(get_option('admin_email')) . ' >','Reply-To: ' . sanitize_text_field($_POST['name']) . ' < ' . sanitize_email($_POST['email']) . ' >');
    $send_to = sanitize_email(get_option('admin_email'));
    $message = "Possible payment!\n\nName: " . sanitize_text_field($_POST['name']).":\n\nPhone Number: ". sanitize_text_field($_POST['tel']) . "\n\nAmount: " . sanitize_text_field(get_option('braintree_payments_amount')) . sanitize_text_field(get_option('braintree_payments_currency')) . "\n\nMake sure to check your Braintree account as this email just notifies you for an attempt of payment.";
 
    if (wp_mail($send_to, $subject, $message, $headers)) {
      echo json_encode(array('status' => 'success', 'message' => 'Form sent.'));
      exit;
    } else {
      throw new Exception('Failed to send. Check AJAX handler.');
    }
  } catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
    exit;
  }
}
add_action("wp_ajax_contact_send", "sendContactFormToSiteAdmin");
add_action("wp_ajax_nopriv_contact_send", "sendContactFormToSiteAdmin");

//https://braintree.github.io/braintree-web-drop-in/docs/current/module-braintree-web-drop-in.html
function braintree_payments() { ?>
<!-- Braintree Payments -->
<div class="remodal" data-remodal-id="<?php if (get_option('braintree_payments_id')==''){ echo "#"; }else{ echo "bt-".esc_attr( get_option('braintree_payments_id') ); } ?>">
<div style="text-align:left;">Personal details</div>

  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      var is_sending = false,
          failure_message = 'Whoops, looks like there was a problem. Please try again later or contact site admin.';
 
      $('#braintree-contact-form').submit(function (e) {
        e.preventDefault(); // Prevent the default form submit
        $this = $(this); // Cache this
        $.ajax({
          url: '<?php echo admin_url("admin-ajax.php") ?>', // Let WordPress figure this url out...
          type: 'post',
          dataType: 'JSON', // Set this so we don't need to decode the response...
          data: $this.serialize(), // One-liner form data prep...
          beforeSend: function () {
            is_sending = true;
            window.location.href = '<?php echo "#btco-".esc_attr(get_option('braintree_payments_id')); ?>';
          },
          error: handleFormError,
          success: function (data) {
            if (data.status === 'success') {
              // Here, you could trigger a success message
            } else {
              handleFormError(); // If we don't get the expected response, it's an error...
            }
          }
        });
      });
 
      function handleFormError () {
        is_sending = false; // Reset the is_sending var so they can try again...
        alert(failure_message);
      }

    });
  </script>

<form id="braintree-contact-form">
	<fieldset>
		<input class="inputgreen" name="name" type="text" placeholder="Full Name">
		<input class="inputgreen" name="email" type="email" placeholder="Email Address">
		<input class="inputgreen" name="tel" type="tel" placeholder="Phone Number">
		<input name="amount" type="hidden" value="<?php echo esc_attr( get_option('braintree_payments_amount') ) . esc_attr( get_option('braintree_payments_currency') ); ?>">
		<input type="hidden" name="action" value="contact_send" />
	</fieldset>
	
	<input class="paybutton paybuttongreen" type="submit" value="Proceed &raquo;"></input>
</form>

<?php if (get_option('braintree_payments_powered_by') == true) { ?> <a style="font-size:x-small;text-decoration:none;" href="https://www.brontobytes.com/blog/braintree-payments-free-wordpress-plugin/">Braintree Payments for Wordpress</a> <?php } ?>
</div>

<div class="remodal" data-remodal-id="<?php echo "btco-".esc_attr( get_option('braintree_payments_id') ); ?>">
<form id="payment-form">
	<script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"
		data-braintree-dropin-authorization="<?php if (get_option('braintree_payments_auth')==''){ echo " "; }else{ echo esc_attr( get_option('braintree_payments_auth') ); } ?>"
		data-card.cardholder-name="true"
		data-locale="<?php if (get_option('braintree_payments_locale')==''){ echo "en_US"; }else{ echo esc_attr( get_option('braintree_payments_locale') ); } ?>"
		data-payment-option-priority='["card"<?php if (get_option('braintree_payments_paypal') == true) { ?>,"paypal"<?php } ?>]'
		data-paypal.flow="checkout"
		data-paypal.amount="<?php if (get_option('braintree_payments_amount')==''){ echo "0.00"; }else{ echo esc_attr( get_option('braintree_payments_amount') ); } ?>"
		data-paypal.currency="<?php if (get_option('braintree_payments_currency')==''){ echo "USD"; }else{ echo esc_attr( get_option('braintree_payments_currency') ); } ?>"
	></script>
  
	<input class="paybutton paybuttongreen" type="submit" value="&#128274; Pay 
	<?php	if (get_option('braintree_payments_currency')=='USD'){ 
				echo "$";
			}elseif (get_option('braintree_payments_currency')=='EUR'){ 
				echo "&euro;";
			}elseif (get_option('braintree_payments_currency')=='GBP'){
				echo "&pound;";
			}
			echo esc_attr( get_option('braintree_payments_amount') );
			echo " " . esc_attr( get_option('braintree_payments_currency') );
	?>"></input>
</form>

<?php if (get_option('braintree_payments_powered_by') == true) { ?> <a style="font-size:x-small;text-decoration:none;" href="https://www.brontobytes.com/blog/braintree-payments-free-wordpress-plugin/">Braintree Payments for Wordpress</a> <?php } ?>
</div>
<!-- End Braintree Payments -->
<?php
}
add_action( 'wp_footer', 'braintree_payments', 10 );