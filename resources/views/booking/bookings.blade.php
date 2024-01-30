@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

   

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bookings</h5>
              

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Booking Date</th>
                    <th scope="col">Research Topic</th>
                    <th scope="col">Discipline</th>
                    <th scope="col">Level of Research</th>
                    <th scope="col">Problem Description</th>
                    <th scope="col">service</th>
                    <th scope="col">Amount paid</th>
                    <th scope="col">Booking status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Add to calendar</th>
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)

                <tr>

                    <th scope="row">{{ $rec->userId }}</th>
                    <td>{{ $rec->firstName }}</td>
                    <td>{{ $rec->lastName }}</td>
                    <td>{{ $rec->email }}</td>
                    <td>{{ $rec->phoneNumber }}</td>
                    <td>{{ $rec->bookingDate }}</td>
                    <td>{{ $rec->researchTopic }}</td>
                    <td>{{ $rec->discipline }}</td>
                    <td>{{ $rec->levelOfResearch }}</td>
                    <td>{{ $rec->problemDescription }}</td>
                    <td>{{ $rec->service }}</td>
                    <td>{{ $rec->amountPayed }}</td>
                    <td>{{ $rec->bookingStatus }}</td>
                    <td><a href="{{ route('booking.edit', $rec->bookingId) }}" class="btn btn-info">Edit</a></td>
                    <td><a href="" class="btn btn-info">Add to calendar</a></td>
                    
              
              
             </tr>
             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection