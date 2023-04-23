@extends('pages.front.master')
@section('content')
 <section class="search">
    <div class="container">
        <div class="row flex-sm-row-reverse-2">

            <div class="col-lg-2">
                {{-- <div class="search-at">
                    <h5 class="mb-3">@lang('site.filter_results')</h5>
                    @livewire('filter-ads')
                </div> --}}
            </div>


            <div class="col-lg-9">
                <div class="search-card">
                    <div class="row">

                        @livewire('home.search-form')
                        <div class="col-lg-2 col-md-1"> </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="d-grid gap-2">
                                <x-create-ad-button/>
                            </div>

                        </div>
                    </div>

                    @if(session('success_message'))
                        <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                            {{session('success_message')}}
                        </div>
                    @endif
                    @livewire('home-filter-ads')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
