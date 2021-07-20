<?php

use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Flushable;
use SilverStripe\Core\Manifest\ClassLoader;
use SilverStripe\Core\Manifest\ClassManifest;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\ORM\DataObject;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

/**
 * Class DataObjectClass
 * @property string Class
 */
class DataObjectClass extends DataObject implements Flushable
{
    private static $singular_name = 'Class';

    private static $plural_name = 'Classes';

    private static $db = [
        'Class' => 'Varchar(255)',
    ];

    private static $indexes = [
        'ClassIndex' => [
            'type' => 'unique',
            'columns' => ['Class'],
        ],
    ];

    private static $many_many = [
        'DataObjectFields' => DataObjectField::class
    ];

    private static $summary_fields = [
        'Class',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

//        // Make the class field readonly
//        $fields->removeByName('Class');
//        $classField = ReadonlyField::create('Class', "Class", $this->Class);
//        $fields->addFieldToTab('Root.Main',  $classField);

        // Add multi-class field button
        $dataObjectFieldsTab = $fields->findOrMakeTab('Root.DataObjectFields');
        $dataObjectFieldsGridField = $dataObjectFieldsTab->fieldByName('DataObjectFields');
        $dataObjectFieldsGridFieldConfig = $dataObjectFieldsGridField->getConfig();
        $dataObjectFieldsGridFieldConfig->removeComponentsByType(GridFieldAddNewButton::class);
        $multiClassAddField = new GridFieldAddNewMultiClass();
        $dataObjectFieldsGridFieldConfig->addComponent($multiClassAddField);

//        $schema = $this->getSchema();

        return $fields;
    }

    public static function flush()
    {
        // todo: don't do this until the `DataObjectClass` table exists
//        DataObjectClassSyncer::updateMissingRecords();
    }

    /**
     * @param bool $original Attempts to use the original Class name before it was changed
     * @return string|null
     */
    public function getClassFilePath(bool $original = false)
    {
        if ($original) {
            $change = $this->getChangedFields()['Class'];
            if ($change) {
                $class = $change['before'];
            }
        }
        if (!$class) {
            $class = $this->Class;
        }

        /** @var ClassManifest $classManifest */
        $classManifest = ClassLoader::inst()->getManifest();
        $filePath = $classManifest->getItemPath($class);
        return $filePath;
    }

    protected function onBeforeWrite()
    {
        DataObjectClassSyncer::updateDataObjectFromDataObjectClass($this);
        parent::onBeforeWrite();
    }
}
