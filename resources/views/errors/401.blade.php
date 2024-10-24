@extends('Frontend.layouts.app')

@section('title', 401)
@section('content')
<main class="mainContent">
            <div class="errorPage bg-green">
                <div class="container">
                    <div class="errorPage__inner text-center">
                        <h1>401</h1>
                        <h3>{{__('labels.oops')}}</h3>
                        <p>{{__('labels.we_are_sorry')}}<br class="d-none d-sm-block">{{__('labels.we_are_sorry_a_page')}}</p>
                        <a class="btn btn-primary ripple-effect btn-lg mt-2" href="{{route('home')}}">{{__('labels.back_to_home')}}</a>
                    </div>
                </div>
            </div>
        </main>
@endsection
