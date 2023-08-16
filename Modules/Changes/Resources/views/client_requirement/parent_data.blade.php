<div class="row">
    <div class="md-col-3 col-3">
        <div class="form-item">
            <input type="text" name="client_no" id="client_no" class="form-control" value="{{ $client_no }}">
            <label for="client_id">Client ID <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3">
        <div class="form-item">
            <input type="text" name="client_name" id="client_name" class="form-control" value="{{ $client_name }}"
                readonly>
            <label for="client_name">Client Name <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3">
        <div class="form-item">
            <input type="text" name="date" id="date" class="form-control" value="{{ $date }}">
            <label for="date">Date <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3">
        <div class="form-item">
            <input type="text" name="activation_date" id="activation_date" class="form-control"
                value="{{ $activation_date }}">
            <label for="activation_date">Activation Date <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3">
        <div class="form-item">
            <select name="fr_no" id="fr_no" class="form-control">
                <option value="">Select FR No</option>
                @if (!empty($mod))
                    @foreach ($frList as $fr_no)
                        <option value="{{ $fr_no }}" @selected($fr_no == $fr_no)>
                            {{ $fr_no }}</option>
                    @endforeach
                @endif
            </select>
            <label for="fr_no">FR No <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3">
        <div class="form-item">
            <input type="text" name="connectivity_remarks" id="connectivity_remarks" class="form-control"
                value="{{ $connectivity_remarks }}">
            <label for="fr_no">Remarks <span class="text-danger">*</span></label>
        </div>
    </div>

    <div class="md-col-3 col-3" {!! in_array('Temporary-Inactive', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
        <div class="form-item">
            <input type="text" name="from_date" id="from_date" class="form-control" value="{{ $from_date }}">
            <label for="fr_no">From date <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3" {!! in_array('Temporary-Inactive', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
        <div class="form-item">
            <input type="text" name="to_date" id="to_date" class="form-control" value="{{ $to_date }}">
            <label for="fr_no">To date <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3" {!! in_array('MRC-Decrease', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
        <div class="form-item">
            <input type="text" name="existing_mrc" id="existing_mrc" class="form-control"
                value="{{ $existing_mrc }}">
            <label for="fr_no">Existing MRC <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="md-col-3 col-3" {!! in_array('MRC-Decrease', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
        <div class="form-item">
            <input type="text" name="decrease_mrc" id="decrease_mrc" class="form-control"
                value="{{ $decrease_mrc }}">
            <label for="fr_no">Decrease MRC<span class="text-danger">*</span></label>
        </div>
    </div>
</div>
