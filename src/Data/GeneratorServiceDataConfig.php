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
     * @var string|null
     */
    private ?string $sets;

    /**
     * @param string|null $contextController
     * @param string|null $contextTest
     * @param string|null $contextApiDoc
     * @param string|null $sets
     * @return self
     */
    public static function register(
        ?string $contextController,
        ?string $contextTest,
        ?string $contextApiDoc,
        ?string $sets
    ): self {
        $model = (new self());
        $model->contextController = $contextController;
        $model->contextTest = $contextTest;
        $model->contextApiDoc = $contextApiDoc;
        $model->sets = $sets;

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

    /**
     * @return string|null
     */
    public function getSets(): ?string
    {
        return $this->sets;
    }
}
