<?php

namespace SchemaBundle\Registry;

class SchemaGeneratorRegistry implements SchemaGeneratorRegistryInterface
{
    /**
     * @var array
     */
    protected $generator;

    /**
     * @var string
     */
    protected $interface;

    /**
     * @param string $interface
     */
    public function __construct($interface)
    {
        $this->interface = $interface;
    }

    /**
     * {@inheritdoc}
     */
    public function register($service, $alias)
    {
        if (!in_array($this->interface, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s needs to implement "%s", "%s" given.',
                    get_class($service),
                    $this->interface,
                    implode(', ', class_implements($service))
                )
            );
        }

        $this->generator[$alias] = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function has($alias)
    {
        return isset($this->generator[$alias]);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        if (!is_array($this->generator)) {
            return [];
        }

        return $this->generator;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        if (!$this->has($alias)) {
            throw new \Exception('"' . $alias . '" Schema Generator does not exist');
        }

        return $this->generator[$alias];
    }
}
