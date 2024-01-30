@extends('layouts.app-master')

@section('content')


<div class="card">
            <div class="card-body">

    <div class="bg-light p-4 rounded">

        <div class="container mt-4">
         
      <section class="section">
      <div class="row">
        <div class="col-lg-12">

         <div class="">
            <div class="">
           
            <br>
            <br>
              
        
              <div class="row">
        

              <div class="col-md-2">

             </div>




<div class="col-md-6">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update details / Change Password</h5>

              

                     <!-- Default Accordion -->
                     <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     Update Details
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $user->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ $user->email }}"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ $user->username }}"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" 
                        name="role" required>
                       
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ in_array($role->name, $userRole) 
                                    ? 'selected'
                                    : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>


                <label for="email" class="form-label">Branch</label>

<select class="form-control" name="branchId" required> 
 <option value="{{ $user->branchId }}">Selected</option> 
 @foreach ($branches as $key => $value) 

<option value="{{ $key }}"> {{ $value }}

</option>
  @endforeach 
 
 </select>

 <br>
                <button type="submit" class="btn btn-primary">Update user</button>
             
            </form>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Update Password
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      
                    <form method="post" action="{{ route('users.changepassword') }}">
                     @csrf
               
              
                <div class="mb-3">
                    <label for="username" class="form-label">New Password</label>
                    <input value=""
                        type="text" 
                        class="form-control" 
                        name="password" 
                        placeholder="password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
             

                <button type="submit" class="btn btn-primary">Update Password</button>
             
            </form>

                    </div>
                  </div>
                </div>

              </div><!-- End Default Accordion Example -->
                

            <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                
            <div class="container">
         






                </div>
                
           </div><!-- End Bordered Tabs -->

                
             
               
              </div><!-- End Bordered Tabs -->



                </div>
               
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

</div>





        </div>

          </div>
          </div>
             
        </div>
      </div>
    </section>














    </div>

</div>
        </div>

    </div>

@endsection
