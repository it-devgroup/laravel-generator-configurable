<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataControllerCreate
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataControllerCreate
{
    /**
     * @var bool
     */
    private bool $enable;
    /**
     * @var GeneratorServiceDataControllerCreateField[]|null
     */
    private ?array $fields;

    /**
     * @param bool $enable
     * @param array|null $fields
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
     * @return GeneratorServiceDataControllerCreateField[]|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
