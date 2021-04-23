@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
@endphp
namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
use App\Contract\Core\Handler;
@if($data->getEntity()->getDeletedAt())
use App\Domain\{{ $entityName }}\{{ $entityName }};
@endif
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;
@if($data->getEntity()->getDeletedAt())
use Carbon\Carbon;
@endif

/**
 * Class Delete{{ $entityName }}Handler
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Delete{{ $entityName }}Handler implements Handler
{
    /**
     * {{ '@' }}var {{ $entityName }}RepositoryInterface
     */
    private {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;

    /**
     * Delete{{ $entityName }}Handler constructor.
     * {{ '@' }}param {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
     */
    public function __construct(
        {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
    ) {
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository = ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;
    }

    /**
     * {{ '@' }}param Delete{{ $entityName }}|Command $command
@if($data->getEntity()->getDeletedAt())
     * {{ '@' }}return {{ $entityName }}
@else
@endif
     */
    public function handle(Command $command)
    {
        ${{ \Illuminate\Support\Str::camel($entityName) }} = $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->byId($command->getId());
@if($data->getEntity()->getDeletedAt())
        ${{ \Illuminate\Support\Str::camel($entityName) }}->deleted_at = Carbon::now();
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->store(${{ \Illuminate\Support\Str::camel($entityName) }});

        return ${{ \Illuminate\Support\Str::camel($entityName) }};
@else
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->delete(${{ \Illuminate\Support\Str::camel($entityName) }});
@endif
    }
}
