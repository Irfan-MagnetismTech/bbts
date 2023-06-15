@props(['colGrid', 'type' => 'text', 'name', 'value', 'label', 'class' => '', 'attr' => '', 'placeholder' =>''])

<div class="form-group col-{{ $colGrid }}">
    <div class="form-item">
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class }}"
            value="{{ $value }}" {{ $attr }}  autocomplete="off"  placeholder="{{$placeholder}}">
        <select class="form-control {{ $class }}" name="{{ $name }}" id="{{ $name }}" {{ $attr }}>
            <option value="">Select an option</option>
            @foreach($value as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
</div>