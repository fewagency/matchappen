@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h2>Opublicerade {{ trans_choice('workplace.workplace', 2) }} att godkänna</h2>
  @include('workplace.partials.list', ['workplaces' => $new_workplaces])

  <h2>Opublicerade {{ trans_choice('workplace.workplace', 2) }}</h2>
  @include('workplace.partials.list', ['workplaces' => $unpublished_workplaces])

@endsection