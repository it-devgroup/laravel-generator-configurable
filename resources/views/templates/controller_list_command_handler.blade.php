namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
use App\Contract\Core\Handler;
use App\Domain\{{ $entityName }}\{{ $entityName }};
use App\Domain\{{ $entityName }}\{{ $entityName }}RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Get{{ $entityName }}ListHandler
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Get{{ $entityName }}ListHandler implements Handler
{
    /**
     * {{ '@' }}var {{ $entityName }}RepositoryInterface
     */
    private {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;

    /**
     * Get{{ $entityName }}ListHandler constructor.
     * {{ '@' }}param {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
     */
    public function __construct(
        {{ $entityName }}RepositoryInterface ${{ \Illuminate\Support\Str::camel($entityName) }}Repository
    ) {
        $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository = ${{ \Illuminate\Support\Str::camel($entityName) }}Repository;
    }

    /**
     * {{ '@' }}param Get{{ $entityName }}List|Command $command
     * {{ '@' }}return LengthAwarePaginator|{{ $entityName }}[]
     */
    public function handle(Command $command)
    {
        return $this->{{ \Illuminate\Support\Str::camel($entityName) }}Repository->all($command->filter(), $command->pagination(), $command->sorting());
    }
}
