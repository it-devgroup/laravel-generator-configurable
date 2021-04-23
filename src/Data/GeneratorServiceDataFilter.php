<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFilter
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFilter
{
    /**
     * @var GeneratorServiceDataFilterField[]|null
     */
    private ?array $fields;

    /**
     * @param GeneratorServiceDataFilterField[]|null $fields
     * @return self
     */
    public static function register(
        ?array $fields
    ): self {
        $model = (new self());
        $model->fields = $fields;

        return $model;
    }

    /**
     * @return GeneratorServiceDataFilterField[]|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}
