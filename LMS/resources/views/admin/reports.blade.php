@extends('layouts.app')
@section('title', 'LMS Reports')
@section('content')
<div class="content-header">
  <div class="container-fluid"><h1>Analytics reports</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row mb-4 text-center">
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary">{{ $totalEnrollments }}</h3><p class="text-muted mb-0">Total Enrollments</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary">{{ $avgProgress }}%</h3><p class="text-muted mb-0">Average Student Progress</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary">{{ $avgGpa }}</h3><p class="text-muted mb-0">Average GPA</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary">{{ $passRatio }}%</h3><p class="text-muted mb-0">Pass threshold ratio</p></div></div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Enrollments Level Breakdown</h3></div>
          <div class="card-body" style="height:250px"><canvas id="chart-levels" style="height:100%"></canvas></div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title">GPA Distribution</h3></div>
          <div class="card-body" style="height:250px"><canvas id="chart-gpa" style="height:100%"></canvas></div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new Chart(document.getElementById('chart-levels').getContext('2d'), {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_keys($levelData)) !!},
        datasets: [{
          label: 'Students Enrolled',
          data: {!! json_encode(array_values($levelData)) !!},
          backgroundColor: '#06b6d4'
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chart-gpa').getContext('2d'), {
      type: 'pie',
      data: {
        labels: {!! json_encode(array_keys($gpaData)) !!},
        datasets: [{
          data: {!! json_encode(array_values($gpaData)) !!},
          backgroundColor: ['#10b981', '#2563eb', '#f59e0b', '#f97316', '#ef4444']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  });
</script>
@endsection
