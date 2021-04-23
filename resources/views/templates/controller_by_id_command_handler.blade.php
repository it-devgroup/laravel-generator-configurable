namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
use App\Contract\Core\Handler;
use App\Domain\{{ $entityName }}\{{ $entityName }};
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;

/**
 * Class Get{{ $entityName }}ByIdHandler
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Get{{ $entityName }}ByIdHandler implements Handler
{
    /**
     * {{ '@' }}var {{ $entityName }}RepositoryInterface
     */
    private {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;

    /**
     * Get{{ $entityName }}ByIdHandler constructor.
     * {{ '@' }}param {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
     */
    public function __construct(
        {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
    ) {
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository = ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;
    }

    /**
     * {{ '@' }}param Get{{ $entityName }}ById|Command $command
     * {{ '@' }}return {{ $entityName }}
     */
    public function handle(Command $command)
    {
        return $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->byId($command->getId());
    }
}
