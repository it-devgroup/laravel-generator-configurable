<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataRoute
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataRoute
{
    /**
     * @var bool
     */
    private bool $enable;
    /**
     * @var string|null
     */
    private ?string $filename;
    /**
     * @var string|null
     */
    private ?string $prefix;

    /**
     * @param bool $enable
     * @param string|null $filename
     * @param string|null $prefix
     * @return self
     */
    public static function register(
        bool $enable,
        ?string $filename,
        ?string $prefix
    ): self {
        $model = (new self());
        $model->enable = $enable;
        $model->filename = $filename;
        $model->prefix = $prefix;

        return $model;
    }

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }
}
