@extends('layouts.app')
@section('title', 'Calendar')
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
@endsection
@section('content')
<div class="content-header">
  <div class="container-fluid"><h1>Academic Scheduler</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="calendar-element"></div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('plugins/fullcalendar/main.min.js') }}"></script>
<script>
  $(document).ready(function() {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar-element'), {
      themeSystem: 'bootstrap',
      initialView: 'dayGridMonth',
      events: [
        { title: 'Portfolio Project Deadline', start: '2026-07-15', color: '#ef4444' },
        { title: 'JavaScript To-Do Due', start: '2026-07-10', color: '#ef4444' },
        { title: 'Midterm Assessment', start: '2026-07-22', color: '#7c3aed' }
      ]
    });
    calendar.render();
  });
</script>
@endsection
