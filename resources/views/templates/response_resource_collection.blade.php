namespace App\Http\Resources\{{ $entityName }};

use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class {{ $entityName }}ResourceCollection
 * {{ '@' }}package App\Http\Resources\{{ $entityName }}
 */
class {{ $entityName }}ResourceCollection extends BaseResourceCollection
{
    /**
     * {{ '@' }}inheritDoc
     */
    protected function getItemData($item, ?string $set = null): JsonResource
    {
        return new {{ $entityName }}Resource($item, $set);
    }
}
