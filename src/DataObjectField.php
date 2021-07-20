<?php

use SilverStripe\Assets\File;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Flushable;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

/**
 * Represents a `DBField` on a `DataObject`
 * Class DataObjectField
 */
class DataObjectField extends DataObject
{
    private static $singular_name = 'Field';

    private static $plural_name = 'Fields';

    private static $hide_ancestor = 'DataObjectField';

    private static $db = [
        'Name' => 'Varchar(255)',
    ];

//    private static $indexes = [
//        'NameIndex' => [
//            'type' => 'unique',
//            'columns' => ['Name'],
//        ],
//    ];

    private static $summary_fields = [
        'Name',
    ];

    private static $belongs_many_many = [
        'DataObjectClass' => DataObjectClass::class
    ];

//    public function getCMSFields()
//    {
//        $fields = parent::getCMSFields();
//        return $fields;
//    }
}
