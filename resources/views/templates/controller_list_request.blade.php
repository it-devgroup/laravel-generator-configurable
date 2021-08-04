@php
/** @var ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
@endphp
namespace App\Http\Requests\{{ $entityName }};

use Pearl\RequestValidate\RequestAbstract;

/**
 * Class {{ $entityName }}RequestList
 * {{ '@' }}package App\Http\Requests\{{ $entityName }}
 */
class {{ $entityName }}RequestList extends RequestAbstract
{
    /**
     * {{ '@' }}return array
     */
    public function rules(): array
    {
        return [
@foreach($data->getFilter()->getFields() as $field)
@switch($field->getType())
@case('float')
            'filter.{{ $field->getName() }}' => 'nullable|numeric',
@break
@case('Carbon')
            'filter.{{ $field->getName() }}' => 'nullable|date_format:Y-m-d',
@break
@default
            'filter.{{ $field->getName() }}' => 'nullable|{{ $field->getOriginalType() }}',
@endswitch
@endforeach
            'page.size' => 'nullable|integer',
            'page.number' => 'nullable|integer',
            'sort' => 'nullable|string',
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
