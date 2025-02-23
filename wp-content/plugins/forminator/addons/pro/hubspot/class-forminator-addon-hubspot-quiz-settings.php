<?php

require_once dirname( __FILE__ ) . '/class-forminator-addon-hubspot-quiz-settings-exception.php';

/**
 * Class Forminator_Addon_Hubspot_Quiz_Settings
 * Handle how quiz settings displayed and saved
 *
 * @since 1.0 HubSpot Addon
 */
class Forminator_Addon_Hubspot_Quiz_Settings extends Forminator_Addon_Quiz_Settings_Abstract {

	/**
	 * @var Forminator_Addon_Hubspot
	 * @since 1.0 HubSpot Addon
	 */
	protected $addon;

	public $target_types = array();

	/**
	 * Forminator_Addon_Hubspot_Quiz_Settings constructor.
	 *
	 * @since 1.0 HubSpot Addon
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
	 * HubSpot quiz Settings wizard
	 *
	 * @since 1.0 HubSpot Addon
	 * @return array
	 */
	public function quiz_settings_wizards() {
		// numerical array steps.
		return array(
			array(
				'callback'     => array( $this, 'map_fields' ),
				'is_completed' => array( $this, 'map_fields_is_completed' ),
			),
			array(
				'callback'     => array( $this, 'create_ticket' ),
				'is_completed' => array( $this, 'create_ticket_is_completed' ),
			),
		);
	}


	/**
	 * Setup Connection Name
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 * @throws Forminator_Addon_Hubspot_Exception
	 * @throws Forminator_Addon_Hubspot_Wp_Api_Exception
	 * @throws Forminator_Addon_Hubspot_Wp_Api_Not_Found_Exception
	 */
	public function map_fields( $submitted_data ) {
		$template = forminator_addon_hubspot_dir() . 'views/quiz-settings/create-contact.php';

		$multi_id = $this->generate_multi_id();
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		$lists                        = array();
		$property                     = array();
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
			'fields_map'        => $this->get_multi_id_quiz_settings_value( $multi_id, 'fields_map', array() ),
			'error_message'     => '',
			'multi_id'          => $multi_id,
			'fields'            => array(),
			'form_fields'       => $this->form_fields,
			'quiz_fields'       => $quiz_fields,
			'email_fields'      => $email_fields,
			'list_id'           => $this->get_multi_id_quiz_settings_value( $multi_id, 'list_id', '' ),
			'list_name'         => $this->get_multi_id_quiz_settings_value( $multi_id, 'list_name', '' ),
			'custom_fields_map' => $this->get_multi_id_quiz_settings_value( $multi_id, 'custom_fields_map', array() ),
		);

		unset( $submitted_data['multi_id'] );

		$fields                    = array(
			'email'     => esc_html__( 'Email Address', 'forminator' ),
			'firstname' => esc_html__( 'First Name', 'forminator' ),
			'lastname'  => esc_html__( 'Last Name', 'forminator' ),
			'jobtitle'  => esc_html__( 'Job Title', 'forminator' ),
		);
		$template_params['fields'] = $fields;
		try {
			$api           = $this->addon->get_api();
			$lists_request = $api->get_contact_list();
			$lists_property = $api->get_properties();

			if ( ! empty( $lists_request->lists ) ) {
				foreach ( $lists_request->lists as $key => $data ) {
					if ( isset( $data->listId ) && isset( $data->name ) ) {
						$lists[ $data->listId ] = $data->name;
					}
				}
			}
			if ( ! empty( $lists_property ) ) {
				foreach ( $lists_property as $key => $data ) {
					if ( isset( $data->name ) ) {
						$property[ $data->name ] = $data->label;
					}
				}
			}
		} catch ( Forminator_Addon_Hubspot_Quiz_Settings_Exception $e ) {
			$template_params['error_message'] = $e->getMessage();
			$has_errors                       = true;
		}

		$template_params['lists'] = $lists;
		$template_params['properties'] = $property;
		$is_submit                = ! empty( $submitted_data );
		$has_errors               = false;
		if ( $is_submit ) {
			$custom_property               = isset( $submitted_data['custom_property'] ) ? $submitted_data['custom_property'] : array();
			$custom_field                  = isset( $submitted_data['custom_field'] ) ? $submitted_data['custom_field'] : array();
			$custom_field_map              = array_combine( $custom_property, $custom_field );
			$fields_map                    = isset( $submitted_data['fields_map'] ) ? $submitted_data['fields_map'] : array();
			$template_params['fields_map'] = $fields_map;
			$template_params['custom_fields_map'] = $custom_field_map;

			try {
				$input_exceptions = new Forminator_Addon_Hubspot_Quiz_Settings_Exception();
				if ( ! isset( $fields_map['email'] ) || empty( $fields_map['email'] ) ) {
					$input_exceptions->add_input_exception( 'Please assign field for Email Address', 'email_error' );
				}
				$fields_map_to_save = array();
				foreach ( $fields as $key => $title ) {
					if ( isset( $fields_map[ $key ] ) && ! empty( $fields_map[ $key ] ) ) {
						$element_id = $fields_map[ $key ];
						if ( ! in_array( $element_id, $forminator_field_element_ids, true ) ) {
							$input_exceptions->add_input_exception( sprintf(
							/* translators: %s: Field title */
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

				$list_id = isset( $submitted_data['list_id'] ) ? $submitted_data['list_id'] : '';

				$list_name = isset( $lists[ $list_id ] ) ? $lists[ $list_id ] : '';

				$this->save_multi_id_quiz_setting_values(
					$multi_id,
					array(
						'fields_map'        => $fields_map,
						'custom_fields_map' => $custom_field_map,
						'list_id'           => $list_id,
						'list_name'         => $list_name,
					)
				);

			} catch ( Forminator_Addon_Hubspot_Quiz_Settings_Exception $e ) {
				$template_params = array_merge( $template_params, $e->get_input_exceptions() );
				$has_errors      = true;
			} catch ( Forminator_Addon_Hubspot_Exception $e ) {
				$template_params['error_message'] = $e->getMessage();
				$has_errors                       = true;
			}
		}

		$buttons = array();

		if ( $this->map_fields_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this HubSpot Integration from this Form.', 'forminator' )
			);
		}

		$buttons['next']['markup'] = '<div class="sui-actions-right">' .
		                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Continue', 'forminator' ), 'forminator-addon-next' ) .
		                             '</div>';

		return array(
			'html'       => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'    => $buttons,
			'size'       => 'normal',
			'redirect'   => false,
			'has_errors' => $has_errors,
		);
	}

	/**
	 * Check if pick name step completed
	 *
	 * @since 1.0 HubSpot Addon
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

		if ( ! isset( $fields_map['email'] ) || empty( $fields_map['email'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Setup Create ticket
	 *
	 * @param $submitted_data
	 *
	 * @return array
	 * @throws Forminator_Addon_Aweber_Exception
	 */
	public function create_ticket( $submitted_data ) {
		$template = forminator_addon_hubspot_dir() . 'views/quiz-settings/create-ticket.php';

		if ( ! isset( $submitted_data['multi_id'] ) ) {
			return $this->get_force_closed_wizard( esc_html__( 'Please pick valid connection', 'forminator' ) );
		}

		$multi_id = $submitted_data['multi_id'];

		$is_poll                      = false;
		$file_fields                  = array();
		$forminator_field_element_ids = array();
		foreach ( $this->form_fields as $form_field ) {
			// collect element ids.
			$forminator_field_element_ids[] = $form_field['element_id'];
			if ( 'upload' === $form_field['type'] ) {
				$file_fields[] = $form_field;
			}
		}

		$template_params = array(
			'form_fields'        => $this->form_fields,
			'file_fields'        => $file_fields,
			'create_ticket'      => $this->get_multi_id_quiz_settings_value( $multi_id, 'create_ticket', '' ),
			'pipeline_id'        => $this->get_multi_id_quiz_settings_value( $multi_id, 'pipeline_id', '' ),
			'pipeline_name'      => $this->get_multi_id_quiz_settings_value( $multi_id, 'pipeline_name', '' ),
			'status_id'          => $this->get_multi_id_quiz_settings_value( $multi_id, 'status_id', '' ),
			'status_name'        => $this->get_multi_id_quiz_settings_value( $multi_id, 'status_name', '' ),
			'ticket_name'        => $this->get_multi_id_quiz_settings_value( $multi_id, 'ticket_name', '' ),
			'ticket_description' => $this->get_multi_id_quiz_settings_value( $multi_id, 'ticket_description', '' ),
			'supported_file'     => $this->get_multi_id_quiz_settings_value( $multi_id, 'supported_file', '' ),
			'list_id_error'      => '',
			'multi_id'           => $multi_id,
			'error_message'      => '',
			'auth_url'           => $this->addon->get_auth_url(),
		);

		$settings = $this->addon->get_settings_values();
		if ( ! empty( $settings['token'] ) ) {
			$template_params['token'] = $settings['token'];
		}

		$buttonID = 'ticket-activate';
		if ( ! empty( $settings['re-authorize'] ) ) {
			$template_params['re-authorize'] = $settings['re-authorize'];
			$buttonID                        = 'ticket-activated';
		}

		if ( ( isset( $submitted_data['create_ticket'] ) && '1' === $submitted_data['create_ticket'] ) && empty( $settings['re-authorize'] ) ) {
			$is_poll = true;
		}

		unset( $submitted_data['multi_id'] );

		$is_submit    = ! empty( $submitted_data );
		$has_errors   = false;
		$notification = array();
		$is_close     = false;

		$pipeline = array();
		$status   = array();

		try {

			$api              = $this->addon->get_api();
			$pipeline_request = $api->get_pipeline();
			if ( ! empty( $submitted_data['pipeline_id'] ) ) {
				$pipelineId = $submitted_data['pipeline_id'];
			} else {
				$pipelineId = $this->get_multi_id_quiz_settings_value( $multi_id, 'pipeline_id', 0 );
			}
			if ( ! empty( $pipeline_request->results ) ) {
				$default_status = reset( $pipeline_request->results );
				foreach ( $pipeline_request->results as $key => $data ) {
					if ( isset( $data->pipelineId ) ) {
						$pipeline[ $data->pipelineId ] = $data->label;
						if ( $pipelineId === $data->pipelineId ) {
							$pipeline_status = $data->stages;
						} else {
							$pipeline_status = $default_status->stages;
						}
						if ( ! empty( $pipeline_status ) ) {
							foreach ( $pipeline_status as $s => $stat ) {
								if ( isset( $stat->stageId ) ) {
									$status[ $stat->stageId ] = $stat->label;
								}
							}
						}
					}
				}
			}
			if ( empty( $pipeline ) ) {
				throw new Forminator_Addon_Hubspot_Exception( esc_html__( 'No pipeline found on your HubSpot account. Please create one.', 'forminator' ) );
			}

			if ( empty( $status ) ) {
				throw new Forminator_Addon_Hubspot_Exception( esc_html__( 'No status found on your HubSpot account. Please create one.', 'forminator' ) );
			}

			$template_params['status']   = $status;
			$template_params['pipeline'] = $pipeline;

		} catch ( Forminator_Addon_Hubspot_Exception $e ) {
			$template_params['error_message'] = $e->getMessage();
			$has_errors                       = true;
		}

		if ( $is_submit ) {
			$pipeline_id                           = isset( $submitted_data['pipeline_id'] ) ? $submitted_data['pipeline_id'] : null;
			$status_id                             = isset( $submitted_data['status_id'] ) ? $submitted_data['status_id'] : null;
			$ticket_name                           = isset( $submitted_data['ticket_name'] ) ? $submitted_data['ticket_name'] : '';
			$ticket_description                    = isset( $submitted_data['ticket_description'] ) ? $submitted_data['ticket_description'] : '';
			$create_ticket                         = isset( $submitted_data['create_ticket'] ) ? $submitted_data['create_ticket'] : '';
			$supported_file                        = isset( $submitted_data['supported_file'] ) ? $submitted_data['supported_file'] : '';
			$template_params['pipeline_id']        = $pipeline_id;
			$template_params['status_id']          = $status_id;
			$template_params['ticket_name']        = $ticket_name;
			$template_params['ticket_description'] = $ticket_description;
			$template_params['create_ticket']      = $create_ticket;
			$template_params['supported_file']     = $supported_file;
			try {

				$input_exceptions = new Forminator_Addon_Hubspot_Quiz_Settings_Exception();
				if ( '1' === $create_ticket && isset( $submitted_data['pipeline_id'] ) && empty( $submitted_data['pipeline_id'] )
				     && 0 !== (int) $submitted_data['pipeline_id'] ) {
					$input_exceptions->add_input_exception( 'Please select pipeline', 'pipeline_error' );
				}
				if ( '1' === $create_ticket && isset( $submitted_data['status_id'] ) && empty( $submitted_data['status_id'] )
				     && 0 !== (int) $submitted_data['status_id'] ) {
					$input_exceptions->add_input_exception( 'Please select status', 'status_error' );
				}

				if ( '1' === $create_ticket && isset( $submitted_data['ticket_name'] ) && empty( $submitted_data['ticket_name'] ) ) {
					$input_exceptions->add_input_exception( 'Please enter ticket name', 'ticket_name_error' );
				}

				if ( $input_exceptions->input_exceptions_is_available() ) {
					throw $input_exceptions;
				}

				if ( empty( $create_ticket ) || ( '1' === $create_ticket && isset( $submitted_data['ticket_name'] ) ) ) {
					$pipeline_name = $pipeline[ $pipeline_id ];
					$status_name   = $status[ $status_id ];

					$this->save_multi_id_quiz_setting_values(
						$multi_id,
						array(
							'pipeline_id'        => $pipeline_id,
							'pipeline_name'      => $pipeline_name,
							'status_id'          => $status_id,
							'status_name'        => $status_name,
							'ticket_name'        => $ticket_name,
							'ticket_description' => $ticket_description,
							'create_ticket'      => $create_ticket,
							'supported_file'     => $supported_file
						)
					);
					$notification = array(
						'type' => 'success',
						'text' => '<strong>' . $this->addon->get_title() . '</strong> ' . esc_html__( 'is activated successfully.' ),
					);
					$is_close     = true;
				}

			} catch ( Forminator_Addon_Hubspot_Quiz_Settings_Exception $e ) {
				$template_params = array_merge( $template_params, $e->get_input_exceptions() );
				$has_errors      = true;
			} catch ( Forminator_Addon_Hubspot_Exception $e ) {
				$template_params['ticket_error'] = $e->getMessage();
				$has_errors                      = true;
			}
		}

		$buttons = array();
		if ( $this->create_ticket_is_completed( array( 'multi_id' => $multi_id ) ) ) {
			$buttons['disconnect']['markup'] = Forminator_Addon_Abstract::get_button_markup(
				esc_html__( 'Deactivate', 'forminator' ),
				'sui-button-ghost sui-tooltip sui-tooltip-top-center forminator-addon-form-disconnect',
				esc_html__( 'Deactivate this HubSpot Integration from this Form.', 'forminator' )
			);
			$buttons['next']['markup']       = '<div class="sui-actions-right">' .
			                                   Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Update', 'forminator' ), 'forminator-addon-next sui-button-blue' ) .
			                                   '</div>';
		} else if ( ( isset( $submitted_data['create_ticket'] ) && '1' === $submitted_data['create_ticket'] ) && empty( $settings['re-authorize'] ) ) {
			$buttons = array();
		} else {
			$buttons['next']['markup'] = '<div class="sui-actions-right" id="' . $buttonID . '">' .
			                             Forminator_Addon_Abstract::get_button_markup( esc_html__( 'Activate', 'forminator' ), 'forminator-addon-next sui-button-blue' ) .
			                             '</div>';
		}

		return array(
			'html'         => Forminator_Addon_Abstract::get_template( $template, $template_params ),
			'buttons'      => $buttons,
			'size'         => 'reduced',
			'redirect'     => false,
			'has_errors'   => $has_errors,
			'has_back'     => true,
			'notification' => $notification,
			'is_close'     => $is_close,
			'is_poll'      => $is_poll,
		);
	}

	/**
	 * Check if setup list completed
	 *
	 * @since 1.0 HubSpot Addon
	 *
	 * @param $submitted_data
	 *
	 * @return bool
	 */
	public function create_ticket_is_completed( $submitted_data ) {
		$multi_id = '';
		if ( isset( $submitted_data['multi_id'] ) ) {
			$multi_id = $submitted_data['multi_id'];
		}

		if ( empty( $multi_id ) ) {
			return false;
		}

		$create_ticket = $this->get_multi_id_quiz_settings_value( $multi_id, 'create_ticket', '' );
		$pipeline_id   = $this->get_multi_id_quiz_settings_value( $multi_id, 'pipeline_id', '' );
		$status_id     = $this->get_multi_id_quiz_settings_value( $multi_id, 'status_id', '' );
		$ticket_name   = $this->get_multi_id_quiz_settings_value( $multi_id, 'ticket_name', '' );

		if ( ( empty( $create_ticket ) || '1' === $create_ticket ) && empty( $pipeline_id ) && empty( $status_id ) && empty( $ticket_name ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Check if multi_id form settings values completed
	 *
	 * @since 1.0 HubSpot Added
	 *
	 * @param $multi_id
	 *
	 * @return bool
	 */
	public function is_multi_quiz_settings_complete( $multi_id ) {
		$data = array( 'multi_id' => $multi_id );

		if ( ! $this->map_fields_is_completed( $data ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Generate multi id for multiple connection
	 *
	 * @since 1.0 HubSpot Addon
	 * @return string
	 */
	public function generate_multi_id() {
		return uniqid( 'hubspot_', true );
	}


	/**
	 * Override how multi connection displayed
	 *
	 * @since 1.0 HubSpot Addon
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
	 * Disconnect a connection from current form
	 *
	 * @since 1.0 HubSpot Addon
	 *
	 * @param array $submitted_data
	 */
	public function disconnect_form( $submitted_data ) {
		// only execute if multi_id provided on submitted data.
		if ( isset( $submitted_data['multi_id'] ) && ! empty( $submitted_data['multi_id'] ) ) {
			$addon_quiz_settings = $this->get_quiz_settings_values();
			unset( $addon_quiz_settings[ $submitted_data['multi_id'] ] );
			$this->save_quiz_settings_values( $addon_quiz_settings );
		}
	}
}