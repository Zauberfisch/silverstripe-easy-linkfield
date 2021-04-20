<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use zauberfisch\SerializedDataObject\AbstractDataObject;

/**
 * @property string $Title
 * @property string $NewTab
 * @method string getTitle()
 * @method string|boolean|int getNewTab()
 * @method static setTitle(string $title)
 * @method static setNewTab(boolean $title)
 */
abstract class AbstractLink extends AbstractDataObject {
	private static $fields = [
		'Title',
		'NewTab',
	];

	public function getCMSFields(): FieldList {
		return new FieldList([
			new FieldGroup([
				new TextField('Title', $this->fieldLabel('Title')),
				new CheckboxField('NewTab', $this->fieldLabel('NewTab')),
			]),
		]);
	}

	abstract public function getLink(): string;

	public function Link(): string {
		return $this->getLink();
	}

	public function getAbsoluteLink(): string {
		return $this->getLink();
	}

	public function AbsoluteLink(): string {
		return $this->getAbsoluteLink();
	}

	abstract public function getLinkType(): string;

	public function LinkType(): string {
		return $this->getLinkType();
	}
}
