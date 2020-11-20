<form method="post" id="expense" class="ajax-submit" autocomplete="off" action="{{route('expense.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}

	<div class="col-12">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Expense Number')}}</label>						
				<input type="text" class="form-control float-field" name="expense_num" value="{{ old('expense_num') }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">					
					<label class="control-label">{{ _lang('Supplier') }}</label>						
					<select class="form-control select2-ajax" data-value="id" data-display="supplier_name" data-table="suppliers" data-where="1" name="supplier_id" required>
							<option value="">{{ _lang('Select One') }}</option>
					</select>	
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
				<!-- <a href="{{ route('products.create') }}" data-reload="false" data-title="{{ _lang('Add Product') }}" class="ajax-modal select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a> -->
					<label class="control-label">{{ _lang('Expense Type') }}</label>
					<!-- <select class="form-control select2-ajax" data-value="id" data-display="supplier_name" data-table="suppliers" data-where="1" name="supplier_id" required>						 -->
					<select class="form-control select2-ajax" data-value="id" data-display="type" data-table="chart_of_accounts" data-where="1" name="expense_type" id="expense_type">
						<option value="">{{ _lang('Select One') }}</option>
					</select>
				</div>
			</div>	

			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">{{ _lang('Expense Date') }}</label>						
					<input type="text" class="form-control datepicker" name="order_date" value="{{ old('order_date') }}" readOnly="true" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
				<label class="control-label">{{ _lang('Due Date') }}</label>						
				<input type="text" class="form-control datepicker" name="due_date" value="{{ old('due_date') }}" readOnly="true" required>
				</div>
			</div>	

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Related To') }}</label>						
				<select class="form-control select2 auto-select" data-selected="{{ isset($_GET['related_to']) ? $_GET['related_to'] : 'contacts' }}" name="related_to" id="related_to">
					<option value="lead">{{ _lang('Lead') }}</option>
				   <option value="lead_source">{{ _lang('Lead Source') }}</option>
				   <option value="contacts">{{ _lang('Customer') }}</option>
				   <option value="projects">{{ _lang('Project') }}</option>				   
				</select>
			  </div>
			</div>

            <div class="col-md-6 d-none" id="lead">
			  <div class="form-group">
				<!-- <a href="{{ route('contacts.create') }}" data-reload="false" data-title="{{ _lang('Add Client') }}" class="ajax-modal-2 select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a> -->
				<label class="control-label">{{ _lang('Lead') }}</label>						
				<select class="form-control select2-ajax" data-value="id" data-display="name" data-table="leads" data-where="1" name="lead">
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ create_option("leads","id","name",old('lead'),array("company_id="=>company_id())) }}
				</select>

			  </div>
			</div>
            
			<div class="col-md-6 d-none" id="lead_source">
			  <div class="form-group">
				<!-- <a href="{{ route('contacts.create') }}" data-reload="false" data-title="{{ _lang('Add Client') }}" class="ajax-modal-2 select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a> -->
				<label class="control-label">{{ _lang('Lead Source') }}</label>						
				<select class="form-control select2-ajax" data-value="id" data-display="title" data-table="lead_sources" data-where="1" name="lead_sources">
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ create_option("lead_sources","id","title",'',array("company_id="=>company_id())) }}
				</select>
			  </div>
			</div>

			<div class="col-md-6 d-none" id="contacts">
			  <div class="form-group">
				<a href="{{ route('contacts.create') }}" data-reload="false" data-title="{{ _lang('Add Client') }}" class="ajax-modal-2 select2-add"><i class="ti-plus"></i> {{ _lang('Add New') }}</a>
				<label class="control-label">{{ _lang('Customer') }}</label>						
				<select class="form-control select2-ajax" data-value="id" data-display="contact_name" data-table="contacts" data-where="1" name="payer_payee_id">
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ create_option("contacts","id","contact_name",old('payer_payee_id'),array("company_id="=>company_id())) }}
				</select>
			  </div>
			</div>

			<div class="col-md-6 d-none" id="projects">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Select Project') }}</label>						
				<select class="form-control select2" name="project_id">
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ create_option('projects','id','name',isset($_GET['project_id']) ? $_GET['project_id'] : '' ,array('company_id=' => company_id())) }}
				</select>
			  </div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Tax')}}</label>						
				<input type="text" class="form-control float-field" name="tax" value="{{ old('tax') }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('ToTal')}}</label>						
				<input type="text" class="form-control float-field" name="total" value="{{ old('tatal') }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Attachemnt') }}</label>						
				<input type="file" class="form-control trickycode-file" name="attachemnt">
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
				<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
				<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
			  </div>
			</div>
		</div>
	</div>
</form>	