@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerCreateFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[]|\Illuminate\Support\Collection $controllerUpdateFields */
@endphp
namespace App\Http\Controllers{{ $data->getConfig()->getContextController() ? '\\' . $data->getConfig()->getContextController() : ''  }};

@foreach($useEntityForController as $v)
use App\Application\{{ $v }}\Get{{ $v }}ById;
@endforeach
@if($data->getControllerDelete()->isEnable())
use App\Application\{{ $entityName }}\Delete{{ $entityName }};
@endif
@if($data->getControllerById()->isEnable())
use App\Application\{{ $entityName }}\Get{{ $entityName }}ById;
@endif
@if($data->getControllerList()->isEnable())
use App\Application\{{ $entityName }}\Get{{ $entityName }}List;
@endif
@if($data->getControllerCreate()->isEnable())
use App\Application\{{ $entityName }}\Register{{ $entityName }};
@endif
@if($data->getControllerUpdate()->isEnable())
use App\Application\{{ $entityName }}\Update{{ $entityName }};
@endif
@if($data->getControllerList()->isEnable())
use App\Domain\{{ $entityName }}\{{ $entityName }}Filter;
@endif
@if($data->getControllerList()->isEnable())
use App\Http\Requests\{{ $entityName }}\{{ $entityName }}RequestList;
@endif
@if($data->getControllerCreate()->isEnable())
use App\Http\Requests\{{ $entityName }}\{{ $entityName }}RequestCreate;
@endif
@if($data->getControllerUpdate()->isEnable())
use App\Http\Requests\{{ $entityName }}\{{ $entityName }}RequestUpdate;
@endif
@if($data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable() || $data->getControllerList()->isEnable())
use App\Helpers\StringConvertHelper;
@endif
use App\Http\Controllers\Controller;
@if($data->getResponse()->isEnable() && ($data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable() || $data->getControllerList()->isEnable() || $data->getControllerById()->isEnable()))
use App\Http\Resources\{{ $entityName }}\{{ $entityName }}Resource;
@endif
@if($data->getResponse()->isEnable() && ($data->getControllerList()->isEnable()))
use App\Http\Resources\{{ $entityName }}\{{ $entityName }}ResourceCollection;
@endif
@if($data->getControllerList()->isEnable())
use App\Infrastructure\Core\Pagination;
use App\Infrastructure\Core\Sorting;
@endif
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class {{ $entityName }}Controller
 * {{ '@' }}package App\Http\Controllers{{ $data->getConfig()->getContextController() ? '\\' . $data->getConfig()->getContextController() : ''  }}
 */
class {{ $entityName }}Controller extends Controller
{
@if($data->getControllerList()->isEnable())
    /**
     * {{ '@' }}param {{ $entityName }}RequestList $request
     * {{ '@' }}return JsonResponse
     */
    public function list({{ $entityName }}RequestList $request): JsonResponse
    {
        $this->validate(
            $request,
            [
@foreach($data->getFilter()->getFields() as $field)
@switch($field->getType())
@case('float')
                'filter.{{ $field->getName() }}' => 'nullable|numeric',
@break
@case('Carbon')
                'filter.{{ $field->getName() }}' => 'nullable|date_format:Y-m-d',
@break
@default
                'filter.{{ $field->getName() }}' => 'nullable|{{ $field->getOriginalType() }}',
@endswitch
@endforeach
                'page.size' => 'nullable|integer',
                'page.number' => 'nullable|integer',
                'sort' => 'nullable|string',
            ]
        );

        $list = $this->execute(
            new Get{{ $entityName }}List(
                {{ $entityName }}Filter::fromRequest($request),
                Pagination::fromRequest($request),
                Sorting::fromRequest($request)
            )
        );

@if($data->getResponse()->isEnable())
        return $this->json(new {{ $entityName }}ResourceCollection($list), Response::HTTP_OK);
@else
        return $this->json([], Response::HTTP_OK);
@endif
    }
@endif
@if($data->getControllerById()->isEnable())
@if($data->getControllerList()->isEnable())

@endif
    /**
     * {{ '@' }}param Request $request
     * {{ '@' }}return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $data = $this->execute(
            new Get{{ $entityName }}ById(
                $request->route('id')
            )
        );

@if($data->getResponse()->isEnable())
        return $this->json(
            [
                'data' => new {{ $entityName }}Resource($data)
            ],
            Response::HTTP_OK
        );
@else
        return $this->json([], Response::HTTP_OK);
@endif
    }
@endif
@if($data->getControllerCreate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerList()->isEnable())

@endif
    /**
     * {{ '@' }}param {{ $entityName }}RequestCreate $request
     * {{ '@' }}return JsonResponse
     */
    public function create({{ $entityName }}RequestCreate $request): JsonResponse
    {
        $this->validate(
            $request,
            [
@foreach($controllerCreateFields as $field)
@switch($field->getType())
@case('float')
@php $type = 'numeric'; @endphp
@break
@case('Carbon')
@php $type = 'date_format:Y-m-d'; @endphp
@break
@default
@php $type = $field->getOriginalType(); @endphp
@endswitch
@if($field->isRelation())
                '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}integer|exists:App\Domain\{{ $field->getRelationEntity() }}\{{ $field->getRelationEntity() }},id',
@elseif($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => 'nullable|array',
                '{{ $field->getVariable() }}.*' => 'nullable|{{ $type }}',
@if(!$field->isNullable())
                '{{ $field->getVariable() }}.' . $this->defaulLanguage() => '{{ $field->isRequired() ? 'required|' : '' }}{{ $type }}',
@endif
@else
                '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}{{ $field->isNullable() ? 'nullable|' : '' }}{{ $type }}',
@endif
@endforeach
            ]
        );
@foreach($controllerCreateFields as $field)
@if(!$field->isRelation())
@continue
@endif

@if($field->isRequired())
        ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = $this->execute(
            new Get{{ $field->getRelationEntity() }}ById(
                $request->input('{{ $field->getVariable() }}')
            )
        );
@else
        ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = null;
        if ($request->input('{{ $field->getVariable() }}')) {
            ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = $this->execute(
                new Get{{ $field->getRelationEntity() }}ById(
                    $request->input('{{ $field->getVariable() }}'),
                    false
                )
            );
        }
@endif
@endforeach

        $data = $this->execute(
            new Register{{ $entityName }}(
@foreach($controllerCreateFields as $index => $field)
@php $last = ($index + 1) == count($controllerCreateFields); @endphp
@if($field->isRelation())
                ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }}{{ !$last ? ',' : '' }}
@elseif($field->isMultiLanguage())
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@else
@switch($field->getType())
@case('int')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('float')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('bool')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('array')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('Carbon')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@default
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@endswitch
@endif
@endforeach
            )
        );

@if($data->getResponse()->isEnable())
        return $this->json(
            [
                'data' => new {{ $entityName }}Resource($data)
            ],
            Response::HTTP_OK
        );
@else
        return $this->json([], Response::HTTP_OK);
@endif
    }
@endif
@if($data->getControllerUpdate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerList()->isEnable() || $data->getControllerCreate()->isEnable())

@endif
    /**
     * {{ '@' }}param {{ $entityName }}RequestUpdate $request
     * {{ '@' }}return JsonResponse
     */
    public function update({{ $entityName }}RequestUpdate $request): JsonResponse
    {
        $this->validate(
            $request,
            [
@foreach($controllerUpdateFields as $field)
@switch($field->getType())
@case('float')
@php $type = 'numeric'; @endphp
@break
@case('Carbon')
@php $type = 'date_format:Y-m-d'; @endphp
@break
@default
@php $type = $field->getOriginalType(); @endphp
@endswitch
@if($field->isRelation())
                '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}integer|exists:App\Domain\{{ $field->getRelationEntity() }}\{{ $field->getRelationEntity() }},id',
@elseif($field->isMultiLanguage())
                '{{ $field->getVariable() }}' => 'nullable|array',
                '{{ $field->getVariable() }}.*' => 'nullable|{{ $type }}',
@if(!$field->isNullable())
                '{{ $field->getVariable() }}.' . $this->defaulLanguage() => '{{ $field->isRequired() ? 'required|' : '' }}{{ $type }}',
@endif
@else
                '{{ $field->getVariable() }}' => '{{ $field->isRequired() ? 'required|' : '' }}{{ $field->isNullable() ? 'nullable|' : '' }}{{ $type }}',
@endif
@endforeach
            ]
        );
@foreach($controllerUpdateFields as $field)
@if(!$field->isRelation())
@continue
@endif

@if($field->isRequired())
        ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = $this->execute(
            new Get{{ $field->getRelationEntity() }}ById(
                $request->input('{{ $field->getVariable() }}')
            )
        );
@else
        ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = null;
        if ($request->input('{{ $field->getVariable() }}')) {
            ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }} = $this->execute(
                new Get{{ $field->getRelationEntity() }}ById(
                    $request->input('{{ $field->getVariable() }}'),
                    false
                )
            );
        }
@endif
@endforeach

        $data = $this->execute(
            new Update{{ $entityName }}(
                $request->route('id'),
@foreach($controllerUpdateFields as $index => $field)
@php $last = ($index + 1) == count($controllerUpdateFields); @endphp
@if($field->isRelation())
                ${{ \Illuminate\Support\Str::camel($field->getRelationEntity()) }}{{ !$last ? ',' : '' }}
@elseif($field->isMultiLanguage())
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@else
@switch($field->getType())
@case('int')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('float')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('bool')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('array')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@case('Carbon')
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@break
@default
                $request->input('{{ $field->getVariable() }}'){{ !$last ? ',' : '' }}
@endswitch
@endif
@endforeach
            )
        );

@if($data->getResponse()->isEnable())
        return $this->json(
            [
                'data' => new {{ $entityName }}Resource($data)
            ],
            Response::HTTP_OK
        );
@else
        return $this->json([], Response::HTTP_OK);
@endif
    }
@endif
@if($data->getControllerDelete()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerList()->isEnable() || $data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable())

@endif
    /**
     * {{ '@' }}param Request $request
     * {{ '@' }}return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->execute(
            new Delete{{ $entityName }}(
                $request->route('id')
            )
        );

        return $this->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
@endif
}
