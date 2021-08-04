@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataEntityField[] $seederFields */
@endphp
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

/**
 * Class {{ $entityName }}TableSeeder
 * {{ '@' }}package Database\Seeders
 */
class {{ $entityName }}TableSeeder extends AbstractSeeder
{
    public const TABLE = '{{ $table }}';
    public const KEYS = 'id';
    public const ID_SAVE = true;

    /**
     * Run the database seeds.
     *
     * {{ '@' }}return void
     */
    public function run()
    {
        DB::table(self::TABLE)->insert($this->data());
        $this->autoincrementUpdate(self::TABLE, 'id');
    }

    /**
     * {{ '@' }}return array
     */
    public function data(): array
    {
        return [
@for($i = 0; $i < $seederCountRows; $i++)
            [
@foreach($seederFields as $field)
@if($field->getField() == 'id')
                '{{ $field->getField() }}' => {{ $i + 1 }},
@elseif($field->isMultiLanguage())
                '{{ $field->getField() }}' => $this->getLocalizationData('{{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getField()))->replace('_', ' ') }} {{ $i + 1 }}'),
@elseif($field->getField() == 'email')
                '{{ $field->getField() }}' => 'seeder{{ $i + 1 }}@test.com',
@elseif($field->getType() == 'Carbon')
                '{{ $field->getField() }}' => '{{ \Carbon\Carbon::now()->setTime(15, 0, 0)->format('Y-m-d H:i:s') }}',
@elseif($field->getType() == 'int')
                '{{ $field->getField() }}' => {{ $i + 1 }},
@elseif($field->getType() == 'float')
                '{{ $field->getField() }}' => {{ rand(10.10, 100.00) }},
@else
                '{{ $field->getField() }}' => '{{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getField()))->replace('_', ' ') }} {{ $i + 1 }}',
@endif
@endforeach
            ],
@endfor
        ];
    }
}
