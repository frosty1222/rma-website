<?php

require_once dirname( __FILE__ ) . '/class-forminator-addon-campaignmonitor-quiz-settings-exception.php';

/**
 * Class Forminator_Addon_Campaignmonitor_Quiz_Settings
 * Handle how quiz settings displayed and saved
 *
 * @since 1.0 Campaignmonitor Addon
 */
class Forminator_Addon_Campaignmonitor_Quiz_Settings extends Forminator_Addon_Quiz_Settings_Abstract {

	/**
	 * @var Forminator_Addon_Campaignmonitor
	 * @since 1.0 Campaignmonitor Addon
	 */
	protected $addon;

	/**
	 * Forminator_Addon_Campaignmonitor_Quiz_Settings constructor.
	 *
	 * @since 1.0 Campaignmonitor Addon
	 *
	 * @param Forminator_Addon_Abstract $addon
	 * @param                           $quiz_id
	 *
	 * @throws Forminator_Addon_Exception
	 */
	public function __construct( Forminator_Addon_Abstract $addon, $quiz_id ) {
		parent::__construct( $addon, $quiz_id );

		$this->_update_quiz_settings_error_message = esc_html__(
			'The update to your settings for this quiz failed, check the quiz input and try again.',
			'forminator'
		);
	}

	/**
	 * Campaignmonitor Quiz Settings wizard
	 *
	 * @since 1.0 Campaignmonitor Addon
	 * @return array
	 */
	public function quiz_settings_wizards() {
		// numerical array steps.
		return array(
			array(
				'callback'     => array( $this, 'pick_name' ),
				'is_completed' => array( $this, 'pick_name_is_completed' ),
			),
			array(
				'callback'     => array( $this, 'setup_list' ),
				'is_completed' => array( $this, 'setup_list_is_completed' ),
			),
			array(
				'callback'     => array( $this, 'map_fields' ),
				'is_completed' => array( $this, 'map_fields_is_completed' ),
			),
			array(
				'callback'     => array( $this, 'setup_options' ),
				'is_completed' => array( $this, 'setup_options_is_completed' ),
			),
		);
	}

	/**
	 * Setup Connection Name
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 */
	public function pick_name( $submitted_data ) {
		$template = forminator_addon_campaignmonitor_dir() . 'views/quiz-settings/pick-name.php';

		$multi_id = $this->generate_multi_id();
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		$template_params = array(
			'name'       => $this->get_multi_id_quiz_settings_value( $multi_id, 'name', '' ),
			'name_error' => '',
			'multi_id'   => $multi_id,
		);

		unset( $submitted_data['multi_id'] );

		$is_submit  = ! empty( $submitted_data );
		$has_errors = false;
		if ( $is_submit ) {
			$name                    = isset( $submitted_data['name'] ) ? $submitted_data['name'] : '';
			$template_params['name'] = $name;

			try {

				if ( empty( $name ) ) {
					throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'Please pick valid name', 'forminator' ) );
				}

				$time_added = $this->get_multi_id_quiz_settings_value( $multi_id, 'time_added', time() );
				$this->save_multi_id_quiz_setting_values(
					$multi_id,
					array(
						'name'       => $name,
						'time_added' => $time_added,
					)
				);

			} catch ( Forminator_Addon_Campaignmonitor_Exception $e ) {
				$template_params['name_error'] = $e->getMessage();
				$has_errors                    = true;
			}
		}

		$buttons = array();
		if ( $this->pick_name_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this Campaign Monitor Integration from this Quiz.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
		                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Next', 'forminator' ), 'forminator-addon-next' ) .
		                             '</div>';

		return array(
			'html'       => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'    => $buttons,
			'redirect'   => false,
			'has_errors' => $has_errors,
		);
	}

	/**
	 * Check if pick name step completed
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function pick_name_is_completed( $submitted_data ) {
		$multi_id = '';
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		if ( empty( $multi_id ) ) {
			return false;
		}

		$name = $this->get_multi_id_quiz_settings_value( $multi_id, 'name', '' );

		if ( empty( $name ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Setup List
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 */
	public function setup_list( $submitted_data ) {
		$template = forminator_addon_campaignmonitor_dir() . 'views/quiz-settings/setup-list.php';

		if ( ! isset( $submitted_data['multi_id'] ) ) {
			return $this->get_force_closed_wizard( esc_html__( 'Please pick valid connection', 'forminator' ) );
		}

		$multi_id = $submitted_data['multi_id'];
		unset( $submitted_data['multi_id'] );

		$template_params = array(
			'list_id'       => $this->get_multi_id_quiz_settings_value( $multi_id, 'list_id', '' ),
			'list_name'     => $this->get_multi_id_quiz_settings_value( $multi_id, 'list_name', '' ),
			'list_id_error' => '',
			'multi_id'      => $multi_id,
			'error_message' => '',
		);

		$is_submit  = ! empty( $submitted_data );
		$has_errors = false;

		$lists = array();

		try {

			$api           = $this->addon->get_api();
			$lists_request = $api->get_client_lists( $this->addon->get_client_id() );

			foreach ( $lists_request as $key => $data ) {
				if ( isset( $data->ListID ) && isset( $data->Name ) ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar
					$lists[ $data->ListID ] = $data->Name; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar
				}
			}

			if ( empty( $lists ) ) {
				throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'No lists found on your Campaign Monitor. Please create one.', 'forminator' ) );
			}

			$template_params['lists'] = $lists;

		} catch ( Forminator_Addon_Campaignmonitor_Exception $e ) {
			$template_params['error_message'] = $e->getMessage();
			$has_errors                       = true;
		}

		if ( $is_submit ) {
			$list_id                    = isset( $submitted_data['list_id'] ) ? $submitted_data['list_id'] : '';
			$template_params['list_id'] = $list_id;

			try {

				if ( empty( $list_id ) ) {
					throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'Please pick valid list', 'forminator' ) );
				}

				// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
				if ( ! in_array( $list_id, array_keys( $lists ) ) ) {
					throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'Please pick valid list', 'forminator' ) );
				}

				$list_name = $lists[ $list_id ];

				$this->save_multi_id_quiz_setting_values(
					$multi_id,
					array(
						'list_id'   => $list_id,
						'list_name' => $list_name,
					)
				);

			} catch ( Forminator_Addon_Campaignmonitor_Exception $e ) {
				$template_params['list_id_error'] = $e->getMessage();
				$has_errors                       = true;
			}
		}

		$buttons = array();
		if ( $this->pick_name_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this Campaign Monitor Integration from this Quiz.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
		                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Next', 'forminator' ), 'forminator-addon-next' ) .
		                             '</div>';

		return array(
			'html'       => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'    => $buttons,
			'redirect'   => false,
			'has_errors' => $has_errors,
			'has_back'   => true,
		);
	}

	/**
	 * Check if setup list completed
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function setup_list_is_completed( $submitted_data ) {
		$multi_id = '';
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		if ( empty( $multi_id ) ) {
			return false;
		}

		$list_id = $this->get_multi_id_quiz_settings_value( $multi_id, 'list_id', '' );

		if ( empty( $list_id ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Setup fields map
	 *
	 * @since 1.0 Campaignmonitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 */
	public function map_fields( $submitted_data ) {
		$template = forminator_addon_campaignmonitor_dir() . 'views/quiz-settings/map-fields.php';

		if ( ! isset( $submitted_data['multi_id'] ) ) {
			return $this->get_force_closed_wizard( esc_html__( 'Please pick valid connection', 'forminator' ) );
		}

		$multi_id = $submitted_data['multi_id'];
		unset( $submitted_data['multi_id'] );

		// find type of email.
		$email_fields                 = array();
		$forminator_field_element_ids = array();
		$forminator_quiz_element_ids  = array();
		foreach ( $this->form_fields as $form_field ) {
			// collect element ids.
			$forminator_field_element_ids[] = $form_field['element_id'];
			if ( 'email' === $form_field['type'] ) {
				$email_fields[] = $form_field;
			}
		}

		$quiz_questions = $this->get_quiz_fields();
		$quiz_fields    = array(
			'quiz-name' => esc_html__( 'Quiz Name', 'forminator' ),
		);
		foreach ( $quiz_questions as $quiz_question ) {
			// collect element ids.
			$forminator_quiz_element_ids[]         = $quiz_question['slug'];
			$quiz_fields[ $quiz_question['slug'] ] = $quiz_question['title'];
		}
		if ( 'knowledge' === $this->quiz->quiz_type ) {
			$quiz_fields['correct-answers'] = esc_html__( 'Correct Answers', 'forminator' );
			$quiz_fields['total-answers']   = esc_html__( 'Total Answers', 'forminator' );
			array_push( $forminator_quiz_element_ids, 'quiz-name', 'correct-answers', 'total-answers' );
		} elseif ( 'nowrong' === $this->quiz->quiz_type ) {
			$quiz_fields['result-answers'] = esc_html__( 'Result Answer', 'forminator' );
			array_push( $forminator_quiz_element_ids, 'quiz-name', 'result-answers' );
		}

		$forminator_field_element_ids = array_merge( $forminator_field_element_ids, $forminator_quiz_element_ids );

		$template_params = array(
			'fields_map'    => $this->get_multi_id_quiz_settings_value( $multi_id, 'fields_map', array() ),
			'multi_id'      => $multi_id,
			'error_message' => '',
			'fields'        => array(),
			'form_fields'   => $this->form_fields,
			'quiz_fields'   => $quiz_fields,
			'email_fields'  => $email_fields,
		);

		$is_submit  = ! empty( $submitted_data );
		$has_errors = false;

		$fields = array(
			'default_field_email' => esc_html__( 'Email Address', 'forminator' ),
			'default_field_name'  => esc_html__( 'Name', 'forminator' ),
		);

		$list_id = $this->get_multi_id_quiz_settings_value( $multi_id, 'list_id', 0 );

		try {

			$api                = $this->addon->get_api();
			$list_custom_fields = $api->get_list_custom_field( $list_id );

			if ( ! is_array( $list_custom_fields ) ) {
				throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'Campaign Monitor list\'s custom fields could not be found', 'forminator' ) );
			}

			foreach ( $list_custom_fields as $field ) {
				$field_key = $field->Key; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar
				if ( stripos( $field_key, '[' ) === 0 ) {
					$field_key = substr( $field_key, 1 );
				}
				if ( strripos( $field_key, ']' ) === ( strlen( $field_key ) - 1 ) ) {
					$field_key = substr( $field_key, 0, strlen( $field_key ) - 1 );
				}
				$fields[ $field_key ] = $field->FieldName; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar
			}

			$template_params['fields'] = $fields;

		} catch ( Forminator_Addon_Campaignmonitor_Exception $e ) {
			$template_params['error_message'] = $e->getMessage();
			$has_errors                       = true;
		}

		if ( $is_submit ) {
			$fields_map                    = isset( $submitted_data['fields_map'] ) ? $submitted_data['fields_map'] : array();
			$template_params['fields_map'] = $fields_map;

			try {
				if ( empty( $fields_map ) ) {
					throw new Forminator_Addon_Campaignmonitor_Exception( esc_html__( 'Please assign fields.', 'forminator' ) );
				}

				$input_exceptions = new Forminator_Addon_Campaignmonitor_Quiz_Settings_Exception();
				if ( ! isset( $fields_map['default_field_email'] ) || empty( $fields_map['default_field_email'] ) ) {
					$input_exceptions->add_input_exception( 'Please assign field for Email Address', 'default_field_email_error' );
				}

				if ( ! isset( $fields_map['default_field_name'] ) || empty( $fields_map['default_field_name'] ) ) {
					$input_exceptions->add_input_exception( 'Please assign field for Name', 'default_field_name_error' );
				}

				$fields_map_to_save = array();
				foreach ( $fields as $key => $title ) {
					if ( isset( $fields_map[ $key ] ) && ! empty( $fields_map[ $key ] ) ) {
						$element_id = $fields_map[ $key ];
						if ( ! in_array( $element_id, $forminator_field_element_ids, true ) ) {
							$input_exceptions->add_input_exception( sprintf(
							/* translators: %s: Field Title */
								esc_html__( 'Please assign valid field for %s', 'forminator' ), esc_html( $title ) ),
								$key . '_error'
							);
							continue;
						}

						$fields_map_to_save[ $key ] = $fields_map[ $key ];
					}
				}

				if ( $input_exceptions->input_exceptions_is_available() ) {
					throw $input_exceptions;
				}

				$this->save_multi_id_quiz_setting_values( $multi_id, array( 'fields_map' => $fields_map ) );

			} catch ( Forminator_Addon_Campaignmonitor_Quiz_Settings_Exception $e ) {
				$template_params = array_merge( $template_params, $e->get_input_exceptions() );
				$has_errors      = true;
			} catch ( Forminator_Addon_Campaignmonitor_Exception $e ) {
				$template_params['error_message'] = $e->getMessage();
				$has_errors                       = true;
			}
		}

		$buttons = array();
		if ( $this->pick_name_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this Campaign Monitor Integration from this Quiz.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
		                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Next', 'forminator' ), 'forminator-addon-next' ) .
		                             '</div>';

		return array(
			'html'       => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'    => $buttons,
			'size'       => 'normal',
			'redirect'   => false,
			'has_errors' => $has_errors,
			'has_back'   => true,
		);
	}

	/**
	 * Check if fields mapped
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function map_fields_is_completed( $submitted_data ) {
		$multi_id = '';
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		if ( empty( $multi_id ) ) {
			return false;
		}

		$fields_map = $this->get_multi_id_quiz_settings_value( $multi_id, 'fields_map', array() );

		if ( empty( $fields_map ) || ! is_array( $fields_map ) || count( $fields_map ) < 1 ) {
			return false;
		}

		if ( ! isset( $fields_map['default_field_email'] ) || empty( $fields_map['default_field_email'] ) ) {
			return false;
		}

		if ( ! isset( $fields_map['default_field_name'] ) || empty( $fields_map['default_field_name'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Setup options
	 *
	 * Contains :
	 * - Resubscribe
	 * - RestartSubscriptionBasedAutoresponders
	 * - ConsentToTrack
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 */
	public function setup_options( $submitted_data ) {
		$template = forminator_addon_campaignmonitor_dir() . 'views/quiz-settings/setup-options.php';

		if ( ! isset( $submitted_data['multi_id'] ) ) {
			return $this->get_force_closed_wizard( esc_html__( 'Please pick valid connection', 'forminator' ) );
		}

		$multi_id = $submitted_data['multi_id'];
		unset( $submitted_data['multi_id'] );

		$forminator_form_element_ids = array();
		foreach ( $this->form_fields as $field ) {
			$forminator_form_element_ids[ $field['element_id'] ] = $field;
		}

		$template_params = array(
			'multi_id'                                  => $multi_id,
			'error_message'                             => '',
			'resubscribe'                               => $this->get_multi_id_quiz_settings_value( $multi_id, 'resubscribe', false ),
			'restart_subscription_based_autoresponders' => $this->get_multi_id_quiz_settings_value( $multi_id, 'restart_subscription_based_autoresponders', false ),
			'consent_to_track'                          => $this->get_multi_id_quiz_settings_value( $multi_id, 'consent_to_track', 'Unchanged' ),
		);

		$is_submit    = ! empty( $submitted_data );
		$has_errors   = false;
		$notification = array();
		$is_close     = false;

		if ( $is_submit ) {
			$resubscribe                               = isset( $submitted_data['resubscribe'] ) ? (int) $submitted_data['resubscribe'] : 0;
			$restart_subscription_based_autoresponders = isset( $submitted_data['restart_subscription_based_autoresponders'] ) ? (int) $submitted_data['restart_subscription_based_autoresponders'] : 0;
			$consent_to_track                          = isset( $submitted_data['consent_to_track'] ) ? $submitted_data['consent_to_track'] : 'Unchanged';

			try {
				$input_exceptions = new Forminator_Addon_Campaignmonitor_Quiz_Settings_Exception();

				$available_consents = array(
					'Yes',
					'No',
					'Unchanged',
				);

				if ( ! in_array( $consent_to_track, $available_consents, true ) ) {
					$input_exceptions->add_input_exception( esc_html__( 'Please pick valid Consent To Track options', 'forminator' ), 'consent_to_track_error' );
				}

				if ( $input_exceptions->input_exceptions_is_available() ) {
					throw $input_exceptions;
				}

				$this->save_multi_id_quiz_setting_values(
					$multi_id,
					array(
						'resubscribe'      => (bool) $resubscribe,
						'restart_subscription_based_autoresponders' => (bool) $restart_subscription_based_autoresponders,
						'consent_to_track' => $consent_to_track,
					)
				);

				$notification = array(
					'type' => 'success',
					'text' => '<strong>' . $this->addon->get_title() . '</strong> ' . esc_html__( 'Successfully connected to your quiz', 'forminator' ),
				);
				$is_close     = true;

			} catch ( Forminator_Addon_Campaignmonitor_Quiz_Settings_Exception $e ) {
				$template_params = array_merge( $template_params, $e->get_input_exceptions() );
				$has_errors      = true;
			} catch ( Forminator_Addon_Campaignmonitor_Quiz_Settings_Exception $e ) {
				$template_params['error_message'] = $e->getMessage();
				$has_errors                       = true;
			}
		}

		$buttons = array();
		if ( $this->pick_name_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this Campaign Monitor Integration from this Quiz.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
		                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Save', 'forminator' ), 'sui-button-primary forminator-addon-finish' ) .
		                             '</div>';

		return array(
			'html'         => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'      => $buttons,
			'size'         => 'normal',
			'redirect'     => false,
			'has_errors'   => $has_errors,
			'has_back'     => true,
			'notification' => $notification,
			'is_close'     => $is_close,
		);
	}

	/**
	 * Check if setup options completed
	 *
	 * @since 1.0 Campaign Monitor Addon
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function setup_options_is_completed( $submitted_data ) {
		// all settings here are optional, so it can be marked as completed.
		return true;
	}

	/**
	 * Check if multi_id quiz settings values completed
	 *
	 * @since 1.0 Campaign Monitor Added
	 *
	 * @param $multi_id
	 *
	 * @return bool
	 */
	public function is_multi_quiz_settings_complete( $multi_id ) {
		$data = array( 'multi_id' => $multi_id );

		if ( ! $this->pick_name_is_completed( $data ) ) {
			return false;
		}
		if ( ! $this->setup_list_is_completed( $data ) ) {
			return false;
		}

		if ( ! $this->map_fields_is_completed( $data ) ) {
			return false;
		}

		if ( ! $this->setup_options_is_completed( $data ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Generate multi id for multiple connection
	 *
	 * @since 1.0 Campaignmonitor Addon
	 * @return string
	 */
	public function generate_multi_id() {
		return uniqid( 'campaignmonitor_', true );
	}


	/**
	 * Override how multi connection displayed
	 *
	 * @since 1.0 Campaignmonitor Addon
	 * @return array
	 */
	public function get_multi_ids() {
		$multi_ids = array();
		foreach ( $this->get_quiz_settings_values() as $key => $value ) {
			$multi_ids[] = array(
				'id'    => $key,
				// use name that was added by user on creating connection.
				'label' => isset( $value['name'] ) ? $value['name'] : $key,
			);
		}

		return $multi_ids;
	}

	/**
	 * Disconnect a connection from current quiz
	 *
	 * @since 1.0 Campaignmonitor Addon
	 *
	 * @param array $submitted_data
	 */
	public function disconnect_form( $submitted_data ) {
		// only execute if multi_id provided on submitted data.
		if ( isset( $submitted_data['multi_id'] ) && ! empty( $submitted_data['multi_id'] ) ) {
			$addon_form_settings = $this->get_quiz_settings_values();
			unset( $addon_form_settings[ $submitted_data['multi_id'] ] );
			$this->save_quiz_settings_values( $addon_form_settings );
		}
	}
}