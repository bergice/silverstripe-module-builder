<?php
//
//use GraphQL\Type\Definition\ResolveInfo;
//use GraphQL\Type\Definition\Type;
//use SilverStripe\Core\Manifest\ClassLoader;
//use SilverStripe\GraphQL\OperationResolver;
//use SilverStripe\GraphQL\QueryCreator;
//
//class ClassManifestQueryCreator extends QueryCreator implements OperationResolver
//{
//  public function attributes()
//    {
//        return [
//            'name' => 'readClassManifests'
//        ];
//    }
//
//    public function args()
//    {
//      return [
////        'ID' => ['type' => Type::nonNull(Type::id())]
//      ];
//    }
//
//    public function type()
//    {
//        return $this->manager->getType('classManifest');
//    }
//
//    public function resolve($object, array $args, $context, ResolveInfo $info)
//    {
//        $allClasses = DataObjectClass::getClassesForFolderRecursive('app/src');
//        return $allClasses;
////        $classLoader = ClassLoader::inst();
////        return $classLoader->getManifest()->getClasses();
//    }
//}
