# SilverStripe (inline) LinkField module

Allows adding one or multiple links to any object and saves into a single DB field.  
Editing happens inline in the form field, no GridField or popup is used.  

## Screenshots

Empty LinkList:  
![](https://paste.zauberfisch.com/i/600e0dc1c4323/linkfield-empty.png)

LinkList with 6 links (all possible types):  
![](https://paste.zauberfisch.com/i/600e0dc1c4323/linkfield-all.png)


## Know Bugs/Limitations (fixes are being worked on)

- At the moment, there is no way to limit the amount of links a user can add
- Uploading a file only works in the popup for attaching a file. the direct "upload new" link is not working (1)
- Using normal DropdownField with indentation instead of TreeDropdownField for Page selection (1)
- Files are not automatically published

(1) Problem is a bug in the underlying dependency. Sub-Routes in ArrayListField are currently not working

## Maintainer Contact

* Zauberfisch <code@zauberfisch.at>

## Requirements

* php >=7.1
* silverstripe/framework >=4.5
* zauberfisch/silverstripe-serialized-dataobject >=4

## Installation

* `composer require "zauberfisch/silverstripe-easy-linkfield"`
* rebuild manifest (flush)

## Documentation

```php
<?php

class Page extends SilverStripe\CMS\Model\SiteTree {
    private static $db = [
        'Buttons' => \zauberfisch\LinkField\DBLinkList::class,
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab( 'Root.Main', [
            (new \zauberfisch\LinkField\LinkListField( 'Buttons', 'My Buttons'))
                ->setOrderable(true),
        ]);
        return $fields;
    }
}
```

You can also limit the types of links that are allowed (possible values are: 'internal', 'external', 'file', 'email', 'phone'):

```php
<?php

class MyClass extends \SilverStripe\ORM\DataObject {
    private static $db = [
        'ContactDetails' => \zauberfisch\LinkField\DBLinkList::class,
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab( 'Root.Main', [
            (new \zauberfisch\LinkField\LinkListField( 'ContactDetails', 'My Contact Details', ['email', 'phone']))
                ->setOrderable(true),
        ]);
        return $fields;
    }
}
```

Accessing the values in php:
```php
$list = $page->obj('Buttons')->getValue(); // $page being a Page object with a field Buttons from the example above
foreach($list as $button) {
    /** @var \zauberfisch\LinkField\Link\AbstractLink $button */
    // Always available Variables: getLink(), getAbsoluteLink(), getLinkType(), getTitle(), getNewTab()
    // And depending on the type: getPage() (internal), getPageID() (internal), getURL() (external), getFile() (file), getFileID() (file), getEmail() (email), getCountryPrefix() (phone), getNumber() (phone), getPhoneNumber() (phone)
    $link = $button->getLink();
    $absoluteLink = $button->getAbsoluteLink();
    $type = $button->getLinkType(); // one of 'internal', 'external', 'file', 'email', 'phone'
    $title = $button->getTitle();
    $openInNewTab = $button->getNewTab();
    // use the values here
}
```

Accessing the values in a template:
```html
<% loop $Buttons.getValue %>
    <!-- Always available Variables: $Link, $AbsoluteLink, $LinkType, $Title, $NewTab -->
    <!-- And depending on the type: $Page (internal), $PageID (internal), $URL (external), $File (file), $FileID (file), $Email (email), $CountryPrefix (phone), $Number (phone), $PhoneNumber (phone) -->
    <a href="$Link" <% if $NewTab %>target="_blank"<% end_if %>>$Title</a>
<% end_loop %>
```
