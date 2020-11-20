<div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#detail">Lead Source details</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Expense </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Edit</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="detail" class="container tab-pane active"><br>
		<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ action('LeadSourceController@update', $id) }}" enctype="multipart/form-data">
			{{ csrf_field()}}
			<input name="_method" type="hidden" value="PATCH">				
			
			<div class="col-md-12">
				<div class="form-group">
					<table class="table table-bordered">
					<tr>
						<td><label class="control-label">{{ _lang('Title') }}</label></td>
						<td><label class="control-label">{{ $leadsource->title }}</label></td>
					</tr>
					<tr>
						<td><label class="control-label">{{ _lang('Description') }}</label></td>
						<td><label class="control-label">{{ $leadsource->description }}</label></td>
					</tr>
					<tr>
						<td><label class="control-label">{{ _lang('Users') }}</label></td>
						<td>
							@foreach($leadsource_users as $leadsource_user)
								@if($leadsource->id == $leadsource_user->leadsource->id)
									<img src="{{asset('public/uploads/profile').'/'.$leadsource_user->user->profile_picture}}" class="project-avatar" data-toggle="tooltip" data-placement="top" title="{{$leadsource_user->user->name}}">
								@endif
							@endforeach
						</td>
					</tr>
					<tr>
						<td><label class="control-label">{{ _lang('Leads') }}</label></td>
						<td><label class="control-label">{{ $leads->count() }}</label></td>
					</tr>
					<tr>
						<td><label class="control-label">{{ _lang('Turnover') }}</label></td>
						<td><label class="control-label"></label></td>
					</tr>
					</table>
				</div>
			</div>
		</form>      
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
		<div class="col-12">
			<a class="btn btn-primary btn-xs ajax-modal" data-title="{{ _lang('Add New') }}" href="{{ route('lead_sources.index') }}"><i class="ti-plus"></i> {{ _lang('Add New') }}</a>
				
			<div class="card mt-2">
				<span class="d-none panel-title">{{ _lang('List Expense') }}</span>
				
				<div class="card-body">
					<table id="expense-table" class="table table-bordered">
						<thead>
							<tr>
								<th>{{ _lang('Supplier Name') }}</th>
								<th>{{ _lang('Chart of Account') }}</th>
								<th>{{ _lang('Grant Total') }}</th>
								<th>{{ _lang('Date') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($purchase_orders as $purchase_order)
								<tr>
									<td class='supplier_name'>{{ $purchase_order->supplier->supplier_name }}</td>
									<td class='chart_account'>{{ $purchase_order->chartofaccount->name}}</td>
									<td class='grant_total'>{{ $purchase_order->grand_total }}</td>
									<td class='date'>{{ $purchase_order->order_date }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
      
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Menu 2</h3>
      
    </div>
  </div>
</div>
