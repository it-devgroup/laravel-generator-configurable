namespace App\Domain\{{ $entityName }};

use App\Contract\Core\FilterInterface;
use App\Contract\Core\PaginationInterface;
use App\Contract\Core\SortingInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface {{ $entityName }}RepositoryInterface
 * {{ '@' }}package App\Domain\{{ $entityName }}
 */
interface {{ $entityName }}RepositoryInterface
{
    /**
     * {{ '@' }}param {{ $entityName }}Filter|FilterInterface $filter
     * {{ '@' }}param PaginationInterface|null $pagination
     * {{ '@' }}param SortingInterface|null $sorting
     * {{ '@' }}return Collection|LengthAwarePaginator|{{ $entityName }}[]
     */
    public function all(
        FilterInterface $filter,
        ?PaginationInterface $pagination = null,
        ?SortingInterface $sorting = null
    );

    /**
     * {{ '@' }}param int $id
     * {{ '@' }}param bool $exception
     * {{ '@' }}return {{ $entityName }}|Model|null
     */
    public function byId(int $id, bool $exception = true): ?Model;

    /**
     * {{ '@' }}param {{ $entityName }}|Model $model
     * {{ '@' }}return bool
     */
    public function store(Model $model): bool;

    /**
     * {{ '@' }}param {{ $entityName }}|Model $model
     * {{ '@' }}return bool
     */
    public function delete(Model $model): bool;
}
