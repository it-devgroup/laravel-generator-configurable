<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataConfig
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataConfig
{
    /**
     * @var string|null
     */
    private ?string $contextController;
    /**
     * @var string|null
     */
    private ?string $contextTest;
    /**
     * @var string|null
     */
    private ?string $contextApiDoc;

    /**
     * @param string|null $contextController
     * @param string|null $contextTest
     * @param string|null $contextApiDoc
     * @return self
     */
    public static function register(
        ?string $contextController,
        ?string $contextTest,
        ?string $contextApiDoc
    ): self {
        $model = (new self());
        $model->contextController = $contextController;
        $model->contextTest = $contextTest;
        $model->contextApiDoc = $contextApiDoc;

        return $model;
    }

    /**
     * @return string|null
     */
    public function getContextController(): ?string
    {
        return $this->contextController;
    }

    /**
     * @return string|null
     */
    public function getContextTest(): ?string
    {
        return $this->contextTest;
    }

    /**
     * @return string|null
     */
    public function getContextApiDoc(): ?string
    {
        return $this->contextApiDoc;
    }
}
