@extends('layout.admin')
@section('title', 'Attendance Participants')    
@section('title_page', 'Attendance Participants')
@section('desc_page', '')
@section('content')
<div class="row">
<div class="col-12">
    @include('components.table-pagenation', ['table' => 'participantsAttendance' , 'url' => '/api/v1/getSchedule', 'headerTitle' => 'Attendance Participants Table' , 'headers' => [
            "Name Activity",
            "Date Activity",
            "Time Start Activity",
            "Time End Activity",
            "Location",
            "Documentation",
            "Action"
        ] , 'pagination' => true])
</div>
</div>
@endsection

@section('scripts')
        <script>
            $(document).ready(function() {
                GetData(req,"userAttendance", formatattendance);
            });
        </script>
@endsection