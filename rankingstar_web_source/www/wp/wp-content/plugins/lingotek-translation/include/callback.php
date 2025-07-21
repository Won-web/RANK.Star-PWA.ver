<?php

/*
 * a class to handle Lingotek callbacks
 *
 * @since 0.1
 */
class Lingotek_Callback {
	public $lgtm;

	/*
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct(&$model) {
		$this->lgtm = &$model;
		add_filter('request', array(&$this, 'request'));
	}

	/*
	 * dispatches the Lingotek callback and dies
	 *
	 * @since 0.1
	 *
	 * @param array $query_vars query vars known to WordPres
	 * @return array unmodified query vars if the request is not a Lingotek callback
	 */
	public function request($query_vars) {
		if (empty($query_vars['lingotek'])) {
			return $query_vars;
		}
		$type = $_GET['type'];
		if (isset($type, $_GET['document_id']) && $document = $this->lgtm->get_group_by_id($_GET['document_id'])) {
			switch ($type) {
				case 'get':
					$this->handleGet($document);	
					break;
				case 'target':
				case 'phase':
					$this->handleTargetOrPhase($document, $type);
					break;
				case 'target_cancelled':
					$this->handleTargetCancelled($document);
					break;
				case 'document_uploaded':
				case 'document_updated':
					$this->handleDocumentUploadedOrUpdated($document);
					break;
				case 'import_failure':
					$this->handleImportFailure($document);
					break;
				case 'document_archived':
				case 'document_deleted':
					$this->handleDocumentArchivedOrDeleted($document);
					break;
				case 'document_cancelled';
					$this->handleDocumentCancelled($document);
					break;
				default:
					Lingotek_Logger::info('Callback received, no handler for type', array('Type' => $type));
			}
			status_header(200); // useless as it the default value
			die();
		}
		status_header(404); // no document found
		die();
	}

	public function handleGet($document) {
		// url for in context review
		if (isset($_GET['locale'])) {
			$locale = Lingotek::map_to_wp_locale($_GET['locale']); // map to WP locale
			Lingotek_Logger::info('Callback received', array('Callback Parameters' => $_GET));
			// posts
			if (post_type_exists($document->type)) {
				if ($id = PLL()->model->post->get($document->source, $locale)) {
					wp_redirect(get_permalink($id), 301);
					exit();
				}
				else {
					wp_redirect(get_permalink($document->source), 302);
					exit();
				}
			}
			// taxonomy terms
			elseif (taxonomy_exists($document->type) && $id = $document->pllm->get_term($document->source, $locale)) {
				wp_redirect(get_term_link($id, $document->type), 301);
				exit();
			}

			status_header(404); // no document found
			die();
		}
	}

	public function handleTargetOrPhase($document, $type) {
		if (isset($_GET['locale'])) {
			$callback_parameters = array(
				'Target Locale' => isset($_GET['locale_code']) ? $_GET['locale_code'] : NULL,
				'Phase Name' => isset($_GET['phase_name']) ? $_GET['phase_name'] : NULL,
				'Status' => isset($_GET['status']) ? $_GET['status'] : NULL,
				'Document ID' => isset($_GET['document_id']) ? $_GET['document_id'] : NULL,
				'Project ID' => isset($_GET['projectId']) ? (int)$_GET['projectId'] : NULL,
				'Community ID' => isset($_GET['community_id']) ? $_GET['community_id'] : NULL,
				'Progress' => isset($_GET['progress']) ? (int)$_GET['progress'] : NULL,
				'Complete' => isset($_GET['complete']) ? $_GET['complete'] : NULL,
				'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
				'Document Status' => isset($_GET['doc_status']) ? $_GET['doc_status'] : NULL,
			);
			Lingotek_Logger::info('Callback received', array('Callback Parameters' => $callback_parameters));
			// We will need access to PLL_Admin_Sync::copy_post_metas
			global $polylang;
			$polylang->sync = new PLL_Admin_Sync($polylang);
			$locale = Lingotek::map_to_wp_locale($_GET['locale']); // map to WP locale
			$document->is_automatic_download($locale) ? $document->create_translation($locale, true, $type) : $document->translation_ready($locale);
		}
	}

	public function handleDocumentUploadedOrUpdated($document) {
		$document->source_ready();
		$callback_parameters = array(
			'Document ID' => isset($_GET['document_id']) ? $_GET['document_id'] : NULL,
			'Project ID' => isset($_GET['projectId']) ? (int)$_GET['projectId'] : NULL,
			'Community ID' => isset($_GET['community_id']) ? $_GET['community_id'] : NULL,
			'Progress' => isset($_GET['progress']) ? (int)$_GET['progress'] : NULL,
			'Complete' => isset($_GET['complete']) ? $_GET['complete'] : NULL,
			'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
			'Document Status' => isset($_GET['doc_status']) ? $_GET['doc_status'] : NULL,
		);
		Lingotek_Logger::info('Callback received', array('Callback Parameters' => $callback_parameters));
		if ($document->is_automatic_upload()) {
			$document->request_translations();
		}
	}

	public function handleImportFailure($document) {
		$callback_parameters = array(
			'Document ID' => isset($_GET['document_id']) ? $_GET['document_id'] : NULL,
			'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
		);
		if (isset($_GET['prev_document_id'])) {
			Lingotek_Logger::info("Document update failed. Reverting to previous id", $callback_parameters);
			$document->id = $_GET['prev_document_id'];
		}
		Lingotek_Logger::info('Callback received', array('Callback Parameters' => $callback_parameters));
		$document->source_failed();
	}
	
	public function handleDocumentArchivedOrDeleted($document) {
		$callback_parameters = array (
			'Document ID' => isset($_GET['document_id']) ? $_GET['document_id'] : NULL,
			'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
		);
		Lingotek_Logger::info('Callback received', array('Callback Parameters' => $callback_parameters));
		$wp_id = isset($document->desc_array['lingotek']['source']) ? $document->desc_array['lingotek']['source'] : NULL;
		unset($document->desc_array['lingotek']);
		$document->document_id = '';
		$document->save();
		wp_remove_object_terms($wp_id, "lingotek_hash_{$wp_id}", "lingotek_hash");
	}

	public function handleDocumentCancelled($document) {
		$callback_parameters = array(
			'Document ID' => isset($_GET['document_id']) ? $_GET['document_id'] : NULL,
			'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
		);
		if (isset($document->desc_array['lingotek']['translations']) && count($document->desc_array['lingotek']['translations']) > 0 ) {
			unset($document->desc_array['lingotek']['translations']);
			$document->desc_array['lingotek']['status'] = 'cancelled';
		} else {
			unset($document->desc_array['lingotek']);
		}
		$wp_id = isset($document->desc_array['lingotek']['source']) ? $document->desc_array['lingotek']['source'] : NULL;
		$document->status = 'cancelled';
		$document->save();
		wp_remove_object_terms($wp_id, "lingotek_hash_{$wp_id}", "lingotek_hash");
		Lingotek_Logger::info('Callback Received', array('Callback Parameters' => $callback_parameters));
	}

	public function handleTargetCancelled($document) {
		$callback_parameters = array(
			'Document ID' => isset($_GET['document_id'])  ? $_GET['document_id'] : NULL,
			'Type' => isset($_GET['type']) ? $_GET['type'] : NULL,
			'Locale' => isset($_GET['locale']) ? $_GET['locale'] : NULL,
		);
		$locale = Lingotek::map_to_wp_locale($_GET['locale']); // map to WP locale
		if (!isset($document->desc_array['lingotek']['translations'][$locale])) {
			$document->desc_array['lingotek']['translations'][] = $locale;
		}
		$document->desc_array['lingotek']['translations'][$locale] = 'cancelled';
		$document->save();
		Lingotek_Logger::info('Callback received', array('Callback Parameters' => $callback_parameters));
	}
	
}
