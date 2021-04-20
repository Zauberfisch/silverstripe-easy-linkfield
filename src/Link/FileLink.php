<?php

declare(strict_types=1);

namespace zauberfisch\LinkField\Link;

use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use zauberfisch\SerializedDataObject\Form\UploadField;

/**
 * @property string $FileID
 * @method string|int getFileID()
 * @method static setFileID(int $fileID)
 */
class FileLink extends AbstractLink {
	private static $fields = [
		'FileID',
	];

	public function getCMSFields(): FieldList {
		$fields = parent::getCMSFields();
		$fields->push(
			(new UploadField('FileID', $this->fieldLabel('File')))
				->setIsMultiUpload(false)
				->setDescription(_t('zauberfisch\LinkField\Link\FileLink.UploadBugHint', '"Upload new" is currently not working. For now, please click on "Choose existing" and then upload a file there'))
		);
		return $fields;
	}

	/**
	 * @return \SilverStripe\ORM\DataObject|null|File
	 */
	public function getFile(): ?File {
		return $this->getFileID() ? File::get()->byID($this->getFileID()) : null;
	}

	/**
	 * @return \SilverStripe\ORM\DataObject|null|File
	 */
	public function File(): ?File {
		return $this->getFile();
	}

	public function getLink(): string {
		$file = $this->getFile();
		return $file && $file->exists() ? $file->getURL() : '';
	}

	public function getAbsoluteLink(): string {
		$file = $this->getFile();
		return $file && $file->exists() ? $file->getAbsoluteURL() : '';
	}

	public function getLinkType(): string {
		return 'file';
	}
}
