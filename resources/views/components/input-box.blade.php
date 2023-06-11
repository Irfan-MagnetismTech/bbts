@props(['colGrid', 'name', 'value', 'label', 'class' => '', 'attr' => ''])

<div class="form-group col-{{ $colGrid }}">
    <div class="form-item">
        <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class }}"
            value="{{ $value }}" {{ $attr }}>
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
