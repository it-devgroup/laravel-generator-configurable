namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;
use App\Contract\Core\PaginationInterface;
use App\Contract\Core\SortingInterface;
use App\Domain\{{ $entityName }}\{{ $entityName }}Filter;

/**
 * Class Get{{ $entityName }}List
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Get{{ $entityName }}List implements Command
{
    /**
     * {{ '@' }}var {{ $entityName }}Filter
     */
    private {{ $entityName }}Filter $filter;
    /**
     * {{ '@' }}var PaginationInterface|null
     */
    private ?PaginationInterface $pagination;
    /**
     * {{ '@' }}var SortingInterface|null
     */
    private ?SortingInterface $sorting;

    /**
     * Get{{ $entityName }}List constructor.
     * {{ '@' }}param {{ $entityName }}Filter $filter
     * {{ '@' }}param PaginationInterface|null $pagination
     * {{ '@' }}param SortingInterface|null $sorting
     */
    public function __construct(
        {{ $entityName }}Filter $filter,
        ?PaginationInterface $pagination = null,
        ?SortingInterface $sorting = null
    ) {
        $this->filter = $filter;
        $this->pagination = $pagination;
        $this->sorting = $sorting;
    }

    /**
     * {{ '@' }}return {{ $entityName }}Filter
     */
    public function filter(): {{ $entityName }}Filter
    {
        return $this->filter;
    }

    /**
     * {{ '@' }}return PaginationInterface|null
     */
    public function pagination(): ?PaginationInterface
    {
        return $this->pagination;
    }

    /**
     * {{ '@' }}return SortingInterface|null
     */
    public function sorting(): ?SortingInterface
    {
        return $this->sorting;
    }
}
