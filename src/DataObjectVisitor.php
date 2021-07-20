<?php

namespace SilverStripe\Core\Manifest;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class DataObjectVisitor extends NodeVisitorAbstract
{
    private $classRenames = [];

    public function beforeTraverse(array $nodes)
    {
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_) {
            // todo: this is where we're at currently. trying to rename the class in the file when you change it on the admin
//            $node->class('Class');
//            $this->source->replaceNode($classNode, new Name([ $baseName ]));

//            $extends = [];
//            $interfaces = [];
//
//            if ($node->extends) {
//                $extends = [(string)$node->extends];
//            }
//
//            if ($node->implements) {
//                foreach ($node->implements as $interface) {
//                    $interfaces[] = (string)$interface;
//                }
//            }
//
//            $this->classes[(string)$node->namespacedName] = [
//                'extends' => $extends,
//                'interfaces' => $interfaces,
//            ];
        } elseif ($node instanceof Node\Stmt\Trait_) {
//            $this->traits[(string)$node->namespacedName] = [];
        } elseif ($node instanceof Node\Stmt\Interface_) {
//            $extends = [];
//            foreach ($node->extends as $ancestor) {
//                $extends[] = (string)$ancestor;
//            }
//            $this->interfaces[(string)$node->namespacedName] = [
//                'extends' => $extends,
//            ];
        }
        if (!$node instanceof Node\Stmt\Namespace_) {
//            //break out of traversal as we only need highlevel information here!
//            return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
    }

    public function getClasses()
    {
        return $this->classes;
    }

    public function getTraits()
    {
        return $this->traits;
    }

    public function getInterfaces()
    {
        return $this->interfaces;
    }
}
