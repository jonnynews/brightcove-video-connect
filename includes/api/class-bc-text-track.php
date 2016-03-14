<?php

/**
 * Represent an individual text track (i.e. caption track) for a video
 */

class BC_Text_Track {
	/**
	 * @var string URL for a WebVTT file
	 */
	protected $url;

	/**
	 * @var string ISO 639 2-letter language code for the text tracks
	 */
	protected $srcLang;

	/**
	 * @var string How the VTT file is meant to be used
	 */
	protected $kind;

	/**
	 * @var string Human-readable title
	 */
	protected $label;

	/**
	 * @var bool Set the default language for captions/subtitles
	 */
	protected $default;

	/**
	 * Build up the object as needed.
	 *
	 * @param string $url
	 * @param string $language
	 * @param string [$kind]
	 * @param string [$label]
	 * @param bool   [$default]
	 */
	public function __construct( $url, $language = 'en', $kind = 'captions', $label = '', $default = false ) {
		$this->url = esc_url_raw( $url );
		$this->srcLang = substr( sanitize_text_field( $language ), 0, 2 );
		if ( ! in_array( $kind, array( 'captions', 'subtitles', 'descriptions', 'chapters', 'metadata' ) ) ) {
			$this->kind = 'captions';
		} else {
			$this->kind = $kind;
		}
		$this->label = sanitize_text_field( $label );
		$this->default = !! $default;
	}

	/**
	 * Return an array representation of the Text Track for use in API requests
	 *
	 * @return array
	 */
	public function toArray() {
		$data = array(
			'url'     => $this->url,
			'srcLang' => $this->srcLang,
			'kind'    => $this->kind,
			'default' => $this->default,
		);

		if ( ! empty( $this->label ) ) {
			$data['label'] = $this->label;
		}

		return $data;
	}
}