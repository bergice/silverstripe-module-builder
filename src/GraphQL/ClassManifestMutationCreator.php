<?php
//
//use GraphQL\Type\Definition\ResolveInfo;
//use GraphQL\Type\Definition\Type;
//use SilverStripe\GraphQL\OperationResolver;
//use SilverStripe\GraphQL\MutationCreator;
//
//class ClassManifestMutationCreator extends MutationCreator implements OperationResolver
//{
//  public function attributes()
//    {
//        return [
//            'name' => 'uploadFileMutation'
//        ];
//    }
//
//    public function type()
//    {
//        return $this->manager->getType('file');
//    }
//
//    public function args()
//    {
//        return [
//        'File' => ['type' => Type::nonNull($this->manager->getType('upload'))]
//      ];
//    }
//
//    public function resolve($object, array $args, $context, ResolveInfo $info)
//    {
//      $file = $args['File'];
//      return $file;
//    }
//}
