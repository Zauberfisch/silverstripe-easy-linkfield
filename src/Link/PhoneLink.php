<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * @property string $CountryPrefix
 * @property string $NumberWithoutPrefix
 * @method string getCountryPrefix()
 * @method string getNumberWithoutPrefix()
 * @method static setCountryPrefix(string $countryPrefix)
 * @method static setNumberWithoutPrefix(string $numberWithoutPrefix)
 */
class PhoneLink extends AbstractLink {
	private static $fields = [
		'CountryPrefix',
		'NumberWithoutPrefix',
	];

	public function getCMSFields() : FieldList {
		$fields = parent::getCMSFields();
		$countryMap = [];
		$fields->insertBefore('NewTab',
			(new TextField('CountryPrefix', $this->fieldLabel('Prefix'), $countryMap))
				->setAttribute('placeholder', '+43')
				->setAttribute('pattern', '\+[1-9]+')
		);
		$fields->insertBefore('NewTab',
			(new TextField('NumberWithoutPrefix', $this->fieldLabel('Number')))
				->setAttribute('placeholder', '1234567890')
				->setAttribute('pattern', '[1-9][0-9]*')
		);
		$fields->removeByName('NewTab');
		return $fields;
	}

	public function getPhoneNumber() :string {
		return $this->CountryPrefix . $this->NumberWithoutPrefix;
	}

	public function getLink() :string {
		return sprintf('tel:%s', $this->getPhoneNumber());
	}

	public function getLinkType() :string {
		return 'phone';
	}
}
