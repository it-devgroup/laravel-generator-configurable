<?php

namespace ItDevgroup\LaravelGeneratorConfigurable\Http\Controllers;

use ItDevgroup\LaravelGeneratorConfigurable\GeneratorServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class ControllerTrait
 * @package ItDevgroup\LaravelGeneratorConfigurable\Http\Controllers
 */
trait ControllerTrait
{
    /**
     * @var GeneratorServiceInterface
     */
    private GeneratorServiceInterface $generatorService;

    /**
     * GeneratorController constructor.
     * @param GeneratorServiceInterface $generatorService
     */
    public function __construct(
        GeneratorServiceInterface $generatorService
    ) {
        $this->generatorService = $generatorService;
    }

    /**
     * @return View
     */
    public function page(): View
    {
        return view('generator::page');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function check(Request $request): Response
    {
        return new Response(
            ['data' => $this->generatorService->generateFileList($request->all(), true)],
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function generate(Request $request): Response
    {
        $this->generatorService->generateFiles($request->all());

        return new Response(
            [],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @return Response
     */
    public function sets(): Response
    {
        $list = $this->generatorService->setsList();

        return new Response(
            ['data' => $list],
            Response::HTTP_OK
        );
    }
}
