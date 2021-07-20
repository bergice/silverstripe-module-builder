<?php

use SilverStripe\Admin\ModelAdmin;

class DataObjectBuilderAdmin extends ModelAdmin
{
    private static $url_segment = 'dataobjects';

    private static $managed_models = [
        DataObjectClass::class,
    ];

//    private static $model_importers = [
//        Contact::class => CsvBulkLoader::class,
//    ];

    public function getList()
    {
        // todo: maybe move this into dev/build?flush and/or add a button called "Sync"
//        DataObjectClassSyncer::updateDataObjectClassesFromDataObjects();
        return parent::getList();
    }
}
