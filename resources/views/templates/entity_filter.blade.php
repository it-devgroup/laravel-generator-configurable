@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilterField[] $filterFields */
@endphp
namespace App\Domain\{{ $entityName }};

use Illuminate\Http\Request;
@foreach($useCommonForFilter as $use)
use {{ $use }};
@endforeach

/**
 * Class {{ $entityName }}Filter
 * {{ '@' }}package App\Domain\{{ $entityName }}
 */
class {{ $entityName }}Filter
{
@foreach($filterFields as $field)
    /**
     * {{ '@' }}var {{ $field->getType() }}|null
     */
    private ?{{ $field->getType() }} ${{ $field->getName() }} = null;
@endforeach

    /**
     * {{ '@' }}param Request $request
     * {{ '@' }}return self
     */
    public static function fromRequest(Request $request): self
    {
        $filter = collect($request->input('filter'));

        return (new self())@if(!count($filterFields)){{ ";\n" }}@else{{ "\n" }}@endif
@foreach($filterFields as $index => $field)
@php
$last = ($index + 1) == count($filterFields);
@endphp
@switch($field->getType())
@case('int')
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}($filter->get('{{ $field->getName() }}'))@if($last);@endif
@break
@case('float')
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}($filter->get('{{ $field->getName() }}'))@if($last);@endif
@break
@case('bool')
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}($filter->get('{{ $field->getName() }}', null))@if($last);@endif
@break
@case('array')
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}($filter->get('{{ $field->getName() }}'))@if($last);@endif
@break
@case('Carbon')
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}(
                $filter->get('{{ $field->getName() }}') ?
                    Carbon::createFromFormat($filter->get('f6From'), 'Y-m-d') : null
            )@if($last);@endif
@break
@default
            ->set{{ $chunk->get('ucfirst', ['text' => $field->getName()]) }}($filter->get('{{ $field->getName() }}'))@if($last);@endif
@endswitch

@endforeach
    }
@foreach($filterFields as $index => $field)

    /**
     * {{ '@' }}return {{ $field->getType() }}|null
     */
    public function get{{ \Illuminate\Support\Str::ucfirst($field->getName()) }}(): ?{{ $field->getType() }}
    {
        return $this->{{ $field->getName() }};
    }

    /**
     * {{ '@' }}param {{ $field->getType() }}|null ${{ $field->getName() }}
     * {{ '@' }}return self
     */
    public function set{{ \Illuminate\Support\Str::ucfirst($field->getName()) }}(?{{ $field->getType() }} ${{ $field->getName() }}): self
    {
        $this->{{ $field->getName() }} = ${{ $field->getName() }};
        return $this;
    }
@endforeach
}
