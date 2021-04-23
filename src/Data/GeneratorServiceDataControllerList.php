<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataControllerList
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataControllerList
{
    /**
     * @var bool
     */
    private bool $enable;

    /**
     * @param bool $enable
     * @return self
     */
    public static function register(
        bool $enable
    ): self {
        $model = (new self());
        $model->enable = $enable;

        return $model;
    }

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }
}
