@php
    /** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerUpdateFields */
@endphp
namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
@foreach($useCommonForUpdate as $use)
use {{ $use }};
@endforeach
@foreach($useEntityForUpdate as $use)
use App\Domain\{{ $use }}\{{ $use }};
@endforeach

/**
 * Class Update{{ $entityName }}
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Update{{ $entityName }} implements Command
{
    /**
     * {{ '@' }}var int
     */
    private int $id;
@foreach($controllerUpdateFields as $field)
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
     * Update{{ $entityName }} constructor.
     * {{ '@' }}param int $id
@foreach($controllerUpdateFields as $field)
@if($field->isMultiLanguage())
     * {{ '@' }}param array{{ $field->isNullable() ? '|null' : '' }} ${{ $field->getVariable() }}
@else
     * {{ '@' }}param @if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif{{ ($field->isNullable()) ? '|null' : '' }} ${{ $field->getVariable() }}
@endif
@endforeach
     */
    public function __construct(
        int $id,
@foreach($controllerUpdateFields as $index => $field)
@if($field->isMultiLanguage())
        {{ $field->isNullable() ? '?' : '' }}@if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ 'array' }}@endif ${{ $field->getVariable() }}{{ count($controllerUpdateFields) - 1 != $index ? ',' : '' }}
@else
        {{ $field->isNullable() ? '?' : '' }}@if($field->isRelation()){{ $field->getRelationEntity() }}@else{{ $field->getType() }}@endif ${{ $field->getVariable() }}{{ count($controllerUpdateFields) - 1 != $index ? ',' : '' }}
@endif
@endforeach
    ) {
        $this->id = $id;
@foreach($controllerUpdateFields as $index => $field)
        $this->{{ $field->getVariable() }} = ${{ $field->getVariable() }};
@endforeach
    }

    /**
     * {{ '@' }}return int
     */
    public function getId(): int
    {
        return $this->id;
    }

@foreach($controllerUpdateFields as $index => $field)
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
