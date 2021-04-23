<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataEntityRelation
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataEntityRelation
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
    private ?string $entity;
    /**
     * @var string|null
     */
    private ?string $table;
    /**
     * @var string|null
     */
    private ?string $foreign;
    /**
     * @var string|null
     */
    private ?string $local;

    /**
     * @param string|null $field
     * @param string|null $type
     * @param string|null $entity
     * @param string|null $table
     * @param string|null $foreign
     * @param string|null $local
     * @return self
     */
    public static function register(
        ?string $field,
        ?string $type,
        ?string $entity,
        ?string $table,
        ?string $foreign,
        ?string $local
    ): self {
        $model = (new self());
        $model->field = $field;
        $model->type = $type;
        $model->entity = $entity;
        $model->table = $table;
        $model->foreign = $foreign;
        $model->local = $local;

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
    public function getEntity(): ?string
    {
        return $this->entity;
    }

    /**
     * @return string|null
     */
    public function getTable(): ?string
    {
        return $this->table;
    }

    /**
     * @return string|null
     */
    public function getForeign(): ?string
    {
        return $this->foreign;
    }

    /**
     * @return string|null
     */
    public function getLocal(): ?string
    {
        return $this->local;
    }
}
