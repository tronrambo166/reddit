@extends('layout') 
@section('page')



<div class="row " style="background: #e5efef;">  
         <div class="col-md-3"> 
            <h3 class="text-center">Top 20 Songs:</h3> <hr>

            <table class="table tabil">
  <thead>
    <tr>
      <th scope="col">Position</th>
      <th scope="col">Artist</th>
      <th scope="col">Song</th>
      <th scope="col">Move</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="text-center">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr class="bg-light">
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

             </div>  

         <div class="col-md-3"> </div>
           <div class="col-md-6 text-center">
             <h3 class="text-center">Recent Most Popular Content for Koffi</h3>

             <p class="text-center">
             Click <a class="d-inline text-info" href="">Breakdown</a> for Station and timings</p>

             <hr>
             <p>Your Rank today! <a href=""class="text-danger">1</a></p>

             <p>Your Plays this week! <a href=""class="text-danger">11</a></p>


             <p class="mt-5 w-50 rounds mx-auto bg-light px-4 py-1">Andrada</p>

              <p class="mt-2 w-50 rounds mx-auto  px-4 py-1">Andrada</p>

              <p class="mt-2 w-50 rounds mx-auto bg-light px-4 py-1">Andrada</p>


              <p class="mt-2 w-50 rounds mx-auto  px-4 py-1">Andrada</p>

           </div>    
          
</div>



          @endsection
        
       

