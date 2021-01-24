<?php

declare(strict_types=1);

namespace zauberfisch\LinkField;

use zauberfisch\LinkField\Link\EmailLink;
use zauberfisch\LinkField\Link\ExternalLink;
use zauberfisch\LinkField\Link\FileLink;
use zauberfisch\LinkField\Link\InternalLink;
use zauberfisch\LinkField\Link\PhoneLink;
use zauberfisch\SerializedDataObject\Form\ArrayListField;

class LinkListField extends ArrayListField {
	private static $link_types = [
		'internal' => InternalLink::class,
		'external' => ExternalLink::class,
		'file' => FileLink::class,
		'email' => EmailLink::class,
		'phone' => PhoneLink::class,
	];

	public function __construct($name, $title, $allowedLinkTypes = []) {
		$possibleTypes = $this->config()->get('link_types');
		parent::__construct(
			$name,
			$title,
			array_values($allowedLinkTypes ? array_intersect_key($possibleTypes, array_flip($allowedLinkTypes)) : $possibleTypes)
		);
	}
}
