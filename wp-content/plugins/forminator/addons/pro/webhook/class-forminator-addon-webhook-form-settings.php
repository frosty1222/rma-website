<?php

require_once dirname( __FILE__ ) . '/class-forminator-addon-webhook-form-settings-exception.php';

/**
 * Class Forminator_Addon_Webhook_Form_Settings
 * Handle how form settings displayed and saved
 *
 *
 */
class Forminator_Addon_Webhook_Form_Settings extends Forminator_Addon_Form_Settings_Abstract {

	/**
	 * @var Forminator_Addon_Webhook
	 *
	 */
	protected $addon;

	/**
	 * Forminator_Addon_Webhook_Form_Settings constructor.
	 *
	 *
	 *
	 * @param Forminator_Addon_Abstract $addon
	 * @param                           $form_id
	 *
	 * @throws Forminator_Addon_Exception
	 */
	public function __construct( Forminator_Addon_Abstract $addon, $form_id ) {
		parent::__construct( $addon, $form_id );

		$this->_update_form_settings_error_message = esc_html__(
			'The update to your settings for this form failed, check the form input and try again.',
			'forminator'
		);
	}

	/**
	 * Webhook Form Settings wizard
	 *
	 *
	 * @return array
	 */
	public function form_settings_wizards() {
		// numerical array steps.
		return array(
			// 0
			array(
				'callback'     => array( $this, 'setup_webhook_url' ),
				'is_completed' => array( $this, 'setup_webhook_url_is_completed' ),
			),
		);
	}

	/**
	 * Setup webhook url
	 *
	 *
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 */
	public function setup_webhook_url( $submitted_data ) {
		$this->addon_form_settings = $this->get_form_settings_values();

		$multi_id = $this->generate_multi_id();
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		unset( $submitted_data['multi_id'] );

		$is_submit = ! empty( $submitted_data );

		$current_data = array(
			'webhook_url' => '',
			'name'        => '',
		);

		if ( isset( $submitted_data['name'] ) ) {
			$submitted_data['name'] = sanitize_text_field( $submitted_data['name'] );
		}
		forminator_addon_maybe_log( __METHOD__, $submitted_data );

		$notification = array();

		foreach ( $current_data as $key => $value ) {
			if ( isset( $submitted_data[ $key ] ) ) {
				$current_data[ $key ] = $submitted_data[ $key ];
			} elseif ( isset( $this->addon_form_settings[ $multi_id ][ $key ] ) ) {
				$current_data[ $key ] = $this->addon_form_settings[ $multi_id ][ $key ];
			}
		}

		$error_message        = '';
		$input_error_messages = '';

		try {
			if ( $is_submit ) {
				$input_exceptions = new Forminator_Addon_Webhook_Form_Settings_Exception();
				if ( empty( $current_data['name'] ) ) {
					$input_exceptions->add_input_exception( esc_html__( 'Please create a name for this Webhook integration', 'forminator' ), 'name' );
				}

				$this->validate_and_send_sample( $submitted_data, $input_exceptions );
				$this->addon_form_settings = array_merge(
					$this->addon_form_settings,
					array(
						$multi_id => array(
							'webhook_url' => $submitted_data['webhook_url'],
							'name'        => $submitted_data['name'],
						),
					)
				);

				$this->save_form_settings_values( $this->addon_form_settings );
				$notification = array(
					'type' => 'success',
					'text' => '<strong>' . $this->addon->get_title() . ' [' . esc_html( $submitted_data['name'] ) . ']</strong> '
							. esc_html__( 'Successfully connected and sent sample data to your Webhook', 'forminator' ),
				);
			}
		} catch ( Forminator_Addon_Webhook_Form_Settings_Exception $e ) {
			$input_error_messages = $e->get_input_exceptions();
		} catch ( Forminator_Addon_Webhook_Exception $e ) {
			$error_message = '<div role="alert" class="sui-notice sui-notice-red sui-active" style="display: block; text-align: left;" aria-live="assertive">';

				$error_message .= '<div class="sui-notice-content">';

					$error_message .= '<div class="sui-notice-message">';

						$error_message .= '<span class="sui-notice-icon sui-icon-info" aria-hidden="true"></span>';

						$error_message .= '<p>' . $e->getMessage() . '</p>';

					$error_message .= '</div>';

				$error_message .= '</div>';

			$error_message .= '</div>';
		}

		$buttons = array();
		if ( $this->setup_webhook_url_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Webhook::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate Webhook from this Form.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
									Forminator_Addon_Webhook::get_button_markup( esc_html__( 'Save', 'forminator' ), 'sui-button-primary forminator-addon-finish' ) .
									'</div>';

		$help_message = esc_html__( 'Give your webhook integration a name and add the webhook URL.', 'forminator' );

		return array(
			'html'         => '<div class="forminator-integration-popup__header"><h3 class="sui-box-title sui-lg" id="dialogTitle2">' . esc_html__( 'Set Up Webhook', 'forminator' ) . '</h3>
							<p class="sui-description">' . $help_message . '</p>
							' . $error_message . '</div>
							<form enctype="multipart/form-data">
								<div class="sui-form-field ' . ( isset( $input_error_messages['name'] ) ? 'sui-form-field-error' : '' ) . '">
									<label class="sui-label">' . esc_html__( 'Friendly Name', 'forminator' ) . '</label>
									<div class="sui-control-with-icon">
										<input type="text"
											name="name"
											placeholder="' . esc_attr__( 'Enter a friendly name E.g. Zapier to Gmail', 'forminator' ) . '"
											value="' . esc_attr( $current_data['name'] ) . '"
											class="sui-form-control"
										/>
										<i class="sui-icon-web-globe-world" aria-hidden="true"></i>
									</div>
									' . ( isset( $input_error_messages['name'] ) ? '<span class="sui-error-message">' . esc_html( $input_error_messages['name'] ) . '</span>' : '' ) . '
								</div>
								<div class="sui-form-field ' . ( isset( $input_error_messages['webhook_url'] ) ? 'sui-form-field-error' : '' ) . '">
									<label class="sui-label">' . esc_html__( 'Webhook URL', 'forminator' ) . '</label>
									<div class="sui-control-with-icon">
										<input
										type="text"
										name="webhook_url"
										placeholder="' . esc_attr__( 'Enter your webhook URL', 'forminator' ) . '"
										value="' . esc_attr( $current_data['webhook_url'] ) . '"
										class="sui-form-control" />
										<i class="sui-icon-link" aria-hidden="true"></i>
									</div>
									' . ( isset( $input_error_messages['webhook_url'] ) ? '<span class="sui-error-message">' . esc_html( $input_error_messages['webhook_url'] ) . '</span>' : '' ) . '
									' . ( forminator_is_show_addons_documentation_link() ?
										'<div class="sui-description">' . sprintf(
											/* translators: 1: article anchor start, 2: article anchor end. */
											esc_html__( 'Check %1$sour documentation%2$s for more information on using webhook URLs for your preferred automation tools.', 'forminator' ),
											'<a href="https://wpmudev.com/docs/wpmu-dev-plugins/forminator/#webhook" target="_blank">',
											'</a>'
										) . '</div>' : '' ) .
									'</div>
								<input type="hidden" name="multi_id" value="' . esc_attr( $multi_id ) . '" />
							</form>',
			'redirect'     => false,
			'is_close'     => ( $is_submit && empty( $error_message ) && empty( $input_error_messages ) ),
			'buttons'      => $buttons,
			'has_errors'   => ( ! empty( $error_message ) || ! empty( $input_error_messages ) ),
			'notification' => $notification,
		);

	}

	/**
	 * Sending test sample towebhook URL
	 * Data sent will be used onwebhook to map fields on their zap action
	 *
	 *
	 *
	 * @param                                                 $submitted_data
	 * @param Forminator_Addon_Webhook_Form_Settings_Exception $current_input_exception
	 *
	 * @throws Forminator_Addon_Webhook_Form_Settings_Exception
	 * @throws Forminator_Addon_Webhook_Wp_Api_Not_Found_Exception
	 * @throws Forminator_Addon_Webhook_Wp_Api_Exception
	 */
	private function validate_and_send_sample( $submitted_data, Forminator_Addon_Webhook_Form_Settings_Exception $current_input_exception ) {
		$form_id = $this->form_id;
		if ( ! isset( $submitted_data['webhook_url'] ) ) {
			$current_input_exception->add_input_exception( esc_html__( 'Please put a valid Webhook URL.', 'forminator' ), 'webhook_url' );
			throw $current_input_exception;
		}

		// must not be in silent mode.
		if ( stripos( $submitted_data['webhook_url'], 'silent' ) !== false ) {
			$current_input_exception->add_input_exception( esc_html__( 'Please disable Silent Mode on Webhook URL.', 'forminator' ), 'webhook_url' );
			throw $current_input_exception;
		}

		$endpoint = wp_http_validate_url( $submitted_data['webhook_url'] );
		if ( false === $endpoint ) {
			$current_input_exception->add_input_exception( esc_html__( 'Please put a valid Webhook URL.', 'forminator' ), 'webhook_url' );
			throw $current_input_exception;
		}

		if ( $current_input_exception->input_exceptions_is_available() ) {
			throw $current_input_exception;
		}

		$connection_settings = $submitted_data;
		/**
		 * Filter Endpoint Webhook URL to send
		 *
		 * @since 1.1
		 *
		 * @param string $endpoint
		 * @param int    $form_id             current Form ID.
		 * @param array  $connection_settings Submitted data by user, it contains `name` and `webhook_url`.
		 */
		$endpoint = apply_filters_deprecated(
			'forminator_addon_zapier_endpoint',
			array( $endpoint, $form_id, $connection_settings ),
			'1.18.0',
			'forminator_addon_webhook_endpoint'
		);
		$endpoint = apply_filters(
			'forminator_addon_webhook_endpoint',
			$endpoint,
			$form_id,
			$connection_settings
		);

		forminator_addon_maybe_log( __METHOD__, $endpoint );
		$api = $this->addon->get_api( $endpoint );

		// build form sample data.
		$sample_data            = $this->build_form_sample_data();
		$sample_data            = self::replace_dashes_in_keys( $sample_data, $endpoint );
		$sample_data['is_test'] = true;

		/**
		 * Filter sample data to send to Webhook URL
		 *
		 * It fires when user saved Webhook connection on Form Settings Page.
		 * Sample data contains `is_test` key with value `true`,
		 * this key indicating that it wont process trigger on Webhook.
		 *
		 * @since 1.1
		 *
		 * @param array $sample_data
		 * @param int   $form_id        current Form ID.
		 * @param array $submitted_data Submitted data by user, it contains `name` and `webhook_url`.
		 */
		$sample_data = apply_filters_deprecated(
			'forminator_addon_zapier_sample_data',
			array( $sample_data, $form_id, $submitted_data ),
			'1.18.0',
			'forminator_addon_webhook_sample_data'
		);
		$sample_data = apply_filters(
			'forminator_addon_webhook_sample_data',
			$sample_data,
			$form_id,
			$submitted_data
		);

		$api->post_( $sample_data );
	}

	/**
	 * Build seample data form current fields
	 *
	 *
	 *
	 * @return array
	 */
	private function build_form_sample_data() {
		$form_fields = $this->form_fields;

		$sample_data = array();
		foreach ( $form_fields as $form_field ) {
			$sample_data[ $form_field['element_id'] ] = $form_field['field_label'];

			if ( 'upload' === $form_field['type'] ) {

				$sample_file_path = '/fake/path';
				$upload_dir       = wp_get_upload_dir();
				if ( isset( $upload_dir['basedir'] ) ) {
					$sample_file_path = $upload_dir['basedir'];
				}

				$sample_data[ $form_field['element_id'] ] = array(
					'name'      => $form_field['field_label'],
					'type'      => 'image/png',
					'size'      => 0,
					'file_url'  => get_home_url(),
					'file_path' => $sample_file_path,
				);
			}
		}

		//send form title, date
		$sample_data['form-title'] = $this->form_settings['formName'];
		$sample_data['entry-time'] = current_time( 'Y-m-d H:i:s' );

		return $sample_data;
	}

	/**
	 * Check if setup webhook url is completed
	 *
	 *
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function setup_webhook_url_is_completed( $submitted_data ) {

		$multi_id = '';
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		if ( empty( $multi_id ) ) {
			return false;
		}

		$name = $this->get_multi_id_form_settings_value( $multi_id, 'name', '' );
		$name = trim( $name );
		if ( empty( $name ) ) {
			return false;
		}
		$webhook_url = $this->get_multi_id_form_settings_value( $multi_id, 'webhook_url', '' );
		$webhook_url = trim( $webhook_url );
		if ( empty( $webhook_url ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Find one active connection on current form
	 *
	 *
	 *
	 * @return bool|array false on no connection, or settings on available
	 */
	public function find_one_active_connection() {
		$addon_form_settings = $this->get_form_settings_values();

		// backward compat old version.
		if ( isset( $addon_form_settings['webhook_url'] ) ) {
			// convert to multi id type.
			$new_id                      = $this->generate_multi_id();
			$addon_form_settings['name'] = $new_id;
			$this->save_form_settings_values( array( $new_id => $addon_form_settings ) );

			return $this->find_one_active_connection();
		}

		foreach ( $addon_form_settings as $multi_id => $addon_form_setting ) {
			if ( true === $this->setup_webhook_url_is_completed( array( 'multi_id' => $multi_id ) ) ) {
				return $addon_form_setting;
			}
		}

		return false;
	}

	/**
	 * Generate multi id for multiple connection
	 *
	 *
	 * @since 1.2 change method to non static
	 * @return string
	 */
	public function generate_multi_id() {
		return uniqid( 'webhook_', true );
	}


	/**
	 * Override how multi connection displayed
	 *
	 *
	 * @return array
	 */
	public function get_multi_ids() {
		$multi_ids = array();
		foreach ( $this->get_form_settings_values() as $key => $value ) {
			$multi_ids[] = array(
				'id'    => $key,
				// use name that was added by user on creating connection.
				'label' => isset( $value['name'] ) ? $value['name'] : $key,
			);
		}

		return $multi_ids;
	}

	/**
	 * Disconnect a connection from current form
	 *
	 *
	 *
	 * @param array $submitted_data
	 */
	public function disconnect_form( $submitted_data ) {
		// only execute if multi_id provided on submitted data.
		if ( isset( $submitted_data['multi_id'] ) && ! empty( $submitted_data['multi_id'] ) ) {
			$addon_form_settings = $this->get_form_settings_values();
			unset( $addon_form_settings[ $submitted_data['multi_id'] ] );
			$this->save_form_settings_values( $addon_form_settings );
		}
	}

	/**
	 * Check if multi_id form settings values completed
	 *
	 * @param int $multi_id ID.
	 * @return bool
	 */
	public function is_multi_form_settings_complete( $multi_id ) {
		$data = array( 'multi_id' => $multi_id );

		if ( ! $this->setup_webhook_url_is_completed( $data ) ) {
			return false;
		}

		return true;
	}
}