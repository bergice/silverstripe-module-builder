<?php


use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use SilverStripe\Core\Manifest\ClassManifestVisitor;
use SilverStripe\Core\Manifest\DataObjectVisitor;

class DataObjectParser
{
    /**
     * PHP Parser for parsing found files
     *
     * @var Parser
     */
    private $parser;

    /**
     * @var NodeTraverser
     */
    private $traverser;

    /**
     * @var ClassManifestVisitor
     */
    private $visitor;

    /**
     * @var \PhpParser\Node\Stmt[]|null
     */
    private $stmts;

    /**
     * @var MutableSource
     */
    private $source;

    /**
     * DataObjectParser constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->handleFile($filePath);
    }

    /**
     * Get or create active parser
     *
     * @return Parser
     */
    public function getParser()
    {
        if (!$this->parser) {
            $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        }

        return $this->parser;
    }

    /**
     * Get node traverser for parsing class files
     *
     * @return NodeTraverser
     */
    public function getTraverser()
    {
        if (!$this->traverser) {
            $this->traverser = new NodeTraverser();
//            $this->traverser->addVisitor(new NameResolver());
            $this->traverser->addVisitor($this->getVisitor());
        }

        return $this->traverser;
    }

    /**
     * Get visitor for parsing class files
     *
     * @return ClassManifestVisitor
     */
    public function getVisitor()
    {
        if (!$this->visitor) {
            $this->visitor = new DataObjectVisitor();
        }

        return $this->visitor;
    }

    /**
     * Visit a file to inspect for classes, interfaces and traits
     *
     * @param string $filePath
     */
    public function handleFile(string $filePath)
    {
        $contents = file_get_contents($filePath);
        $this->stmts = $this->getParser()->parse($contents);
        $this->source = new MutableSource($contents);
    }

    /**
     * @return string
     */
    public function transform() {
        if (!$this->stmts) {
            throw new InvalidArgumentException("You need to parse some code first!");
        }

        $this->getTraverser()->traverse($this->source->getAst());
        return $this->source->getModifiedString();
    }
}
