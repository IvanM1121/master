@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
	<div class="card">
	<span class="d-none panel-title">{{ _lang('Update Purchase Order') }}</span>

	<div class="card-body">
		<form method="post" class="validate" autocomplete="off" action="{{ action('PurchaseController@update', $id) }}" enctype="multipart/form-data">
			   
			{{ csrf_field()}}
			<input name="_method" type="hidden" value="PATCH">	
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					<label class="control-label">{{ _lang('Order Date') }}</label>						
					<input type="text" class="form-control datepicker" name="order_date" value="{{ $purchase->order_date }}" readOnly="true" required>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
					<a href="{{ route('suppliers.create') }}" data-reload="false" data-title="{{ _lang('Add Supplier') }}" class="ajax-modal-2 select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a>
					<label class="control-label">{{ _lang('Supplier') }}</label>						
					<select class="form-control select2-ajax" name="supplier_id" data-value="id" data-display="supplier_name" data-table="suppliers" data-where="1" required>
						<option value="">{{ _lang('Select One') }}</option>
						{{ create_option("suppliers","id","supplier_name",$purchase->supplier_id,array("company_id="=>company_id())) }}
					</select>	
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
					<label class="control-label">{{ _lang('Order Status') }}</label>						
					<select class="form-control select2" name="order_status" required>
						<option value="1" {{ $purchase->order_status == '1' ? 'selected' : '' }}>{{ _lang('Ordered') }}</option>
						<option value="2" {{ $purchase->order_status == '2' ? 'selected' : '' }}>{{ _lang('Pending') }}</option>
						<option value="3" {{ $purchase->order_status == '3' ? 'selected' : '' }}>{{ _lang('Received') }}</option>
						<option value="4" {{ $purchase->order_status == '4' ? 'selected' : '' }}>{{ _lang('Canceled') }}</option>
					</select>
					</div>
				</div>
				

				<div class="col-md-4">
					<div class="form-group select-product-container">
					<a href="{{ route('products.create') }}" data-reload="false" data-title="{{ _lang('Add Product') }}" class="ajax-modal select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a>
					<label class="control-label">{{ _lang('Select Product') }}</label>						
					<select class="form-control select2-ajax" data-value="id" data-display="item_name" data-table="items" data-where="2" name="product" id="product">
						<option value="">{{ _lang('Select Product') }}</option>
					</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">{{ _lang('Payment Status') }}</label>						
						<select class="form-control select2" name="payment_status" required>
							<option value="1" {{ $purchase->payment_status == '0' ? 'selected' : '' }}>{{ _lang('Due') }}</option>
							<option value="2" {{ $purchase->payment_status == '1' ? 'selected' : '' }}>{{ _lang('Paid') }}</option>
						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">{{ _lang('Attachemnt') }}</label>						
						<input type="file" class="form-control trickycode-file" data-value="{{ $purchase->attachemnt }}" name="attachemnt">
					</div>
				</div>

				@php $currency = currency(); @endphp

				<!--Order table -->
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="order-table" class="table table-bordered">
							<thead>
								<tr>
									<th>{{ _lang('Name') }}</th>
									<th class="text-center wp-100">{{ _lang('Quantity') }}</th>
									<th class="text-right">{{ _lang('Unit Cost').' '.$currency }}</th>
									<th class="text-right wp-100">{{ _lang('Discount').' '.$currency }}</th>
									<th class="text-right">{{ _lang('Tax method') }}</th>
									<th class="text-right">{{ _lang('Tax').' '.$currency }}</th>
									<th class="text-right">{{ _lang('Sub Total').' '.$currency }}</th>
									<th class="text-center">{{ _lang('Action') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($purchase->purchase_items as $item)
									<tr id="product-{{ $item->product_id }}">
											<td>
												<b>{{ $item->item->item_name }}</b><br>
												<span class="description">{{ $item->description }}</span>
											</td>
											<td class="text-center quantity">{{ $item->quantity }}</td>
											<td class="text-right unit-cost">{{ $item->unit_cost }}</td>
											<td class="text-right discount">{{ $item->discount }}</td>
											<td class="text-right tax-method">{{ strtoupper($item->tax_method) }}</td>
											<td class="text-right tax">{{ $item->tax_amount }}</td>
											<td class="text-right sub-total">{{ $item->sub_total }}</td>
											<td class="text-center">
												<button type="button" class="btn btn-success btn-xs edit-product"><i class="fas fa-edit"></i></button>
												<button type="button" class="btn btn-danger btn-xs remove-product"><i class='fa fa-trash'></i></button>
											</td>
											<input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
											<input type="hidden" name="product_description[]" class="input-description" value="{{ $item->description }}">
											<input type="hidden" name="quantity[]" class="input-quantity" value="{{ $item->quantity }}">
											<input type="hidden" name="unit_cost[]" class="input-unit-cost" value="{{ $item->unit_cost }}">
											<input type="hidden" name="discount[]" class="input-discount" value="{{ $item->discount }}">
											<input type="hidden" name="tax_method[]" class="input-tax-method" value="{{ $item->tax_method }}">
											<input type="hidden" name="tax_amount[]" class="input-tax" value="{{ $item->tax_amount }}">
											<input type="hidden" name="tax_id[]" class="input-tax-id" value="{{ $item->tax_id }}">
											<input type="hidden" name="unit_tax[]" class="input-unit-tax" value="{{ $item->tax_amount/$item->quantity }}">
											<input type="hidden" name="sub_total[]" class="input-sub-total" value="{{ $item->sub_total }}">
									</tr>
								@endforeach
							</tbody>
							<tfoot class="tfoot active">
								<tr>
									<th>{{ _lang('Total') }}</th>
									<th class="text-center" id="total-qty">0</th>
									<th></th>
									<th class="text-right" id="total-discount">0.00</th>
									<th></th>
									<th class="text-right" id="total-tax">0.00</th>
									<th class="text-right" id="total">0.00</th>
									<th class="text-center"></th>
									<input type="hidden" name="product_total" id="product_total" value="0">
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
        		<!--End Order table -->

				<div class="col-md-4 clear">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Order Tax')." ".$currency }}</label>						
					<select class="form-control select2" name="order_tax_id">
						 <option value="">{{ _lang('No Tax') }}</option>
						 @foreach(App\Tax::where("company_id",company_id())->get() as $tax)
							  <option value="{{ $tax->id }}"  {{ $purchase->order_tax_id == $tax->id ? 'selected' : ''  }}>{{ $tax->tax_name }} - {{ $tax->type =='percent' ? $tax->rate.' %' : $tax->rate }}</option>
						 @endforeach
          			</select>
				  </div>
				</div>


				<div class="col-md-4">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Order Discount')." ".$currency }}</label>						
					<input type="text" class="form-control float-field" name="order_discount" value="{{ $purchase->order_discount }}">
				  </div>
				</div>

				<div class="col-md-4">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Shipping Cost')." ".$currency }}</label>						
					<input type="text" class="form-control float-field" name="shipping_cost" value="{{ $purchase->shipping_cost }}">
				  </div>
				</div>


				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Note') }}</label>						
					<textarea class="form-control" name="note">{{ old('note') }}</textarea>
				  </div>
				</div>

				
				<div class="col-md-12">
				  <div class="form-group">
						<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
				  </div>
				</div>
			</div>
		</form>
	</div>
  </div>
 </div>
</div>
@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/purchase_order.js') }}"></script>
<script>	
(function($) {
    "use strict";
    
	update_summary();

	//Click Edit product
	$(document).on('click', '.edit-product', function() {
		var tr = $(this).parent().parent();
		current_row = tr;

		//Get current value
		var quantity = parseFloat($(tr).find(".quantity").html());
		var c_unit_cost = parseFloat($(tr).find(".unit-cost").html());
		var c_sub_total = parseFloat($(tr).find(".sub-total").html());
		var c_discount = parseFloat($(tr).find(".discount").html());
		var c_description = $(tr).children("td:first").find(".description").html().trim();
		//var c_tax_amount = parseFloat($(tr).find(".tax").html());
		var c_tax_method = $(tr).find(".input-tax-method").val();
		var c_tax_id = $(tr).find(".input-tax-id").val();

		var form = `<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${$lang_tax_method}</label>						
							<select class="form-control float-field" id="modal-tax_method">
								<option value="">${$lang_none}</option>
								<option value="inclusive">${$lang_inclusive}</option>
								<option value="exclusive">${$lang_exclusive}</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${$lang_unit_price}</label>						
							<input type="number" class="form-control" value="${ c_tax_method == 'exclusive' ? c_unit_cost : c_sub_total }" id="modal-unit_cost">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${$lang_quantity}</label>						
							<input type="number" class="form-control" value="${quantity}" id="modal-quantity">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${$lang_discount + ' ' +_currency}</label>						
							<input type="text" class="form-control float-field" value="${c_discount}" id="modal-discount">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${$lang_tax}</label>						
							<select class="form-control" id="modal-tax_id">
								<option value="">${$lang_no_tax}</option>
								@foreach(App\Tax::where("company_id",company_id())->get() as $tax)
									 <option value="{{ $tax->id }}" data-tax-type="{{ $tax->type }}" data-tax-rate="{{ $tax->rate }}">{{ $tax->tax_name }} - {{ $tax->type =='percent' ? $tax->rate.' %' : $tax->rate }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Description') }}</label>						
							<textarea class="form-control" id="modal-description">${c_description}</textarea>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<button type="button" id="update-product" class="btn btn-primary">${$lang_save}</button>
						</div>
					</div>`;

		$("#main_modal .modal-title").html($lang_update_product);
		$("#main_modal .modal-body").html(form);
		$("#modal-tax_method").val(c_tax_method);
		$("#modal-tax_id").val(c_tax_id);
		$("#main_modal").modal("show");

		$(document).on('change','#modal-tax_method',function(){
			if($(this).val() == 'inclusive'){
				$("#modal-unit_cost").val(c_sub_total);
			}else if($(this).val() == 'exclusive'){
				$("#modal-unit_cost").val(c_unit_cost);
			}
		});
		
	});

})(jQuery);	
</script>
@endsection


