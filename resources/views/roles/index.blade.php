@extends('layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded card">
        <h1>Roles</h1>
        <div class="lead">
                
            @if(auth()->user()->can('roles.create') )
           
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Add role</a>
            <br>
       @endif



        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-bordered ">
          <tr>
             <th width="1%">#</th>
             <th>Company Name</th>
             <th>Role Name</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{$loop->iteration}}</td>
                
                <td>{{ $role->companyName }}</td>

                <td>{{ $role->name }}</td>

                @if(auth()->user()->can('roles.show') )
            
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">Show</a>
                
                </td>
    
          
          
                @endif


       @if(auth()->user()->can('roles.edit') )
            
          <td>
     <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">Edit</a>
               
            @endif

            
            @if(auth()->user()->can('role.clone') )
            
            <td>
                <a class="btn btn-success btn-sm" href="{{ route('role.clone', $role->id) }}">Clone</a>
                </td>


                @if(auth()->user()->can('roles.destroy') )
            
           
            <td>
                  {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                  {!! Form::close() !!}
              </td>
  
          @endif

          @endif
   

          

            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $roles->links() !!}
        </div>

    </div>
@endsection
