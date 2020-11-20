<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ route('lead_sources.store') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
    <div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Title') }}</label>						
			<input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
			<label class="control-label">{{ _lang('Name') }}</label>
			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
			<label class="control-label">{{ _lang('Description') }}</label>
			<input type="text" class="form-control" name="description" value="{{ old('description') }}" required>
			<div class="form-group">
				<label class="control-label">{{ _lang('Users') }}</label>						
				<select class="form-control select2" name="users[]" multiple="true">
					{{ create_option('users','id','name','',array('company_id=' => company_id())) }}
				</select>
			</div>
		</div>
	</div>

	<div class="col-md-12">
	    <div class="form-group">
	        <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		    <button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	    </div>
	</div>
</form>
