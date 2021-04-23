namespace App\Application\{{ $entityName }};

use App\Contract\Core\Command;

/**
 * Class Delete{{ $entityName }}
 * {{ '@' }}package App\Application\{{ $entityName }}
 */
class Delete{{ $entityName }} implements Command
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
