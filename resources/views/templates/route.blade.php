@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
@endphp
/**
        $router->group(
            ['prefix' => '{{ $prefix }}'],
            function (Router $router) {
@if($data->getControllerList()->isEnable())
                $router->get(
                    '/',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.list',
                        'uses' => '{{ $entityName }}Controller@list',
                    ]
                );
@endif
@if($data->getControllerById()->isEnable())
                $router->get(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.get',
                        'uses' => '{{ $entityName }}Controller@get',
                    ]
                );
@endif
@if($data->getControllerCreate()->isEnable())
                $router->post(
                    '/',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.create',
                        'uses' => '{{ $entityName }}Controller@create',
                    ]
                );
@endif
@if($data->getControllerUpdate()->isEnable())
                $router->put(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.update',
                        'uses' => '{{ $entityName }}Controller@update',
                    ]
                );
@endif
@if($data->getControllerDelete()->isEnable())
                $router->delete(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.delete',
                        'uses' => '{{ $entityName }}Controller@delete',
                    ]
                );
@endif
            }
        );
*/
