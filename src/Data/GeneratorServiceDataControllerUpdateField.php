<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataControllerUpdateField
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataControllerUpdateField
{
    /**
     * @var string|null
     */
    private ?string $variable;
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
    private ?string $field;
    /**
     * @var bool
     */
    private bool $required;
    /**
     * @var bool
     */
    private bool $nullable;
    /**
     * @var bool
     */
    private bool $multiLanguage;
    /**
     * @var bool
     */
    private bool $entityEnable;
    /**
     * @var string|null
     */
    private ?string $entity;

    /**
     * @param string|null $variable
     * @param string|null $originalType
     * @param string|null $textFormatType
     * @param string|null $type
     * @param string|null $field
     * @param bool $required
     * @param bool $nullable
     * @param bool $multiLanguage
     * @param bool $entityEnable
     * @param string|null $entity
     * @return self
     */
    public static function register(
        ?string $variable,
        ?string $originalType,
        ?string $textFormatType,
        ?string $type,
        ?string $field,
        bool $required,
        bool $nullable,
        bool $multiLanguage,
        bool $entityEnable,
        ?string $entity
    ): self {
        $model = (new self());
        $model->variable = $variable;
        $model->originalType = $originalType;
        $model->textFormatType = $textFormatType;
        $model->type = $type;
        $model->field = $field;
        $model->required = $required;
        $model->nullable = $nullable;
        $model->multiLanguage = $multiLanguage;
        $model->entityEnable = $entityEnable;
        $model->entity = $entity;

        return $model;
    }

    /**
     * @return string|null
     */
    public function getVariable(): ?string
    {
        return $this->variable;
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
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
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
    public function isMultiLanguage(): bool
    {
        return $this->multiLanguage;
    }

    /**
     * @return bool
     */
    public function isEntityEnable(): bool
    {
        return $this->entityEnable;
    }

    /**
     * @return string|null
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }
}
