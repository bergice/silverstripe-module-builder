<?php

use SilverStripe\Assets\File;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Flushable;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class DataObjectString extends DataObjectField
{
    private static $singular_name = 'String';

    private static $plural_name = 'Strings';

}
