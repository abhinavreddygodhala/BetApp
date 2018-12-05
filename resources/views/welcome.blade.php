@extends('layouts.app')

@section('content')
    @php
    $cricketMatchesTxt = file_get_contents('https://cricapi.com/api/matches?apikey=vrncKDSNxPfmjk596fbb2Y794Pj2');
    $cricketMatches = json_decode($cricketMatchesTxt);

    @endphp

    <div class="container">
        @foreach($cricketMatches->matches as $item)
        <div class="row justify-content-center mb-4">

            <div class="col-md-8">

                    @if(!isset($item->winner_team)&& $item->matchStarted)
                <div class="card">
                    <div class="card-header">{{$item->{'team-1'} .' vs '. $item->{'team-2'}.' - '. $item->type }}</div>
                            @php
                             $score = file_get_contents('https://cricapi.com/api/cricketScore?apikey=vrncKDSNxPfmjk596fbb2Y794Pj2&unique_id='.$item->unique_id);
                             $matchscore = json_decode($score);
                            @endphp
                    <div class="card-body align-items-center ">
                        Toss Won By {{$item->toss_winner_team}}
                        <br><br>{{$matchscore->score}}
                        @if(Auth::check())

                        <a href="{{route('payment')}}" class="btn float-right btn-dark nav-link">Bet</a>
                            @endif
                    </div>

                    <div>

                        @endif


            </div>
        </div>
    </div>
    @endforeach

@endsection
