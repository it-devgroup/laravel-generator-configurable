namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;

/**
 * Class Get{{ $entityName }}ById
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Get{{ $entityName }}ById implements Command
{
    /**
     * {{ '@' }}var int
     */
    private int $id;

    /**
     * {{ '@' }}param int $id
     */
    public function __construct(
        int $id
    ) {
        $this->id = $id;
    }

    /**
     * {{ '@' }}return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
