@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataMigrationField[] $migrationFields */
@endphp
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel($data->getEntity()->getTable())) }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $data->getEntity()->getTable() }}', function (Blueprint $table) {
            $table->id();
@foreach($migrationFields as $field)
@php $value = $field->getValue() @endphp
@if(!in_array($value, ['false', 'true']) && !is_numeric($value))
@php $value = "'" . $value . "'" @endphp
@endif
            $table->{{ $field->getType() }}('{{ $field->getField() }}'{{ $field->getParam1() ? ', ' . $field->getParam1() : '' }}{{ $field->getParam2() ? ', ' . $field->getParam2() : '' }}){!! $field->isNullable() ? '->nullable()' : '' !!}{!! $field->isIndex() ? '->index()' : '' !!}{!! $field->getValue() ? '->default(' . $value . ')' : '' !!};
@endforeach
@if($data->getEntity()->getDeletedAt())
            $table->softDeletes();
@endif
@if($data->getEntity()->getCreatedAt() && $data->getEntity()->getUpdatedAt())
            $table->timestamps();
@elseif($data->getEntity()->getCreatedAt() && !$data->getEntity()->getUpdatedAt())
            $table->dateTime('created_at')->nullable();
@elseif(!$data->getEntity()->getCreatedAt() && $data->getEntity()->getUpdatedAt())
            $table->dateTime('updated_at')->nullable();
@endif
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $data->getEntity()->getTable() }}');
    }
}
