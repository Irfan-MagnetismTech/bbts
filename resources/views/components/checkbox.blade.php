@props(['arrayValue', 'label', 'sale'])

<span class="checkbox-fade">
    <label>
        <input type="checkbox" disabled @checked(in_array($arrayValue, $sale->ccSchedule->approved_type) ? true : false)>
        <span class="cr">
            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
        </span>
        <span class="font-weight-bold">{{ $label }}</span>
    </label>
</span>
