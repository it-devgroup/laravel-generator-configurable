<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Data;

/**
 * Class GeneratorServiceData
 * @package ItDevgroup\LaravelGeneratorConfigurable\Data
 */
class GeneratorServiceData
{
    /**
     * @var GeneratorServiceDataEntity|null
     */
    private ?GeneratorServiceDataEntity $entity;
    /**
     * @var GeneratorServiceDataFilter|null
     */
    private ?GeneratorServiceDataFilter $filter;
    /**
     * @var GeneratorServiceDataMigration|null
     */
    private ?GeneratorServiceDataMigration $migration;
    /**
     * @var GeneratorServiceDataSeeder|null
     */
    private ?GeneratorServiceDataSeeder $seeder;
    /**
     * @var GeneratorServiceDataResponse|null
     */
    private ?GeneratorServiceDataResponse $response;
    /**
     * @var GeneratorServiceDataControllerCreate|null
     */
    private ?GeneratorServiceDataControllerCreate $controllerCreate;
    /**
     * @var GeneratorServiceDataControllerUpdate|null
     */
    private ?GeneratorServiceDataControllerUpdate $controllerUpdate;
    /**
     * @var GeneratorServiceDataControllerList|null
     */
    private ?GeneratorServiceDataControllerList $controllerList;
    /**
     * @var GeneratorServiceDataControllerById|null
     */
    private ?GeneratorServiceDataControllerById $controllerById;
    /**
     * @var GeneratorServiceDataControllerDelete|null
     */
    private ?GeneratorServiceDataControllerDelete $controllerDelete;
    /**
     * @var GeneratorServiceDataRoute|null
     */
    private ?GeneratorServiceDataRoute $route;
    /**
     * @var GeneratorServiceDataTest|null
     */
    private ?GeneratorServiceDataTest $test;
    /**
     * @var GeneratorServiceDataApiDoc|null
     */
    private ?GeneratorServiceDataApiDoc $apiDoc;
    /**
     * @var GeneratorServiceDataConfig|null
     */
    private ?GeneratorServiceDataConfig $config;

    /**
     * @param GeneratorServiceDataEntity $entity
     * @param GeneratorServiceDataFilter $filter
     * @param GeneratorServiceDataMigration $migration
     * @param GeneratorServiceDataSeeder $seeder
     * @param GeneratorServiceDataResponse $response
     * @param GeneratorServiceDataControllerCreate $controllerCreate
     * @param GeneratorServiceDataControllerUpdate $controllerUpdate
     * @param GeneratorServiceDataControllerList $controllerList
     * @param GeneratorServiceDataControllerById $controllerById
     * @param GeneratorServiceDataControllerDelete $controllerDelete
     * @param GeneratorServiceDataRoute $route
     * @param GeneratorServiceDataTest $test
     * @param GeneratorServiceDataApiDoc $apiDoc
     * @param GeneratorServiceDataConfig $config
     * @return self
     */
    public static function register(
        GeneratorServiceDataEntity $entity,
        GeneratorServiceDataFilter $filter,
        GeneratorServiceDataMigration $migration,
        GeneratorServiceDataSeeder $seeder,
        GeneratorServiceDataResponse $response,
        GeneratorServiceDataControllerCreate $controllerCreate,
        GeneratorServiceDataControllerUpdate $controllerUpdate,
        GeneratorServiceDataControllerList $controllerList,
        GeneratorServiceDataControllerById $controllerById,
        GeneratorServiceDataControllerDelete $controllerDelete,
        GeneratorServiceDataRoute $route,
        GeneratorServiceDataTest $test,
        GeneratorServiceDataApiDoc $apiDoc,
        GeneratorServiceDataConfig $config
    ): self {
        $model = (new self());
        $model->entity = $entity;
        $model->filter = $filter;
        $model->migration = $migration;
        $model->seeder = $seeder;
        $model->response = $response;
        $model->controllerCreate = $controllerCreate;
        $model->controllerUpdate = $controllerUpdate;
        $model->controllerList = $controllerList;
        $model->controllerById = $controllerById;
        $model->controllerDelete = $controllerDelete;
        $model->route = $route;
        $model->test = $test;
        $model->apiDoc = $apiDoc;
        $model->config = $config;

        return $model;
    }

    /**
     * @return GeneratorServiceDataEntity|null
     */
    public function getEntity(): ?GeneratorServiceDataEntity
    {
        return $this->entity;
    }

    /**
     * @return GeneratorServiceDataFilter|null
     */
    public function getFilter(): ?GeneratorServiceDataFilter
    {
        return $this->filter;
    }

    /**
     * @return GeneratorServiceDataMigration|null
     */
    public function getMigration(): ?GeneratorServiceDataMigration
    {
        return $this->migration;
    }

    /**
     * @return GeneratorServiceDataSeeder|null
     */
    public function getSeeder(): ?GeneratorServiceDataSeeder
    {
        return $this->seeder;
    }

    /**
     * @return GeneratorServiceDataResponse|null
     */
    public function getResponse(): ?GeneratorServiceDataResponse
    {
        return $this->response;
    }

    /**
     * @return GeneratorServiceDataControllerCreate|null
     */
    public function getControllerCreate(): ?GeneratorServiceDataControllerCreate
    {
        return $this->controllerCreate;
    }

    /**
     * @return GeneratorServiceDataControllerUpdate|null
     */
    public function getControllerUpdate(): ?GeneratorServiceDataControllerUpdate
    {
        return $this->controllerUpdate;
    }

    /**
     * @return GeneratorServiceDataControllerList|null
     */
    public function getControllerList(): ?GeneratorServiceDataControllerList
    {
        return $this->controllerList;
    }

    /**
     * @return GeneratorServiceDataControllerById|null
     */
    public function getControllerById(): ?GeneratorServiceDataControllerById
    {
        return $this->controllerById;
    }

    /**
     * @return GeneratorServiceDataControllerDelete|null
     */
    public function getControllerDelete(): ?GeneratorServiceDataControllerDelete
    {
        return $this->controllerDelete;
    }

    /**
     * @return GeneratorServiceDataRoute|null
     */
    public function getRoute(): ?GeneratorServiceDataRoute
    {
        return $this->route;
    }

    /**
     * @return GeneratorServiceDataTest|null
     */
    public function getTest(): ?GeneratorServiceDataTest
    {
        return $this->test;
    }

    /**
     * @return GeneratorServiceDataApiDoc|null
     */
    public function getApiDoc(): ?GeneratorServiceDataApiDoc
    {
        return $this->apiDoc;
    }

    /**
     * @return GeneratorServiceDataConfig|null
     */
    public function getConfig(): ?GeneratorServiceDataConfig
    {
        return $this->config;
    }
}
