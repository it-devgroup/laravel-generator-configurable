@php
    /** @var ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|Illuminate\Support\Collection $controllerUpdateFields */
@endphp
namespace App\Http\Requests\{{ $entityName }};

use Pearl\RequestValidate\RequestAbstract;

/**
 * Class {{ $entityName }}RequestUpdate
 * {{ '@' }}package App\Http\Requests\{{ $entityName }}
 */
class {{ $entityName }}RequestUpdate extends RequestAbstract
{
    /**
     * {{ '@' }}return array
     */
    public function rules(): array
    {
        return [
@foreach($controllerUpdateFields as $field)
@switch($field->getType())
@case('float')
@php $type = 'numeric'; @endphp
@break
@case('Carbon')
@php $type = 'date_format:Y-m-d'; @endphp
@break
@default
@php $type = $field->getOriginalType(); @endphp
@endswitch
@if($field->isRelation())
            '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}integer|exists:App\Domain\{{ $field->getRelationEntity() }}\{{ $field->getRelationEntity() }},id',
@elseif($field->isMultiLanguage())
            '{{ $field->getVariable() }}' => 'nullable|array',
            '{{ $field->getVariable() }}.*' => 'nullable|{{ $type }}',
@if(!$field->isNullable())
            '{{ $field->getVariable() }}.' . $this->defaulLanguage() => '{{ $field->isRequired() ? 'required|' : '' }}{{ $type }}',
@endif
@else
            '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}{{ $field->isNullable() ? 'nullable|' : '' }}{{ $type }}',
@endif
@endforeach
        ];
    }

    /**
     * {{ '@' }}return array
     */
    public function messages(): array
    {
        return [];
    }
}
