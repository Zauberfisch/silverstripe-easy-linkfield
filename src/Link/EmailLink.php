<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;

/**
 * @property string $Email
 * @method string getEmail()
 * @method static setEmail(string $email)
 */
class EmailLink extends AbstractLink {
	private static $fields = [
		'Email',
	];

	public function getCMSFields(): FieldList {
		$fields = parent::getCMSFields();
		$fields->insertBefore('NewTab', new EmailField('Email', $this->fieldLabel('Email')));
		$fields->removeByName('NewTab');
		return $fields;
	}

	public function getLink(): string {
		return sprintf('mailto:%s', $this->getEmail());
	}

	public function getLinkType(): string {
		return 'email';
	}
}
