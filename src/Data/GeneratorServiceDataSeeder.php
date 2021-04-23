<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataSeeder
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataSeeder
{
    /**
     * @var bool
     */
    private bool $enable;
    /**
     * @var int
     */
    private int $countRows;
    /**
     * @var GeneratorServiceDataSeederField[]
     */
    private array $fields;

    /**
     * @param bool $enable
     * @param int $countRows
     * @param GeneratorServiceDataSeederField[] $fields
     * @return self
     */
    public static function register(
        bool $enable,
        int $countRows,
        array $fields
    ): self {
        $model = (new self());
        $model->enable = $enable;
        $model->countRows = $countRows;
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
     * @return int
     */
    public function getCountRows(): int
    {
        return $this->countRows;
    }

    /**
     * @return GeneratorServiceDataSeederField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
