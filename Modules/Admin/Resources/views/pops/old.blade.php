@php
// dd(!empty($pop));
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($pop) ? 'Update' : 'Add';
    // dd($form_heading);
    $form_url = !empty($pop) ? route('pops.update', $pop->id) : route('pops.store');
    $form_method = !empty($pop) ? 'PUT' : 'POST';
    
    $branch_id = old('branch_id', !empty($pop) ? $pop->branch_id : null);
    $applied_date = old('date', !empty($pop) ? $pop->date : today()->format('d-m-Y'));
    $name = old('name', !empty($pop) ? $pop->purchaseOrder->name : null);
    $type = old('type', !empty($pop) ? $pop->purchaseOrder->type : null);
    $address = old('address', !empty($pop) ? $pop->purchaseOrder->address : null);
    $latLong = old('lat_long', !empty($pop) ? $pop->purchaseOrder->lat_long : null);
    $owners_name = old('owners_name', !empty($pop) ? $pop->purchaseOrder->owners_name : null);
    $contact_person = old('contact_person', !empty($pop) ? $pop->purchaseOrder->contact_person : null);
    $designation = old('designation', !empty($pop) ? $pop->purchaseOrder->designation : null);
    $contact_no = old('contact_no', !empty($pop) ? $pop->purchaseOrder->contact_no : null);
    $email = old('email', !empty($pop) ? $pop->purchaseOrder->email : null);
    $description = old('description', !empty($pop) ? $pop->purchaseOrder->description : null);
    $approval_date = old('approval_date', !empty($pop) ? $pop->approval_date : null);
    $btrc_approval_date = old('btrc_approval_date', !empty($pop) ? $pop->btrc_approval_date : null);
    $commissioning_date = old('commissioning_date', !empty($pop) ? $pop->commissioning_date : null);
    $termination_date = old('termination_date', !empty($pop) ? $pop->termination_date : null);
    $website_published_date = old('website_published_date', !empty($pop) ? $pop->website_published_date : null);
    $signboard = old('signboard', !empty($pop) ? $pop->signboard : null);
    $advance_amount = old('advance_amount', !empty($pop) ? $pop->advance_amount : null);
    $rent = old('rent', !empty($pop) ? $pop->rent : null);
    $advance_reduce = old('advance_reduce', !empty($pop) ? $pop->advance_reduce : null);
    $monthly_rent = old('monthly_rent', !empty($pop) ? $pop->monthly_rent : null);
    $paymet_method = old('paymet_method', !empty($pop) ? $pop->paymet_method : null);
    $bank_id = old('bank_id', !empty($pop) ? $pop->bank_id : null);
    $account_no = old('account_no', !empty($pop) ? $pop->account_no : null);
    $payment_date = old('payment_date', !empty($pop) ? $pop->payment_date : null);
    $routing_no = old('routing_no', !empty($pop) ? $pop->routing_no : null);
    $remarks = old('remarks', !empty($pop) ? $pop->remarks : null);
    $attached_file = old('attached_file', !empty($pop) ? $pop->attached_file : null);
@endphp
