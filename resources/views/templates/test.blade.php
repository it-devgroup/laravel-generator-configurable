@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityField[] $entityFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityRelation[]|\Illuminate\Support\Collection $relationFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerCreateFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerUpdateFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $responseFields */
@endphp
use Illuminate\Http\Response;

/**
 * Class {{ $context }}{{ $entityName }}Test
 */
class {{ $context }}{{ $entityName }}Test extends TestCase
{
@if($data->getControllerList()->isEnable())
    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestListResult()
    {
        $token = $this->signIn{{ $context }}();

        $this->json(
            self::METHOD_GET,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.list'),
            [],
            $this->getHeaders($token)
        )->seeJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
                            '{{ $field->getVariable() }}',
@endforeach
                        ],
@php $relationEnable = false; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@if(!$relationEnable)
                        'relationships' => [
@endif
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
                            '{{ $field->getVariable() }}' => [
                                'data' => [
                                    [
                                        'id' => 1,
                                        'type' => '{{ $field->getRelationEntity() }}',
                                        'attributes' => [
                                        ]
                                    ]
                                ]
                            ],
@else
                            '{{ $field->getVariable() }}' => [
                                'data' => [
                                    'id' => 1,
                                    'type' => '{{ $field->getRelationEntity() }}',
                                    'attributes' => [
                                    ]
                                ]
                            ],
@endif
@php $relationEnable = true; @endphp
@endforeach
@if($relationEnable)
                        ],
@endif
                    ]
                ]
            ]
        )->seeJsonStructure(
            self::ERROR_MESSAGE_STRUCTURE_LIST_SUCCESS
        )->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestFilterSuccess()
    {
        $token = $this->signIn{{ $context }}();

        $this->json(
            self::METHOD_GET,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.list'),
            [],
            $this->getHeaders($token)
        )->seeJsonContains(
            [
                'meta' => [
                    'totalPages' => 1,
                    'totalItems' => {{ $data->getSeeder()->isEnable() ? $data->getSeeder()->getCountRows() : 0 }}
                ]
            ]
        )->assertResponseStatus(Response::HTTP_OK);
        $this->assertCount({{ $data->getSeeder()->isEnable() ? $data->getSeeder()->getCountRows() : 0 }}, $this->lastResponse()['data']);
    }
@endif
@if($data->getControllerById()->isEnable())
@if($data->getControllerList()->isEnable())

@endif
    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestByIdResult()
    {
        $token = $this->signIn{{ $context }}();

        $this->json(
            self::METHOD_GET,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.get', ['id' => 1]),
            [
            ],
            $this->getHeaders($token)
        )->seeJsonStructure(
            [
                'data' => [
                    'id',
                    'type',
                    'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
                        '{{ $field->getVariable() }}',
@endforeach
                    ],
@php $relationEnable = false; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@if(!$relationEnable)
                    'relationships' => [
@endif
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
                        '{{ $field->getVariable() }}' => [
                            'data' => [
                                [
                                    'id' => 1,
                                    'type' => '{{ $field->getRelationEntity() }}',
                                    'attributes' => [
                                    ]
                                ]
                            ]
                        ],
@else
                        '{{ $field->getVariable() }}' => [
                            'data' => [
                                'id' => 1,
                                'type' => '{{ $field->getRelationEntity() }}',
                                'attributes' => [
                                ]
                            ]
                        ],
@endif
@php $relationEnable = true; @endphp
@endforeach
@if($relationEnable)
                    ],
@endif
                ]
            ]
        )->assertResponseStatus(Response::HTTP_OK);

        $this->json(
            self::METHOD_GET,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.get', ['id' => 100]),
            [
            ],
            $this->getHeaders($token)
        )->seeJsonStructure(
            self::ERROR_MESSAGE_STRUCTURE
        )->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
@endif
@if($data->getControllerCreate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable())

@endif
@php $listFields = collect(); @endphp
@foreach($controllerCreateFields as $field)
@switch($field->getType())
@case('int')
@php $listFields->put($field->getVariable(), ['value' => 2]); @endphp
@break
@case('float')
@php $listFields->put($field->getVariable(), ['value' => 10.01]); @endphp
@break
@case('Carbon')
@php $listFields->put($field->getVariable(), ['value' => \Carbon\Carbon::now()->format('Y-m-d')]); @endphp
@break
@case('bool')
@php $listFields->put($field->getVariable(), ['value' => 'false']); @endphp
@break
@default
@php $listFields->put($field->getVariable(), ['value' => \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') . ' new']); @endphp
@break
@endswitch
@endforeach
    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestCreateSuccess()
    {
        $token = $this->signIn{{ $context }}();

        $this->json(
            self::METHOD_POST,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.create'),
            [
@foreach($controllerCreateFields as $field)
@if(!$field->isRequired())
@continue
@endif
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endforeach
            ],
            $this->getHeaders($token)
        )->seeJsonContains(
            [
                'id' => {{ $data->getSeeder()->isEnable() ? (int)$data->getSeeder()->getCountRows() + 1 : 1 }},
                'type' => '{{ $entityName }}',
                'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
@if($field->isMultiLanguage())
                    '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : '' }}'),
@continue
@endif
@switch($field->getType())
@case('int')
@case('float')
@case('bool')
                    '{{ $field->getVariable() }}' => {{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : 0 }},
@break
@case('Carbon')
                    '{{ $field->getVariable() }}' => '{{ \Carbon\Carbon::now()->setTime(15, 0, 0)->toDateTimeString() }}',
@break
@default
                    '{{ $field->getVariable() }}' => {!! $listFields->get($field->getVariable()) ? "'" . $listFields[$field->getVariable()]['value'] . "'" : 'null' !!},
@break
@endswitch
@endforeach
                ]
            ]
        )->assertResponseStatus(Response::HTTP_OK);

        $this->json(
            self::METHOD_POST,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.create'),
            [
@foreach($controllerCreateFields as $field)
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endforeach
            ],
            $this->getHeaders($token)
        )->seeJsonContains(
            [
                'id' => {{ $data->getSeeder()->isEnable() ? (int)$data->getSeeder()->getCountRows() + 2 : 2 }},
                'type' => '{{ $entityName }}',
                'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
@if($field->isMultiLanguage())
                    '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : '' }}'),
@continue
@endif
@switch($field->getType())
@case('int')
@case('float')
@case('bool')
                    '{{ $field->getVariable() }}' => {{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : 0 }},
@break
@case('Carbon')
                    '{{ $field->getVariable() }}' => '{{ \Carbon\Carbon::now()->setTime(15, 0, 0)->toDateTimeString() }}',
@break
@default
                    '{{ $field->getVariable() }}' => {!! $listFields->get($field->getVariable()) ? "'" . $listFields[$field->getVariable()]['value'] . "'" : 'null' !!},
@break
@endswitch
@endforeach
                ],
@php $relationEnable = false; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation() || !$listFields->get($field->getVariable()))
@continue
@endif
@if(!$relationEnable)
                'relationships' => [
@endif
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
                    '{{ $field->getVariable() }}' => [
                        'data' => [
                            [
                                'id' => 1,
                                'type' => '{{ $field->getRelationEntity() }}',
                                'attributes' => [
                                ]
                            ]
                        ]
                    ],
@else
                    '{{ $field->getVariable() }}' => [
                        'data' => [
                            'id' => 1,
                            'type' => '{{ $field->getRelationEntity() }}',
                            'attributes' => [
                            ]
                        ]
                    ],
@endif
@php $relationEnable = true; @endphp
@endforeach
@if($relationEnable)
                ],
@endif
            ]
        )->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestCreateError()
    {
        $this->signIn{{ $context }}();

        $data = [
@foreach($controllerCreateFields as $fieldIterable)
@if(!$fieldIterable->isRequired())
@continue
@endif
            [
@foreach($controllerCreateFields as $field)
@if(!$field->isRequired())
@continue
@endif
@if($field->getVariable() == $fieldIterable->getVariable())
                '{{ $field->getVariable() }}' => '',
@else
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endif
@endforeach
                'errorFieldName' => '{{ $fieldIterable->getVariable() }}',
            ],
@endforeach
        ];
        $this->fieldsValidateTest(self::METHOD_POST, route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.create'), $data);
    }
@endif
@if($data->getControllerUpdate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable() || $data->getControllerCreate()->isEnable())

@endif
@php $listFields = collect(); @endphp
@foreach($controllerUpdateFields as $field)
@switch($field->getType())
@case('int')
@php $listFields->put($field->getVariable(), ['value' => 2]); @endphp
@break
@case('float')
@php $listFields->put($field->getVariable(), ['value' => 10.01]); @endphp
@break
@case('Carbon')
@php $listFields->put($field->getVariable(), ['value' => \Carbon\Carbon::now()->format('Y-m-d')]); @endphp
@break
@case('bool')
@php $listFields->put($field->getVariable(), ['value' => 'false']); @endphp
@break
@default
@php $listFields->put($field->getVariable(), ['value' => \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') . ' upd']); @endphp
@break
@endswitch
@endforeach
    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestUpdateSuccess()
    {
        $token = $this->signIn{{ $context }}();

        $this->json(
            self::METHOD_PUT,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.update', ['id' => 1]),
            [
@foreach($controllerUpdateFields as $field)
@if(!$field->isRequired())
@continue
@endif
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endforeach
            ],
            $this->getHeaders($token)
        )->seeJsonContains(
            [
                'id' => 1,
                'type' => '{{ $entityName }}',
                'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
@if($field->isMultiLanguage())
                    '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : '' }}'),
@continue
@endif
@switch($field->getType())
@case('int')
@case('float')
@case('bool')
                    '{{ $field->getVariable() }}' => {{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : 0 }},
@break
@case('Carbon')
                    '{{ $field->getVariable() }}' => '{{ \Carbon\Carbon::now()->setTime(15, 0, 0)->toDateTimeString() }}',
@break
@default
                    '{{ $field->getVariable() }}' => {!! $listFields->get($field->getVariable()) ? "'" . $listFields[$field->getVariable()]['value'] . "'" : 'null' !!},
@break
@endswitch
@endforeach
                ],
            ]
        )->assertResponseStatus(Response::HTTP_OK);

        $this->json(
            self::METHOD_PUT,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.update', ['id' => 1]),
            [
@foreach($controllerUpdateFields as $field)
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
@switch($field->getType())
@case('int')
@case('float')
                '{{ $field->getVariable() }}' => {{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : 0 }},
@break
@case('bool')
                '{{ $field->getVariable() }}' => true,
@break
@case('Carbon')
                '{{ $field->getVariable() }}' => '{{ \Carbon\Carbon::now()->format('Y-m-d') }}',
@break
@default
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@break
@endswitch
@endif
@endforeach
            ],
            $this->getHeaders($token)
        )->seeJsonContains(
            [
                'id' => 1,
                'type' => '{{ $entityName }}',
                'attributes' => [
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
@if($field->isMultiLanguage())
                    '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : '' }}'),
@continue
@endif
@switch($field->getType())
@case('int')
@case('float')
                    '{{ $field->getVariable() }}' => {{ $listFields->get($field->getVariable()) ? $listFields[$field->getVariable()]['value'] : 0 }},
@break
@case('bool')
                    '{{ $field->getVariable() }}' => true,
@break
@case('Carbon')
                    '{{ $field->getVariable() }}' => {{ \Carbon\Carbon::now()->setTime(15, 0, 0)->toDateTimeString() }},
@break
@default
                    '{{ $field->getVariable() }}' => {!! $listFields->get($field->getVariable()) ? "'" . $listFields[$field->getVariable()]['value'] . "'" : 'null' !!},
@break
@endswitch
@endforeach
                ],
@php $relationEnable = false; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation() || !$listFields->get($field->getVariable()))
@continue
@endif
@if(!$relationEnable)
                'relationships' => [
@endif
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
                    '{{ $field->getVariable() }}' => [
                        'data' => [
                            [
                                'id' => 1,
                                'type' => '{{ $field->getRelationEntity() }}',
                                'attributes' => [
                                ]
                            ]
                        ]
                    ],
@else
                    '{{ $field->getVariable() }}' => [
                        'data' => [
                            'id' => 1,
                            'type' => '{{ $field->getRelationEntity() }}',
                            'attributes' => [
                            ]
                        ]
                    ],
@endif
@php $relationEnable = true; @endphp
@endforeach
@if($relationEnable)
                ],
@endif
            ]
        )->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestUpdateError()
    {
        $token = $this->signIn{{ $context }}();

        $data = [
@foreach($controllerUpdateFields as $fieldIterable)
@if(!$fieldIterable->isRequired())
@continue
@endif
            [
@foreach($controllerUpdateFields as $field)
@if(!$field->isRequired())
@continue
@endif
@if($field->getVariable() == $fieldIterable->getVariable())
                '{{ $field->getVariable() }}' => '',
@else
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endif
@endforeach
                'errorFieldName' => '{{ $fieldIterable->getVariable() }}',
            ],
@endforeach
        ];
        $this->fieldsValidateTest(
            self::METHOD_PUT,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.update', ['id' => 1]),
            $data
        );

        $this->json(
            self::METHOD_PUT,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.update', ['id' => 100]),
            [
@foreach($controllerUpdateFields as $field)
@if(!$field->isRequired())
@continue
@endif
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => $this->getLocalizationData('{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}'),
@else
                '{{ $field->getVariable() }}' => '{{ $listFields->get($field->getVariable()) ? $listFields->get($field->getVariable())['value'] : '' }}',
@endif
@endforeach
            ],
            $this->getHeaders($token)
        )->seeJsonStructure(
            self::ERROR_MESSAGE_STRUCTURE
        )->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
@endif
@if($data->getControllerDelete()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable() || $data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable())

@endif
    /**
     * {{ '@' }}test
     */
    public function {{ $contextLower }}{{ $entityName }}TestDeleteResult()
    {
        $token = $this->signIn{{ $context }}();

        $this->seeInDatabase('{{ $data->getEntity()->getTable() }}', ['id' => 1]);
        $this->json(
            self::METHOD_DELETE,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.delete', ['id' => 1]),
            [],
            $this->getHeaders($token)
        )->assertResponseStatus(Response::HTTP_NO_CONTENT);
        $this->notSeeInDatabase('{{ $data->getEntity()->getTable() }}', ['id' => 1]);

        $this->json(
            self::METHOD_DELETE,
            route('{{ $contextLower }}.{{ $entityNameRouteAlias }}.delete', ['id' => 100]),
            [],
            $this->getHeaders($token)
        )->seeJsonStructure(
            self::ERROR_MESSAGE_STRUCTURE
        )->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
@endif
}
