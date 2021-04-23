@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerCreateFields */
@endphp
namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
use App\Contract\Core\Handler;
use App\Domain\{{ $entityName }}\{{ $entityName }};
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;

/**
 * Class Register{{ $entityName }}Handler
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Register{{ $entityName }}Handler implements Handler
{
    /**
     * {{ '@' }}var {{ $entityName }}RepositoryInterface
     */
    private {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;

    /**
     * Register{{ $entityName }}Handler constructor.
     * {{ '@' }}param {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
     */
    public function __construct(
        {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
    ) {
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository = ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;
    }

    /**
     * {{ '@' }}param Register{{ $entityName }}|Command $command
     * {{ '@' }}return {{ $entityName }}
     */
    public function handle(Command $command)
    {
        ${{ \Illuminate\Support\Str::camel($entityName) }} = {{ $entityName }}::register();
@foreach($controllerCreateFields as $field)
@if($field->isRelation())
@continue
@endif
        ${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getField() }} = $command->get{{ \Illuminate\Support\Str::ucfirst($field->getVariable()) }}();
@endforeach
@foreach($controllerCreateFields as $field)
@if(!$field->isRelation())
@continue
@endif
@switch($field->getRelationType())
@case('belongsTo')
        ${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getField() }}()->associate($command->get{{ \Illuminate\Support\Str::ucfirst($field->getVariable()) }}());
@break
@endswitch
@endforeach
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->store(${{ \Illuminate\Support\Str::camel($entityName) }});
@foreach($controllerCreateFields as $field)
@if(!$field->isRelation())
@continue
@endif
@switch($field->getRelationType())
@case('hasOne')
        ${{ \Illuminate\Support\Str::camel($entityName) }}->{{ $field->getField() }}()->save($command->get{{ \Illuminate\Support\Str::ucfirst($field->getVariable()) }}());
@break
@endswitch
@endforeach

        return ${{ \Illuminate\Support\Str::camel($entityName) }};
    }
}
