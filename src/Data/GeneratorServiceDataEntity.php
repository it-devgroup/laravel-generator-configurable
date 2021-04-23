<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceDataEntity
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceDataEntity
{
    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var string|null
     */
    private ?string $table;
    /**
     * @var bool|null
     */
    private ?bool $deletedAt;
    /**
     * @var bool|null
     */
    private ?bool $createdAt;
    /**
     * @var bool|null
     */
    private ?bool $updatedAt;
    /**
     * @var GeneratorServiceDataEntityField[]|null
     */
    private ?array $fields;
    /**
     * @var GeneratorServiceDataEntityRelation[]|null
     */
    private ?array $relations;

    /**
     * @param string|null $name
     * @param string|null $table
     * @param bool|null $deletedAt
     * @param bool|null $createdAt
     * @param bool|null $updatedAt
     * @param array|null $fields
     * @param array|null $relations
     * @return self
     */
    public static function register(
        ?string $name,
        ?string $table,
        ?bool $deletedAt,
        ?bool $createdAt,
        ?bool $updatedAt,
        ?array $fields,
        ?array $relations
    ): self {
        $model = (new self());
        $model->name = $name;
        $model->table = $table;
        $model->deletedAt = $deletedAt;
        $model->createdAt = $createdAt;
        $model->updatedAt = $updatedAt;
        $model->fields = $fields;
        $model->relations = $relations;

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
    public function getTable(): ?string
    {
        return $this->table;
    }

    /**
     * @return bool|null
     */
    public function getDeletedAt(): ?bool
    {
        return $this->deletedAt;
    }

    /**
     * @return bool|null
     */
    public function getCreatedAt(): ?bool
    {
        return $this->createdAt;
    }

    /**
     * @return bool|null
     */
    public function getUpdatedAt(): ?bool
    {
        return $this->updatedAt;
    }

    /**
     * @return GeneratorServiceDataEntityField[]|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }

    /**
     * @return GeneratorServiceDataEntityRelation[]|null
     */
    public function getRelations(): ?array
    {
        return $this->relations;
    }
}
