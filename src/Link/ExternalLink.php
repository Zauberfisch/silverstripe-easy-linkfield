<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * @property string $URL
 * @method string getURL()
 * @method static setURL(string $url)
 */
class ExternalLink extends AbstractLink {
	private static $fields = [
		'URL',
	];

	public function getCMSFields(): FieldList {
		$fields = parent::getCMSFields();
		$fields->insertBefore('NewTab', new TextField('URL', $this->fieldLabel('URL')));
		return $fields;
	}

	public function getLink(): string {
		return $this->getURL();
	}

	public function getLinkType(): string {
		return 'external';
	}
}
