<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataMigration
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataMigration
{
    /**
     * @var bool
     */
    private bool $enable;
    /**
     * @var GeneratorServiceDataMigrationField[]
     */
    private array $fields;

    /**
     * @param bool $enable
     * @param GeneratorServiceDataMigrationField[] $fields
     * @return self
     */
    public static function register(
        bool $enable,
        array $fields
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
     * @return GeneratorServiceDataMigrationField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
