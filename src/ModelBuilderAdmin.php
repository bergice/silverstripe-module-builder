<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Core\ClassInfo;

class ModelBuilderAdmin extends ModelAdmin
{
    private static $url_segment = 'modeleditoradmin';

    private static $managed_models = [
        DataObjectClass::class,
    ];

//    private static $model_importers = [
//        Contact::class => CsvBulkLoader::class,
//    ];

    private static function updateDataObjectList()
    {
        $dataObjectClasses = DataObjectClass::getAll();

        // write classes
        /** @var DataObjectClass $dataObjectClass */
        foreach ($dataObjectClasses as $dataObjectClass) {
            $dataObjectClass->write();
        }

        // todo: delete removed classes
        // ...
    }

    public function getList()
    {
        static::updateDataObjectList();
        return parent::getList();
    }
}
