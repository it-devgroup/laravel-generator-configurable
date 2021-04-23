<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataControllerUpdate
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataControllerUpdate
{
    /**
     * @var bool
     */
    private bool $enable;
    /**
     * @var GeneratorServiceDataControllerUpdateField[]|null
     */
    private ?array $fields;

    /**
     * @param bool $enable
     * @param GeneratorServiceDataControllerUpdateField[]|null $fields
     * @return self
     */
    public static function register(
        bool $enable,
        ?array $fields
    ): self {
        $model = (new self());
        $model->enable = $enable;
        $model->fields = $fields;

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
     * @return GeneratorServiceDataControllerUpdateField[]|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
