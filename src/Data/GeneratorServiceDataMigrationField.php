<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataMigrationField
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataMigrationField
{
    /**
     * @var string|null
     */
    private ?string $field;
    /**
     * @var string|null
     */
    private ?string $type;
    /**
     * @var string|null
     */
    private ?string $value;
    /**
     * @var string|null
     */
    private ?string $param1;
    /**
     * @var string|null
     */
    private ?string $param2;
    /**
     * @var bool
     */
    private bool $nullable;
    /**
     * @var bool
     */
    private bool $index;

    /**
     * @param string|null $field
     * @param string|null $type
     * @param string|null $value
     * @param string|null $param1
     * @param string|null $param2
     * @param bool $nullable
     * @param bool $index
     * @return self
     */
    public static function register(
        ?string $field,
        ?string $type,
        ?string $value,
        ?string $param1,
        ?string $param2,
        bool $nullable,
        bool $index
    ): self {
        $model = (new self());
        $model->field = $field;
        $model->type = $type;
        $model->value = $value;
        $model->param1 = $param1;
        $model->param2 = $param2;
        $model->nullable = $nullable;
        $model->index = $index;

        return $model;
    }

    /**
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getParam1(): ?string
    {
        return $this->param1;
    }

    /**
     * @return string|null
     */
    public function getParam2(): ?string
    {
        return $this->param2;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @return bool
     */
    public function isIndex(): bool
    {
        return $this->index;
    }
}
