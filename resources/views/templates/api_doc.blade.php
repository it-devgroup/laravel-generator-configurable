@php
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceData $data */
/** @var \Illuminate\Support\Collection $sortableFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $entityFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $responseFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $controllerCreateFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $controllerUpdateFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFieldData[] $responseFields */
/** @var \ItDevgroup\LaravelGeneratorConfigurable\Data\GeneratorServiceDataFilterField[] $filterFields */
@endphp
@php $responseRelationCount = $responseFieldCount = 0; @endphp
@foreach($responseFields as $field)
@if($field->isRelation())
@php $responseRelationCount += 1; @endphp
@else
@php $responseFieldCount += 1; @endphp
@endif
@endforeach
@if($data->getControllerList()->isEnable())
/**
 * {{ '@' }}api {get} /{{ ltrim($data->getRoute()->getPrefix(), '/') }} List
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiName List
 * {{ '@' }}apiGroup {{ $entityNameText }}
 *
 * {{ '@' }}apiDescription {{ $entityNameText }} list
 *
 * {{ '@' }}apiUse Authorization
 *
@foreach($filterFields as $field)
 * {{ '@' }}apiParam {{ '{' }}{{ $field->getTextFormatType() }}{{ '}' }} [filter[{{ $field->getName() }}]] Filter by {{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getField()))->replace('_', ' ') }}{{ $field->getType() == 'Carbon' ? ' (format: Y-m-d)' : '' }}
@endforeach
 * {{ '@' }}apiUse ParamPagination
 * {{ '@' }}apiParam {string} [sort] Sorting for field, allowed: {{ $sortableFields->map(function($value){return \Illuminate\Support\Str::camel($value);})->implode(', ') }}
 *
 * {{ '@' }}apiParamExample {string} query
@foreach($filterFields as $index => $field)
@php $value = 'text'; @endphp
@switch($field->getType())
@case('int')
@php $value = '10'; @endphp
@break
@case('float')
@php $value = '10.01'; @endphp
@break
@case('bool')
@php $value = 'true'; @endphp
@break
@case('Carbon')
@php $value = \Carbon\Carbon::now()->format('Y-m-d'); @endphp
@break
@endswitch
 * {!! $index ? '&' : '?' !!}filter[{{ $field->getName() }}]={{ $value }}
@endforeach
 *
 * {{ '@' }}apiSuccess (Success 200) {array} data Response data
 * {{ '@' }}apiSuccess (Success 200) {integer} .id {{ $entityNameText }} ID
 * {{ '@' }}apiSuccess (Success 200) {string} .type {{ $entityNameText }} type
 * {{ '@' }}apiSuccess (Success 200) {object} .attributes {{ $entityNameText }} fields
@foreach($responseFields as $field)
@if($field->isRelation())
@continue
@endif
@php $type = $field->getOriginalType(); @endphp
@switch($field->getType())
@case('Carbon')
@php $type = 'string'; @endphp
@break
@case('array')
@if($field->isMultiLanguage())
@php $type = 'object'; @endphp
@endif
@break
@endswitch
 * {{ '@' }}apiSuccess (Success 200) {{ '{' }}{{ $type }}{{ '}' }} ..{{ $field->getVariable() }} {{ $entityNameText }} {{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') }}{{ $field->isMultiLanguage() ? ' (multi language)' : '' }}
@endforeach
@if($responseRelationCount)
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships {{ $entityNameText }} relationships
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@php $fieldEntityName = \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ')); @endphp
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships.{{ $field->getVariable() }} {{ $entityNameText }} {{ \Illuminate\Support\Str::lower($fieldEntityName) }}
 * {{ '@' }}apiSuccess (Success 200) {{ '{' }}{{ in_array($field->getRelationType(), ['hasMany', 'belongsToMany']) ? 'array' : 'object' }}{{ '}' }} .relationships.{{ $field->getVariable() }}.data {{ $fieldEntityName }} fields
 * {{ '@' }}apiSuccess (Success 200) {integer} .relationships.{{ $field->getVariable() }}.data.id {{ $fieldEntityName }} ID
 * {{ '@' }}apiSuccess (Success 200) {string} .relationships.{{ $field->getVariable() }}.data.type {{ $fieldEntityName }} type
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships.{{ $field->getVariable() }}.data.attributes {{ $fieldEntityName }} fields
@endforeach
@endif
 * {{ '@' }}apiSuccess (Success 200) {object} meta Metadata
 * {{ '@' }}apiSuccess (Success 200) {integer} .totalPages Total pages
 * {{ '@' }}apiSuccess (Success 200) {integer} .totalItems Total items
 *
 * {{ '@' }}apiSuccessExample {json} 200 Ok
 * {
 *     "data": [
 *         {
 *             "id": 1,
 *             "type": "{{ $entityName }}",
 *             "attributes": {
@php $count = 0; @endphp
@foreach($responseFields as $index => $field)
@if($field->isRelation())
@continue
@endif
@php $type = $field->getOriginalType(); @endphp
@php $count += 1; @endphp
@switch($field->getType())
@case('int')
@case('float')
 *                 "{{ $field->getVariable() }}": {{ $index + 1 }}{{ $count != $responseFieldCount ? ',' : '' }}
@break
@case('bool')
 *                 "{{ $field->getVariable() }}": true{{ $count != $responseFieldCount ? ',' : '' }}
@break
@case('array')
@if($field->isMultiLanguage())
 *                 "{{ $field->getVariable() }}": {
 *                     "ru": "ru text",
 *                     "uk": "uk text"
 *                 }{{ $count != $responseFieldCount ? ',' : '' }}
@else
 *                 "{{ $field->getVariable() }}": [
 *                     "text 1",
 *                     "text 2"
 *                 ]{{ $count != $responseFieldCount ? ',' : '' }}
@endif
@break
@default
 *                 "{{ $field->getVariable() }}": "text"{{ $count != $responseFieldCount ? ',' : '' }}
@break
@endswitch
@endforeach
 *             }{{ $responseRelationCount ? ',' : '' }}
@if($responseRelationCount)
 *             "relationships": {
@php $count = 0; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@php $count += 1; @endphp
 *                 "{{ $field->getVariable() }}": {
 *                     "data": {
 *                         "id": 1,
 *                         "type": "{{ $field->getRelationEntity() }}",
 *                         "attributes": {
 *                         }
 *                     }
 *                 }{{ $responseRelationCount != $count ? ',' : '' }}
@endforeach
 *             }
@endif
 *         },
 *         ...
 *     ],
 *     "meta": {
 *         "totalPages": 1,
 *         "totalItems": 10
 *     }
 * }
 */
@endif
@if($data->getControllerById()->isEnable())
@if($data->getControllerList()->isEnable())

@endif
/**
 * {{ '@' }}api {get} /{{ ltrim($data->getRoute()->getPrefix(), '/') }}/:id By ID
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiName By ID
 * {{ '@' }}apiGroup {{ $entityNameText }}
 *
 * {{ '@' }}apiDescription {{ $entityNameText }} by ID
 *
 * {{ '@' }}apiUse Authorization
 *
 * {{ '@' }}apiParam (Path) {integer} id {{ $entityNameText }} ID
 *
 * {{ '@' }}apiUse {{ $entityName }}Data
 * {{ '@' }}apiUse NotFound
 */
@endif
@if($data->getControllerCreate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable())

@endif
/**
 * {{ '@' }}api {post} /{{ ltrim($data->getRoute()->getPrefix(), '/') }} Create
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiName Create
 * {{ '@' }}apiGroup {{ $entityNameText }}
 *
 * {{ '@' }}apiDescription {{ $entityNameText }} create
 *
 * {{ '@' }}apiUse Authorization
 *
@foreach($controllerCreateFields as $field)
 * {{ '@' }}apiParam (Body) {{ '{' }}{{ $field->getTextFormatType() }}{{ '}' }} {{ $field->isRequired() ? $field->getVariable() : '[' . $field->getVariable() . ']' }} {{ $entityNameText }} {{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') }}{{ $field->isMultiLanguage() ? ' (multi language)' : '' }}{{ $field->isMultiLanguage() && $field->isRequired() ? ' (required only default language)' : '' }}{{ $field->getType() == 'Carbon' ? ' (format: Y-m-d)' : '' }}
@endforeach
 *
 * {{ '@' }}apiParamExample {json} Body
 * {
@php $total = count($controllerCreateFields); @endphp
@foreach($controllerCreateFields as $index => $field)
@switch($field->getType())
@case('int')
@case('float')
 *     "{{ $field->getVariable() }}": {{ $index + 1 }}{{ $total != ($index + 1) ? ',' : '' }}
@break
@case('bool')
 *     "{{ $field->getVariable() }}": true{{ $total != ($index + 1) ? ',' : '' }}
@break
@case('array')
@if($field->isMultiLanguage())
 *     "{{ $field->getVariable() }}": {
 *         "ru": "ru text",
 *         "uk": "uk text"
 *     }{{ $total != ($index + 1) ? ',' : '' }}
@else
 *     "{{ $field->getVariable() }}": [
 *         "text 1",
 *         "text 2"
 *     }{{ $total != ($index + 1) ? ',' : '' }}
@endif
@break
@default
 *     "{{ $field->getVariable() }}": "text"{{ $total != ($index + 1) ? ',' : '' }}
@break
@endswitch
@endforeach
 * }
 *
 * {{ '@' }}apiUse {{ $entityName }}Data
 * {{ '@' }}apiUse NotAcceptableFields
 */
@endif
@if($data->getControllerUpdate()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable() || $data->getControllerCreate()->isEnable())

@endif
/**
 * {{ '@' }}api {put} /{{ ltrim($data->getRoute()->getPrefix(), '/') }}/:id Update
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiName Update
 * {{ '@' }}apiGroup {{ $entityNameText }}
 *
 * {{ '@' }}apiDescription {{ $entityNameText }} update
 *
 * {{ '@' }}apiUse Authorization
 *
 * {{ '@' }}apiParam (Path) {integer} id {{ $entityNameText }} ID
 *
@foreach($controllerUpdateFields as $field)
 * {{ '@' }}apiParam (Body) {{ '{' }}{{ $field->isMultiLanguage() ? 'object' : $field->getTextFormatType() }}{{ '}' }} {{ $field->isRequired() ? $field->getVariable() : '[' . $field->getVariable() . ']' }} {{ $entityNameText }} {{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') }}{{ $field->isMultiLanguage() ? ' (multi language)' : '' }}{{ $field->isMultiLanguage() && $field->isRequired() ? ' (required only default language)' : '' }}{{ $field->getType() == 'Carbon' ? ' (format: Y-m-d)' : '' }}
@endforeach
 *
 * {{ '@' }}apiParamExample {json} Body
 * {
@php $total = count($controllerUpdateFields); @endphp
@foreach($controllerUpdateFields as $index => $field)
@switch($field->getType())
@case('int')
@case('float')
 *     "{{ $field->getVariable() }}": {{ $index + 1 }}{{ $total != ($index + 1) ? ',' : '' }}
@break
@case('bool')
 *     "{{ $field->getVariable() }}": true{{ $total != ($index + 1) ? ',' : '' }}
@break
@case('array')
@if($field->isMultiLanguage())
 *     "{{ $field->getVariable() }}": {
 *         "ru": "ru text",
 *         "uk": "uk text"
 *     }{{ $total != ($index + 1) ? ',' : '' }}
@else
 *     "{{ $field->getVariable() }}": [
 *         "text 1",
 *         "text 2"
 *     }{{ $total != ($index + 1) ? ',' : '' }}
@endif
@break
@default
 *     "{{ $field->getVariable() }}": "text"{{ $total != ($index + 1) ? ',' : '' }}
@break
@endswitch
@endforeach
 * }
 *
 * {{ '@' }}apiUse {{ $entityName }}Data
 * {{ '@' }}apiUse NotAcceptableFields
 * {{ '@' }}apiUse NotFound
 */
@endif
@if($data->getControllerDelete()->isEnable())
@if($data->getControllerList()->isEnable() || $data->getControllerById()->isEnable() || $data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable())

@endif
/**
 * {{ '@' }}api {delete} /{{ ltrim($data->getRoute()->getPrefix(), '/') }}/:id Delete
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiName Delete
 * {{ '@' }}apiGroup {{ $entityNameText }}
 *
 * {{ '@' }}apiDescription {{ $entityNameText }} delete
 *
 * {{ '@' }}apiUse Authorization
 *
 * {{ '@' }}apiParam (Path) {integer} id {{ $entityNameText }} ID
 *
 * {{ '@' }}apiUse NoContent
 * {{ '@' }}apiUse NotFound
 */
@endif
@if($data->getControllerById()->isEnable() || $data->getControllerCreate()->isEnable() || $data->getControllerUpdate()->isEnable())

/**
 * {{ '@' }}apiDefine {{ $entityName }}Data
 * {{ '@' }}apiVersion 0.0.1
 * {{ '@' }}apiSuccess (Success 200) {object} data Response data
 * {{ '@' }}apiSuccess (Success 200) {integer} .id {{ $entityNameText }} ID
 * {{ '@' }}apiSuccess (Success 200) {string} .type {{ $entityNameText }} type
 * {{ '@' }}apiSuccess (Success 200) {object} .attributes {{ $entityNameText }} fields
@php $responseRelationCount = $responseFieldCount = 0; @endphp
@foreach($responseFields as $field)
@if($field->isRelation())
@php $responseRelationCount += 1; @endphp
@continue
@endif
@php $responseFieldCount += 1; @endphp
@php $type = $field->getOriginalType(); @endphp
@switch($field->getType())
@case('Carbon')
@php $type = 'string'; @endphp
@break
@case('array')
@if($field->isMultiLanguage())
@php $type = 'object'; @endphp
@endif
@break
@endswitch
 * {{ '@' }}apiSuccess (Success 200) {{ '{' }}{{ $type }}{{ '}' }} ..{{ $field->getVariable() }} {{ $entityNameText }} {{ \Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ') }}{{ $field->isMultiLanguage() ? ' (multi language)' : '' }}
@endforeach
@if($responseRelationCount)
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships {{ $entityNameText }} relationships
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@php $fieldEntityName = \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::of(\Illuminate\Support\Str::snake($field->getVariable()))->replace('_', ' ')); @endphp
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships.{{ $field->getVariable() }} {{ $entityNameText }} {{ \Illuminate\Support\Str::lower($fieldEntityName) }}
 * {{ '@' }}apiSuccess (Success 200) {{ '{' }}{{ in_array($field->getRelationType(), ['hasMany', 'belongsToMany']) ? 'array' : 'object' }}{{ '}' }} .relationships.{{ $field->getVariable() }}.data {{ $fieldEntityName }} fields
 * {{ '@' }}apiSuccess (Success 200) {integer} .relationships.{{ $field->getVariable() }}.data.id {{ $fieldEntityName }} ID
 * {{ '@' }}apiSuccess (Success 200) {string} .relationships.{{ $field->getVariable() }}.data.type {{ $fieldEntityName }} type
 * {{ '@' }}apiSuccess (Success 200) {object} .relationships.{{ $field->getVariable() }}.data.attributes {{ $fieldEntityName }} fields
@endforeach
@endif
 *
 * {{ '@' }}apiSuccessExample {json} 200 Ok
 * {
 *     "data": {
 *         "id": 1,
 *         "type": "{{ $entityName }}",
 *         "attributes": {
@php $count = 0; @endphp
@foreach($responseFields as $index => $field)
@if($field->isRelation())
@continue
@endif
@php $type = $field->getOriginalType(); @endphp
@php $count += 1; @endphp
@switch($field->getType())
@case('int')
@case('float')
 *             "{{ $field->getVariable() }}": {{ $index + 1 }}{{ $count != $responseFieldCount ? ',' : '' }}
@break
@case('bool')
 *             "{{ $field->getVariable() }}": true{{ $count != $responseFieldCount ? ',' : '' }}
@break
@case('array')
@if($field->isMultiLanguage())
 *             "{{ $field->getVariable() }}": {
 *                 "ru": "ru text",
 *                 "uk": "uk text"
 *             }{{ $count != $responseFieldCount ? ',' : '' }}
@else
 *             "{{ $field->getVariable() }}": [
 *                 "text 1",
 *                 "text 2"
 *             ]{{ $count != $responseFieldCount ? ',' : '' }}
@endif
@break
@default
 *             "{{ $field->getVariable() }}": "text"{{ $count != $responseFieldCount ? ',' : '' }}
@break
@endswitch
@endforeach
 *         }{{ $responseRelationCount ? ',' : '' }}
@if($responseRelationCount)
 *         "relationships": {
@php $count = 0; @endphp
@foreach($responseFields as $field)
@if(!$field->isRelation())
@continue
@endif
@php $count += 1; @endphp
 *             "{{ $field->getVariable() }}": {
 *                 "data": {
 *                     "id": 1,
 *                     "type": "{{ $field->getRelationEntity() }}",
 *                     "attributes": {
 *                     }
 *                 }
 *             }{{ $responseRelationCount != $count ? ',' : '' }}
@endforeach
 *         }
@endif
 *     }
 * }
 */
@endif
