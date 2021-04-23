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
                        'middleware' => [
                            'permission:{{ $data->getRoute()->getFilename() }}_{{ \Illuminate\Support\Str::of($entityNameRouteAlias)->replace('.', '_') }}_view'
                        ]
                    ]
                );
@endif
@if($data->getControllerById()->isEnable())
                $router->get(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.get',
                        'uses' => '{{ $entityName }}Controller@get',
                        'middleware' => [
                            'permission:{{ $data->getRoute()->getFilename() }}_{{ \Illuminate\Support\Str::of($entityNameRouteAlias)->replace('.', '_') }}_view'
                        ]
                    ]
                );
@endif
@if($data->getControllerCreate()->isEnable())
                $router->post(
                    '/',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.create',
                        'uses' => '{{ $entityName }}Controller@create',
                        'middleware' => [
                            'permission:{{ $data->getRoute()->getFilename() }}_{{ \Illuminate\Support\Str::of($entityNameRouteAlias)->replace('.', '_') }}_create'
                        ]
                    ]
                );
@endif
@if($data->getControllerUpdate()->isEnable())
                $router->put(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.update',
                        'uses' => '{{ $entityName }}Controller@update',
                        'middleware' => [
                            'permission:{{ $data->getRoute()->getFilename() }}_{{ \Illuminate\Support\Str::of($entityNameRouteAlias)->replace('.', '_') }}_update'
                        ]
                    ]
                );
@endif
@if($data->getControllerDelete()->isEnable())
                $router->delete(
                    '/{id:[0-9]+}',
                    [
                        'as' => '{{ $entityNameRouteAlias }}.delete',
                        'uses' => '{{ $entityName }}Controller@delete',
                        'middleware' => [
                            'permission:{{ $data->getRoute()->getFilename() }}_{{ \Illuminate\Support\Str::of($entityNameRouteAlias)->replace('.', '_') }}_delete'
                        ]
                    ]
                );
@endif
            }
        );
*/
