<?php

use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

//https://github1s.com/silverstripe/silverstripe-upgrader/blob/HEAD/src/UpgradeRule/PHP/Visitor/RenameClassesVisitor.php
//https://github.com/nikic/PHP-Parser/blob/master/doc/component/AST_builders.markdown

/**
 * Helper for syncing DataObjectClasses with DataObject source files.
 *
 * todo: add changeset reviewer in the front-end as a modal when syncing so you can see what data is being transferred
 */
class DataObjectClassSyncer
{
    /**
     * Returns a list of classes inside a folder
     * @param string $folder
     * @param array $classes
     * @param string $extends
     * @return array|mixed
     */
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

    /**
     * Returns a list of all classes as DataObjectClasses.
     * Will either get the existing class or create a new one if missing.
     * @return ArrayList
     */
    public static function getAndCreateMissing() {
        // todo: refactor app/src to config (array of folders to scan)
//        $allClasses = ClassInfo::subclassesFor(DataObject::class);
        $allClasses = static::getClassesForFolderRecursive('app/src');
//        $allClasses = ClassInfo::classes_for_folder('app/src');

//        $cmsClasses = CMSMenu::get_cms_classes();

        $arrayList = new ArrayList();
//        $arrayList = new DataList(DataObjectClass::class);
        foreach ($allClasses as $class) {
            // get or create
            $dataObjectClass = DataObjectClass::get()->where(['Class' => $class])->first() ?: new DataObjectClass();
            $dataObjectClass->Class = $class;
            $arrayList->add($dataObjectClass);
        }
        return $arrayList;
    }

    /**
     * Retrieves a DataObjectClass for every DataObject class in the manifest.
     * Note that some of these instances will be created if not already saved.
     *
     * Then updates all the fields from the DataObject.
     *
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function updateDataObjectClassesFromDataObjects()
    {
        $dataObjectClasses = static::getAndCreateMissing();

        /** @var DataObjectClass $dataObjectClass */
        foreach ($dataObjectClasses as $dataObjectClass) {
            static::updateDataObjectClassFromDataObject($dataObjectClass);
        }

        // todo: delete removed classes
        // ...
    }

    private static function updateDataObjectClassFromDataObject(DataObjectClass $dataObjectClass)
    {
        // update classes

        // write classes
        $dataObjectClass->write();
    }

    /**
     * Updates the DataObject source files using traverser based on the DataObjectClasses.
     *
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function updateDataObjectsFromDataObjectClasses()
    {
        $dataObjectClasses = static::getAndCreateMissing();

        /** @var DataObjectClass $dataObjectClass */
        foreach ($dataObjectClasses as $dataObjectClass) {
            static::updateDataObjectFromDataObjectClass($dataObjectClass);
            $dataObjectClass->write();
        }

        // todo: delete removed classes
        // ...
    }

    public static function updateDataObjectFromDataObjectClass(DataObjectClass $dataObjectClass)
    {
        // todo: retrieve the parsed AST statement here (read the source file)
        $filePath = $dataObjectClass->getClassFilePath(true);
        $dataObjectParser = new DataObjectParser($filePath);

        foreach ($dataObjectClass->getChangedFields() as $fieldName => $change) {
            switch($fieldName) {
                case "Class":
//                    $dataObjectParser->setClass($change['after']);
                    break;
            }
        }

        // todo: update (create) the class file if there are changes
        $dataObjectParser->transform();
    }

//    /**
//     * Updates our list of DataObjectClasses
//     */
//    private static function updateMissingRecords()
//    {
//        // todo: could instead just add an extension to DataObject
//        // todo: then when a data object is flushed
//
//
//        // todo: listen for dataobject database updates
////        extensions: DataObject::augmentDatabase
//
//        $classes = static::getAll();
//    }
}
