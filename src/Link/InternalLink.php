<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;

/**
 * @property string $PageID
 * @method string|int getPageID()
 * @method static setPageID(int $pageID)
 */
class InternalLink extends AbstractLink {
	private static $fields = [
		'PageID',
	];

	public function getCMSFields(): FieldList {
		$fields = parent::getCMSFields();
		$pageMap = [];
		$mapPages = function ($pages, &$arr, $prefix = '') use (&$mapPages) {
			foreach ($pages as $page) {
				$arr[$page->ID] = ($prefix ? "$prefix> " : "") . $page->MenuTitle;
				if ($page->Children()->exists()) {
					$mapPages($page->Children(), $arr, "$prefix=");
				}
			}
			return $arr;
		};
		$mapPages(SiteTree::get()->filter('ParentID', 0), $pageMap);
		$fields->insertBefore(
			'NewTab',
			(new DropdownField('PageID', $this->fieldLabel('Page'), $pageMap))

		);
		return $fields;
	}

	/**
	 * @return \SilverStripe\ORM\DataObject|null|SiteTree
	 */
	public function getPage(): ?SiteTree {
		return $this->getPageID() ? SiteTree::get()->byID($this->getPageID()) : null;
	}

	public function getLink(): string {
		$page = $this->getPage();
		return $page && $page->exists() ? $page->Link() : '';
	}

	public function getAbsoluteLink(): string {
		$page = $this->getPage();
		return $page && $page->exists() ? $page->AbsoluteLink() : '';
	}

	public function getLinkType(): string {
		return 'internal';
	}
}
