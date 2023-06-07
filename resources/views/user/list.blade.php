<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			 <a href="{{ route('dashboard') }}" class="btn btn-primary"> {{ __('Dashboard') }} </a>    

            <a href="{{ route('user.index') }}" class="btn btn-primary"> {{ __('User List') }}</a>
		</h2>
	</x-slot>
	@if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
	<div class="py-12">
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-1"><a href="{{ route('user.create') }}" class="btn btn-info">Add New User</a></div>
		</div>
		<br>
		
		<div class="max-w-12xl mx-auto sm:px-12 lg:px-12">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-12 text-gray-900">
					<table class="table">
						<thead>
							<tr>
								<th>S no.</th>
								<th>Firstname</th>
								<th>Lastname</th>
								<th>Email</th>
								<th>Country</th>
								<th>State</th>
								<th>City</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)

							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $user->first_name ?? '' }}</td>
								<td>{{ $user->last_name ?? '' }}</td>
								<td>{{ $user->email ?? ''}}</td>
								<td>{{ $user->country->name ?? '' }}</td>
								<td>{{ $user->state->name ?? '' }}</td>
								<td>{{ $user->city->name ??'' }}</td>
								<td>
									<a href="{{ route('user.update_status',$user->id) }}" class="btn btn-{{ $user->is_active?'success':'danger' }}">{{ $user->is_active?'Active':'Inactive' }}</a>
								</td>
								<td>
									<a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning">Edit</a>
									<a href="#" onClick="deleteUser('{{ $user->id }}')" class="btn btn-danger">Delete</a>

									<form id="delete{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
								</td>
							</tr>

							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		function deleteUser(userId) {
			if (confirm('Are you sure you want to delete this user?')) {
				document.getElementById('delete' + userId).submit();
			}
		}
	</script>
</x-app-layout>
