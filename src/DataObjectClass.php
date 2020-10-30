<?php

use SilverStripe\Assets\File;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Flushable;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

/**
 * Class DataObjectClass
 * @property string Name
 */
class DataObjectClass extends DataObject implements Flushable
{
    private static $db = [
        'Name' => 'Varchar(255)',
    ];

    private static $indexes = [
        'NameIndex' => [
            'type' => 'unique',
            'columns' => ['Name'],
        ],
    ];

    private static $summary_fields = [
        'Name',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public static function getClassesForFolderRecursive(
        string $folder,
        array $classes = [],
        string $extends = DataObject::class
    ) {
        // get classes for children
        $absFolderPath = Director::getAbsFile($folder);
        $handle = opendir($absFolderPath);
        while (false !== ($child = readdir($handle))) {
            if ($child == "." || $child == "..") {
                continue;
            }
            $childAbsPath = $absFolderPath . DIRECTORY_SEPARATOR . $child;
            if (is_dir($childAbsPath)) {
                $classes += static::getClassesForFolderRecursive($childAbsPath, $classes, $extends);
            }
        }

        // get classes for current folder
        $classes += array_filter(ClassInfo::classes_for_folder($absFolderPath), function ($class) use ($extends) {
            $ancestry = ClassInfo::ancestry($class);
            return in_array($extends, $ancestry);
        });

        return $classes;
    }

    public static function getAll() {
        // todo: only get for our app/src folder
//        $allClasses = ClassInfo::subclassesFor(DataObject::class);
        $allClasses = static::getClassesForFolderRecursive('app/src');
//        $allClasses = ClassInfo::classes_for_folder('app/src');

//        $cmsClasses = CMSMenu::get_cms_classes();

        $arrayList = new ArrayList();
//        $arrayList = new DataList(DataObjectClass::class);
        foreach ($allClasses as $class) {
            // get or create
            $dataObjectClass = DataObjectClass::get()->where(['Name' => $class])->first() ?: new DataObjectClass();
            $dataObjectClass->Name = $class;
            $arrayList->add($dataObjectClass);
        }
        return $arrayList;
    }

    public static function flush()
    {
        // todo: don't do this until the `DataObjectClass` table exists
        static::updateMissingRecords();
    }

    private static function updateMissingRecords()
    {
        // todo: could instead just add an extension to DataObject
        // todo: then when a data object is flushed


        // todo: listen for dataobject database updates
//        extensions: DataObject::augmentDatabase

        $classes = static::getAll();
    }
}
