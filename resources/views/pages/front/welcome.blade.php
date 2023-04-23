@extends('pages.front.master')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">@lang('site.promoted')</h4>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> # </th>
                <th> @lang('site.logo') </th>
                <th> @lang('site.coin') </th>
                <th> @lang('site.chain') </th>
                <th> @lang('site.symbol') </th>
                <th> @lang('site.marketcap') </th>
                <th> @lang('site.price') </th>
                <th> @lang('site.lunched_at') </th>
                <th> @lang('site.votes') </th>
                <th> @lang('site.vote') </th>

              </tr>
            </thead>
            <tbody>
                @foreach ($coins as $coin)
                    <tr>
                        <td class='text-center'>
                            <a href="{{route('coin.coin',$coin->id)}}">
                                {{$loop->iteration}}
                            </a>
                        </td>
                        <td class="py-1">
                            <a href="{{route('coin.coin',$coin->id)}}">
                                <img src="{{asset('uploads/'.$coin->logo)}}" alt="{{$coin->title}}" />
                            </a>
                        </td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}"> {{$coin->title}} </a></td>
                        <td class='text-center'>
                            <a href="{{route('coin.coin',$coin->id)}}" class='btn btn-sm btn-danger'>
                                {{$coin->network->symbol}}
                            </a>
                        </td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}">{{$coin->symbol}} </a></td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}">{{number_format($coin->marketcap)}} </a></td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}">{{$coin->price}} </a></td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}">{{$coin->lunched_at}} </a></td>
                        <td class='text-center'><a href="{{route('coin.coin',$coin->id)}}">{{$coin->votes->count()}} </a></td>
                        <td class='text-center'><a class="btn btn-success btn-sm">@lang('site.vote')</a></td>
                    </tr>
                @endforeach


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
