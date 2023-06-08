@props(["colGrid", "name", "value", "label", "class" => ""])

<div class="form-group col-{{ $colGrid }}">
    <div class="form-item">
        <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class }}" value="{{ $value }}" required>
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
</div>