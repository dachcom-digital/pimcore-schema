<?php

namespace SchemaBundle\Registry;

class SchemaGeneratorRegistry implements SchemaGeneratorRegistryInterface
{
    /**
     * @var array
     */
    protected $generator;

    /**
     * @var array
     */
    protected $fragmentGenerator;

    /**
     * @var string
     */
    protected $generatorInterface;

    /**
     * @var string
     */
    protected $fragmentGeneratorInterface;

    /**
     * @param $generatorInterface
     * @param $fragmentGeneratorInterface
     */
    public function __construct($generatorInterface, $fragmentGeneratorInterface)
    {
        $this->generatorInterface = $generatorInterface;
        $this->fragmentGeneratorInterface = $fragmentGeneratorInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function registerGenerator($service, $alias)
    {
        if (!in_array($this->generatorInterface, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s needs to implement "%s", "%s" given.',
                    get_class($service),
                    $this->generatorInterface,
                    implode(', ', class_implements($service))
                )
            );
        }

        $this->generator[$alias] = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function registerFragmentGenerator($service, $alias)
    {
        if (!in_array($this->fragmentGeneratorInterface, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s needs to implement "%s", "%s" given.',
                    get_class($service),
                    $this->fragmentGeneratorInterface,
                    implode(', ', class_implements($service))
                )
            );
        }

        $this->fragmentGenerator[$alias] = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGenerator($alias)
    {
        return isset($this->generator[$alias]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFragmentGenerator($alias)
    {
        return isset($this->fragmentGenerator[$alias]);
    }

    /**
     * {@inheritdoc}
     */
    public function allGenerators()
    {
        if (!is_array($this->generator)) {
            return [];
        }

        return $this->generator;
    }

    /**
     * {@inheritdoc}
     */
    public function allFragmentGenerators()
    {
        if (!is_array($this->fragmentGenerator)) {
            return [];
        }

        return $this->fragmentGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function getGenerator($alias)
    {
        if (!$this->hasGenerator($alias)) {
            throw new \Exception('"' . $alias . '" Schema Generator does not exist');
        }

        return $this->generator[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function getFragmentGenerator($alias)
    {
        if (!$this->hasFragmentGenerator($alias)) {
            throw new \Exception('"' . $alias . '" Schema Fragment Generator does not exist');
        }

        return $this->fragmentGenerator[$alias];
    }
}
