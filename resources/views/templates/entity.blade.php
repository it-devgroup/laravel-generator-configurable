@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $entityFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $relationFields */
@endphp
namespace App\Domain\{{ $entityName }};

use Illuminate\Database\Eloquent\Model;
@foreach($useCommonForEntity as $use)
use {{ $use }};
@endforeach
@foreach($useEntityForEntity as $use)
use App\Domain\{{ $use }}\{{ $use }};
@endforeach
@if($enableMultiLanguage)
use Spatie\Translatable\HasTranslations;
@endif

/**
 * Class {{ $entityName }}
 * {{ '@' }}package App\Domain\{{ $entityName }}
 * {{ '@' }}property-read int $id
@foreach($entityFields as $field)
@if($field->isRelation())
@if(in_array($field->getRelationType(), ['hasMany', 'belongsToMany']))
 * {{ '@' }}property {{ $field->getRelationEntity() }}[]{{ ($field->isNullable()) ? '|null' : '' }} ${{ $field->getField() }}
@else
 * {{ '@' }}property {{ $field->getRelationEntity() }}{{ ($field->isNullable()) ? '|null' : '' }} ${{ $field->getField() }}
@endif
@else
 * {{ '@' }}property @if($field->isMultiLanguage()){{ 'array|string' }}@else{{ $field->getType() }}@endif{{ ($field->isNullable()) ? '|null' : '' }} ${{ $field->getField() }}
@endif
@endforeach
@if($entityFieldDeletedAt)
 * {{ '@' }}property Carbon|null $deleted_at
@endif
@if($entityFieldCreatedAt)
 * {{ '@' }}property Carbon|null $created_at
@endif
@if($entityFieldUpdatedAt)
 * {{ '@' }}property Carbon|null $updated_at
@endif
 */
class {{ $entityName }} extends Model
{
@if($enableMultiLanguage)
    use HasTranslations;

@endif
    /**
     * {{ '@' }}type string
     */
    public const DEFAULT_SORT_FIELD = 'id';
    /**
     * {{ '@' }}type string
     */
    public const DEFAULT_SORT_DIRECTION = 'ASC';
@if(!$entityFieldCreatedAt && $entityFieldUpdatedAt)
    /**
     * {{ '@' }}type string|null
     */
    public const CREATED_AT = null;
@endif
@if($entityFieldCreatedAt && !$entityFieldUpdatedAt)
    /**
     * {{ '@' }}type string|null
     */
    public const UPDATED_AT = null;
@endif

@if(!$entityFieldCreatedAt && !$entityFieldUpdatedAt)
    /**
     * @inheritDoc
     */
    public $timestamps = false;
@endif
    /**
     * {{ '@' }}inheritDoc
     */
    protected $table = '{{ $entityTable }}';
    /**
     * {{ '@' }}inheritDoc
     */
    protected $dates = [
@foreach($entityFieldsDateTime as $field)
        '{{ $field }}',
@endforeach
    ];
    /**
     * {{ '@' }}inheritDoc
     */
    protected $casts = [
@foreach($entityFieldsCasts as $field => $type)
        '{{ $field }}' => '{{ $type }}',
@endforeach
    ];
    /**
     * {{ '@' }}var array
     */
    public $translatable = [
@foreach($entityFieldsMultiLanguage as $field)
        '{{ $field }}',
@endforeach
    ];
@foreach($relationFields as $index => $relation)

    /**
     * {{ '@' }}return {{ $chunk->get('ucfirst', ['text' => $relation->getType()]) }}
     */
    public function {{ $relation->getField() }}(): {{ $chunk->get('ucfirst', ['text' => $relation->getType()]) }}
    {
@switch($relation->getType())
@case('belongsToMany')
        return $this->{{ $relation->getType() }}({{ $relation->getEntity() }}::class, '{{ $relation->getTable() }}', '{{ $relation->getLocal() }}', '{{ $relation->getForeign() }}');
@break
@case('belongsTo')
        return $this->{{ $relation->getType() }}({{ $relation->getEntity() }}::class, '{{ $relation->getLocal() }}', '{{ $relation->getForeign() }}');
@break
@default
        return $this->{{ $relation->getType() }}({{ $relation->getEntity() }}::class, '{{ $relation->getForeign() }}', '{{ $relation->getLocal() }}');
@break
@endswitch
    }
@endforeach

    /**
     * {{ '@' }}return self
     */
    public static function register(): self
    {
        $model = new self();

        return $model;
    }
}
