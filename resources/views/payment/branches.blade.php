@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">


        <section class="wrapper">
    <div class="container-fostrap">
       

        <div class="content">
            <div class="container">
                <div class="row">


                @foreach ($records as $rec)
              
                   
                        <div class="col-xs-12 col-sm-4">
                        <div class="card">
                            <a class="img-card" href="{{ route('hivapay.login', $rec->branchId) }}">
                            <img src="/assets/img/branch.jpg" />
                          </a>
                            <div class="card-content">
                                <h4 class="card-title">
                                    <a href="{{ route('hivapay.login', $rec->branchId) }}">{{ $rec->branchName }}
                                  </a>
                                </h4>
                                <p class="">
                                    
                                </p>
                            </div>

                            @if(auth()->user()->can('hivapay.login') )

                            


                            @if(session()->has('branchId') && session('branchId')==$rec->branchId  ) 
                
                            
                            <div class="card-read-more">
                                <a href="{{ route('hivapay.logout', $rec->branchId) }}" class="btn btn-link btn-block">
                                    Logout
                                </a>
                            </div>
                           
                          @else
                    

                          
                 <div class="card-read-more">
                                <a href="{{ route('hivapay.login', $rec->branchId) }}" class="btn btn-link btn-block">
                                    Login
                                </a>
                            </div>
                            @endif

                            @endif
                        </div>
                    </div>
             




             @endforeach





                 
                  
           
                </div>
            </div>
        </div>
    </div>
</section>








        </div>
      </div>
    </section>





   
    </div>

@endsection













