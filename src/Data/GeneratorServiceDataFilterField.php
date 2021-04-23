<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFilterField
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFilterField
{
    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var string|null
     */
    private ?string $originalType;
    /**
     * @var string|null
     */
    private ?string $textFormatType;
    /**
     * @var string|null
     */
    private ?string $type;
    /**
     * @var string|null
     */
    private ?string $operator;
    /**
     * @var string|null
     */
    private ?string $field;

    /**
     * @param string|null $name
     * @param string|null $originalType
     * @param string|null $textFormatType
     * @param string|null $type
     * @param string|null $operator
     * @param string|null $field
     * @return self
     */
    public static function register(
        ?string $name,
        ?string $originalType,
        ?string $textFormatType,
        ?string $type,
        ?string $operator,
        ?string $field
    ): self {
        $model = (new self());
        $model->name = $name;
        $model->originalType = $originalType;
        $model->textFormatType = $textFormatType;
        $model->type = $type;
        $model->operator = $operator;
        $model->field = $field;

        return $model;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getOriginalType(): ?string
    {
        return $this->originalType;
    }

    /**
     * @return string|null
     */
    public function getTextFormatType(): ?string
    {
        return $this->textFormatType;
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
    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }
}
