<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataFieldData
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataFieldData
{
    /**
     * @var string
     */
    private string $field;
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
     * @var bool
     */
    private bool $multiLanguage;
    /**
     * @var bool
     */
    private bool $relation;
    /**
     * @var string|null
     */
    private ?string $relationType;
    /**
     * @var string|null
     */
    private ?string $relationEntity;
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
    private bool $sortable;

    /**
     * @param string $field
     * @param string|null $variable
     * @param string|null $originalType
     * @param string|null $textFormatType
     * @param string|null $type
     * @param bool $multiLanguage
     * @param bool $relation
     * @param string|null $relationType
     * @param string|null $relationEntity
     * @param bool $required
     * @param bool $nullable
     * @param bool $sortable
     * @return self
     */
    public static function register(
        string $field,
        ?string $variable,
        ?string $originalType,
        ?string $textFormatType,
        ?string $type,
        bool $multiLanguage,
        bool $relation,
        ?string $relationType,
        ?string $relationEntity,
        bool $required,
        bool $nullable,
        bool $sortable
    ): self {
        $model = (new self());
        $model->field = $field;
        $model->variable = $variable;
        $model->originalType = $originalType;
        $model->textFormatType = $textFormatType;
        $model->type = $type;
        $model->multiLanguage = $multiLanguage;
        $model->relation = $relation;
        $model->relationType = $relationType;
        $model->relationEntity = $relationEntity;
        $model->required = $required;
        $model->nullable = $nullable;
        $model->sortable = $sortable;

        return $model;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * @return string|null
     */
    public function getVariable(): ?string
    {
        return $this->variable;
    }

    /**
     * @param string|null $variable
     */
    public function setVariable(?string $variable): void
    {
        $this->variable = $variable;
    }

    /**
     * @return string|null
     */
    public function getOriginalType(): ?string
    {
        return $this->originalType;
    }

    /**
     * @param string|null $originalType
     */
    public function setOriginalType(?string $originalType): void
    {
        $this->originalType = $originalType;
    }

    /**
     * @return string|null
     */
    public function getTextFormatType(): ?string
    {
        return $this->textFormatType;
    }

    /**
     * @param string|null $textFormatType
     */
    public function setTextFormatType(?string $textFormatType): void
    {
        $this->textFormatType = $textFormatType;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isMultiLanguage(): bool
    {
        return $this->multiLanguage;
    }

    /**
     * @param bool $multiLanguage
     */
    public function setMultiLanguage(bool $multiLanguage): void
    {
        $this->multiLanguage = $multiLanguage;
    }

    /**
     * @return bool
     */
    public function isRelation(): bool
    {
        return $this->relation;
    }

    /**
     * @param bool $relation
     */
    public function setRelation(bool $relation): void
    {
        $this->relation = $relation;
    }

    /**
     * @return string|null
     */
    public function getRelationType(): ?string
    {
        return $this->relationType;
    }

    /**
     * @param string|null $relationType
     */
    public function setRelationType(?string $relationType): void
    {
        $this->relationType = $relationType;
    }

    /**
     * @return string|null
     */
    public function getRelationEntity(): ?string
    {
        return $this->relationEntity;
    }

    /**
     * @param string|null $relationEntity
     */
    public function setRelationEntity(?string $relationEntity): void
    {
        $this->relationEntity = $relationEntity;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     */
    public function setNullable(bool $nullable): void
    {
        $this->nullable = $nullable;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param bool $sortable
     */
    public function setSortable(bool $sortable): void
    {
        $this->sortable = $sortable;
    }
}
