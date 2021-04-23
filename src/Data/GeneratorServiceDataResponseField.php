<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataResponseField
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataResponseField
{
    /**
     * @var string|null
     */
    private ?string $variable;
    /**
     * @var string|null
     */
    private ?string $field;
    /**
     * @var bool
     */
    private bool $multiLanguage;

    /**
     * @param string|null $variable
     * @param string|null $field
     * @param bool $multiLanguage
     * @return self
     */
    public static function register(
        ?string $variable,
        ?string $field,
        bool $multiLanguage
    ): self {
        $model = (new self());
        $model->variable = $variable;
        $model->field = $field;
        $model->multiLanguage = $multiLanguage;

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
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return bool
     */
    public function isMultiLanguage(): bool
    {
        return $this->multiLanguage;
    }
}
