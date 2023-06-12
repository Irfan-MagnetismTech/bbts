@props(['colGrid', 'type' => 'text', 'name', 'value', 'label', 'class' => '', 'attr' => ''])

<div class="form-group col-{{ $colGrid }}">
    <div class="form-item">
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class }}"
            value="{{ $value }}" {{ $attr }} autocomplete="off">
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
