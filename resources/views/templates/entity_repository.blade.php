@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilterField[] $filterFields */
@endphp
namespace App\Infrastructure\PostgresRepository;

use App\Contract\Core\FilterInterface;
use App\Domain\{{ $entityName }}\{{ $entityName }}Filter;
use App\Domain\{{ $entityName }}\{{ $entityName }};
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Eloquent{{ $entityName }}Repository
 * {{ '@' }}package App\Infrastructure\PostgresRepository
 */
class Eloquent{{ $entityName }}Repository implements {{ $entityName }}RepositoryInterface
{
    /**
     * {{ '@' }}inheritDoc
     */
    protected array $sortFields = [
        'id' => 'id',
@foreach($data->getEntity()->getFields() as $field)
@if(!$field->isSortable())
@continue;
@endif
        '{{ $chunk->get('camel', ['text' => $field->getField()]) }}' => '{{ $field->getField() }}',
@endforeach
@if($data->getEntity()->getDeletedAt())
        'deletedAt' => 'deleted_at',
@endif
@if($data->getEntity()->getCreatedAt())
        'createdAt' => 'created_at',
@endif
@if($data->getEntity()->getUpdatedAt())
        'updatedAt' => 'updated_at',
@endif
    ];

    /**
     * Eloquent{{ $entityName }}Repository constructor.
     */
    public function __construct()
    {
        $this->model = new {{ $entityName }}();
    }

    /**
     * {{ '@' }}param Builder $builder
     * {{ '@' }}param {{ $entityName }}Filter|FilterInterface|null $filter
     */
    protected function filter(Builder $builder, ?FilterInterface $filter = null): void
    {
        if (!$filter) {
            return;
        }

@foreach($filterFields as $field)
@if(substr($field->getName(), -4) == 'From' && $field->getType() == 'Carbon')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->where('{{ $field->getField() }}', '>=', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()->startOfDay()->toDateTimeString());
        }
@elseif(substr($field->getName(), -2) == 'To' && $field->getType() == 'Carbon')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->where('{{ $field->getField() }}', '<=', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()->endOfDay()->toDateTimeString());
        }
@else
@switch($field->getOperator())
@case('Carbon')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->where('{{ $field->getField() }}', '{!! $field->getOperator() !!}', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()->toDateTimeString());
        }
@break;
@case('like')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->where('{{ $field->getField() }}', self::OPERATOR_LIKE, sprintf('%%%s%%', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()));
        }
@break;
@case('not like')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->where('{{ $field->getField() }}', 'not ilike', sprintf('%%%s%%', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()));
        }
@break;
@case('in')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->whereIn('{{ $field->getField() }}', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}());
        }
@break;
@case('not in')
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
            $builder->whereNotIn('{{ $field->getField() }}', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}());
        }
@break;
@default
@if($field->getType() == 'bool')
        if (!is_null($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}())) {
@else
        if ($filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}()) {
@endif
            $builder->where('{{ $field->getField() }}', '{!! $field->getOperator() !!}', $filter->get{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}());
        }
@endswitch
@endif
@endforeach
    }
}
