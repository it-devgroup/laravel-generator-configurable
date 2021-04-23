<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataEntityField
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataEntityField
{
    /**
     * @var string|null
     */
    private ?string $field;
    /**
     * @var string|null
     */
    private ?string $originType;
    /**
     * @var string|null
     */
    private ?string $textFormatType;
    /**
     * @var string|null
     */
    private ?string $type;
    /**
     * @var bool
     */
    private bool $multiLanguage;
    /**
     * @var bool
     */
    private bool $nullable;
    /**
     * @var bool
     */
    private bool $sortable;

    /**
     * @param string|null $field
     * @param string|null $originType
     * @param string|null $textFormatType
     * @param string|null $type
     * @param bool $multiLanguage
     * @param bool $nullable
     * @param bool $sortable
     * @return self
     */
    public static function register(
        ?string $field,
        ?string $originType,
        ?string $textFormatType,
        ?string $type,
        bool $multiLanguage,
        bool $nullable,
        bool $sortable
    ): self {
        $model = (new self());
        $model->field = $field;
        $model->originType = $originType;
        $model->textFormatType = $textFormatType;
        $model->type = $type;
        $model->multiLanguage = $multiLanguage;
        $model->nullable = $nullable;
        $model->sortable = $sortable;

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
    public function getOriginType(): ?string
    {
        return $this->originType;
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
     * @return bool
     */
    public function isMultiLanguage(): bool
    {
        return $this->multiLanguage;
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
    public function isSortable(): bool
    {
        return $this->sortable;
    }
}
