@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $responseFields */
@endphp
namespace App\Http\Resources\{{ $entityName }};

use App\Domain\{{ $entityName }}\{{ $entityName }};
use App\Http\Resources\BaseResource;
@foreach($responseFields as $index => $field)
@if($field->isMultiLanguage())
use App\Helpers\Language\LanguageHelper;
@break
@endif
@endforeach
@php $available = []; @endphp
@foreach($responseFields as $index => $field)
@if(!$field->isRelation() || in_array($field->getRelationEntity(), $available))
@continue
@endif
@php $available[] = $field->getRelationEntity(); @endphp
use App\Http\Resources\{{ $field->getRelationEntity() }}\{{ $field->getRelationEntity() }}Resource;
@endforeach

/**
 * Class {{ $entityName }}Resource
 * {{ '@' }}package App\Http\Resources\{{ $entityName }}
 */
class {{ $entityName }}Resource extends BaseResource
{
    /**
     * @inheritDoc
     */
    public function data()
    {
        /** {{ '@' }}var {{ $entityName }} ${{ \Illuminate\Support\Str::camel($entityName) }} */
        ${{ \Illuminate\Support\Str::camel($entityName) }} = $this->resource;

@php $relationCount = 0; @endphp
@foreach($responseFields as $index => $field)
@if($field->isRelation())
@php $relationCount++; @endphp
@endif
@endforeach
@if($relationCount)
        $data = [
@else
        return [
@endif
            'id' => ${{ \Illuminate\Support\Str::camel($entityName) }}->id,
            'type' => '{{ $entityName }}',
            'attributes' => [
@foreach($responseFields as $index => $field)
@if($field->isRelation())
@continue
@endif
@if($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => LanguageHelper::localizationData(
                    ${{ \Illuminate\Support\Str::camel($entityName) }}->getTranslations('{{ $field->getField() }}')
                ),
@else
                '{{ $field->getVariable() }}' => ${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getField() }},
@endif
@endforeach
            ],
        ];
@if($relationCount)

@endif
@foreach($responseFields as $index => $field)
@if(!$field->isRelation())
@continue
@endif
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
        if (${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getVariable() }}()->count()) {
            $list = [];
            foreach (${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getVariable() }} as ${{ \Illuminate\Support\Str::singular($field->getVariable()) }}) {
                $list[] = new {{ $field->getRelationEntity() }}Resource(${{ \Illuminate\Support\Str::singular($field->getVariable()) }});
            }
            $data = array_merge_recursive(
                $data,
                [
                    'relationships' => [
                        '{{ $field->getVariable() }}' => [
                            'data' => $list
                        ]
                    ]
                ]
            );
        }
@else
        if (${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getVariable() }}) {
            $data = array_merge_recursive(
                $data,
                [
                    'relationships' => [
                        '{{ $field->getVariable() }}' => [
                            'data' => new {{ $field->getRelationEntity() }}Resource(${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getVariable() }})
                        ]
                    ]
                ]
            );
        }
@endif
@if($relationCount)

@endif
@endforeach
@if($relationCount)
        return $data;
@endif
    }
}
