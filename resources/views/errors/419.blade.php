@extends('layouts.frontend')

@section('content')
<main id="main" class="main">
    <section class="section dashboard">
        <div class="container d-flex justify-content-center align-items-center" style="height: 55vh;">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="mb-5">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <div class="logo d-flex align-items-center justify-content-center w-auto">
                                    <img src="{{ asset('ddmodelslogo.png') }}" width="40%" alt="...">
                                </div>
                            </div>
                            <br/><br/>
                            <p style="font-weight:bold;color:#058;font-size:16px">{{ __('Ooops!!! Please refresh the page to continue. Click the button below.') }}</p>
                            <br />
                            <a href="{{ url('/dashboard') }}" type="submit" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748"
                                class="btn btn-danger">{{ __('Refresh Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
 