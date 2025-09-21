@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

  <section class="pt-25" style="background-color: #e9f8ec; padding-top: calc(4rem + 56px);">
      <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 style="font-size: 30px; font-family: 'Poppins', sans-serif;" class="fw-bold mb-4">Connect With An Artisan Today!</h1>
                <p class="lead mb-5">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit aperiam, repellendus
                    placeat ab quam soluta? Suscipit laudantium maiores
                    reiciendis labore quidem iure iusto voluptatem. Ipsam qui distinctio expedita quod ea!
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="btn btn-success btn-lg px-4">Hire an artisan</a>
                    <a href="#" class="btn btn-outline-success btn-lg px-4">Offer your skills</a>
                </div>
            </div>

            <div class="col-md-5 d-flex justify-content-center justify-content-md-end mt-4 mt-md-0 ">
                <img src="{{ asset('Images/Melanie.png')}}" alt="artisans" style="max-width: 90%; max-height: 380px; height: auto; ">
            </div>
        </div>
      </div>
  </section>

@endsection
