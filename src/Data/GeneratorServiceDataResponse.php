<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataResponse
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataResponse
{
    /**
     * @var bool|null
     */
    private ?bool $enable;
    /**
     * @var GeneratorServiceDataResponseField[]|null
     */
    private ?array $fields;

    /**
     * @param bool|null $enable
     * @param GeneratorServiceDataResponseField[]|null $fields
     * @return self
     */
    public static function register(
        ?bool $enable,
        ?array $fields
    ): self {
        $model = (new self());
        $model->enable = $enable;
        $model->fields = $fields;

        return $model;
    }

    /**
     * @return bool|null
     */
    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    /**
     * @return GeneratorServiceDataResponseField[]|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
