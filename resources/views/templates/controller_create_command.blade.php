@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerCreateFields */
@endphp
namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
@foreach($useCommonForCreate as $use)
use {{ $use }};
@endforeach
@foreach($useEntityForCreate as $use)
use App\Domain\{{ $use }}\{{ $use }};
@endforeach

/**
 * Class Register{{ $entityName }}
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Register{{ $entityName }} implements Command
{
@foreach($controllerCreateFields as $field)
@if($field->isMultiLanguage())
    /**
     * {{ '@' }}var array{{ $field->isNullable() ? '|null' : '' }}
     */
    private {{ $field->isNullable() ? '?' : '' }}array ${{ $field->getVariable() }};
@else
    /**
     * {{ '@' }}var @if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif{{ $field->isNullable() ? '|null' : '' }}
     */
    private {{ $field->isNullable() ? '?' : '' }}@if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif ${{ $field->getVariable() }};
@endif
@endforeach

    /**
     * Register{{ $entityName }} constructor.
@foreach($controllerCreateFields as $field)
@if($field->isMultiLanguage())
     * {{ '@' }}param array{{ $field->isNullable() ? '|null' : '' }} ${{ $field->getVariable() }}
@else
     * {{ '@' }}param @if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif{{ ($field->isNullable()) ? '|null' : '' }} ${{ $field->getVariable() }}
@endif
@endforeach
     */
    public function __construct(
@foreach($controllerCreateFields as $index => $field)
@if($field->isMultiLanguage())
        {{ $field->isNullable() ? '?' : '' }}@if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ 'array' }}@endif ${{ $field->getVariable() }}{{ count($controllerCreateFields) - 1 != $index ? ',' : '' }}
@else
        {{ $field->isNullable() ? '?' : '' }}@if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif ${{ $field->getVariable() }}{{ count($controllerCreateFields) - 1 != $index ? ',' : '' }}
@endif
@endforeach
    ) {
@foreach($controllerCreateFields as $index => $field)
        $this->{{ $field->getVariable() }} = ${{ $field->getVariable() }};
@endforeach
    }

@foreach($controllerCreateFields as $index => $field)
@if($index)

@endif
@if($field->isMultiLanguage())
    /**
     * {{ '@' }}return array{{ $field->isNullable() ? '|null' : '' }}
     */
    public function get{{ \Illuminate\Support\Str::ucfirst($field->getVariable()) }}(): {{ $field->isNullable() ? '?' : '' }}array
    {
        return $this->{{ $field->getVariable() }};
    }
@else
    /**
     * {{ '@' }}return @if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif{{ $field->isNullable() ? '|null' : '' }}
     */
    public function get{{ \Illuminate\Support\Str::ucfirst($field->getVariable()) }}(): {{ $field->isNullable() ? '?' : '' }}{{ $field->isRelation() ? $field->getRelationEntity() : $field->getType() }}
    {
        return $this->{{ $field->getVariable() }};
    }
@endif
@endforeach
}
