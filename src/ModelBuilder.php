<?php

use SilverStripe\Admin\CMSMenu;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\CMS\Controllers\CMSMain;
use SilverStripe\Control\Controller;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\GraphQL\Scaffolding\Scaffolders\DataObjectScaffolder;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DataObjectSchema;

class ModelBuilder extends LeftAndMain
{
    private static $url_segment = 'modeleditor';

    public function getEditForm($id = null, $fields = null)
    {
//        $editForm = parent::getEditForm($id, $fields);
//
//        return $editForm;

        $form = Form::create(
            $this,
            'EditForm',
            new FieldList($this->getGridField()),
            new FieldList()
        )->setHTMLID('Form_EditForm');
//        $form->addExtraClass('cms-edit-form cms-panel-padded center flexbox-area-grow');
//        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));
//        $editFormAction = Controller::join_links($this->Link($this->sanitiseClassName($this->modelClass)), 'EditForm');
//        $form->setFormAction($editFormAction);
//        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        $this->extend('updateEditForm', $form);

        return $form;
    }

    protected function getGridField(): GridField
    {
//        $gridFieldConfig = GridFieldConfig::create()->addComponents(
//            new GridFieldToolbarHeader(),
//            new GridFieldAddNewButton('toolbar-header-right'),
//            new GridFieldSortableHeader(),
//            new GridFieldDataColumns(),
//            new GridFieldPaginator(10),
//            new GridFieldEditButton(),
//            new GridFieldDeleteAction(),
//            new GridFieldDetailForm()
//        );
////
////        $gridField = new GridField("Contacts", "Contact list:", $this->Contacts(), $gridFieldConfig);
////        $fields->addFieldToTab("Root.Contacts", $gridField);
//
//
//        $field = GridField::create(
//            'Grid Field',
////            $this->sanitiseClassName($this->modelClass),
//            false,
//            $this->getList(),
//            $gridFieldConfig
//        );
//
//        $this->extend('updateGridField', $field);
//
//        return $field;

//        $list = new DataList('Page');
//        $list = new ArrayList('DataObjectClass');
//        $list->setDataClass(Page::class);
//        $list->setDataClass(DataObject::class);
//        $list = static::getDataTypes();
        $list = DataObjectClass::getAll();

        $gridField = new GridField('ExampleGrid', 'Example grid', $list);
//        $gridField->setModelClass(DataObjectClass::class);
        return $gridField;
    }

    public function getList()
    {
        return $this->getDataTypes();
//        $list = DataObject::singleton($this->modelClass)->get();
//
//        $this->extend('updateList', $list);
//
//        return $list;
    }

    private static function getDataTypes() {
//        /** @var DataObjectSchema $dataObjectSchema */
//        $dataObjectSchema = DataObjectSchema::create();
//        /** @var DataObjectScaffolder $dataObjectScaffolder */
//        $dataObjectScaffolder = new DataObjectScaffolder(DataObject::class);

        $allClasses = ClassInfo::allClasses();

//        $cmsClasses = CMSMenu::get_cms_classes();

//        return new ArrayList($allClasses);
        return DataObjectClass::getAll();
    }
}
