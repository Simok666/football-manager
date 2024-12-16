@extends('layout.admin')
@section('title', 'Add Schedule Management')    
@section('title_page', 'Add Schedule Management')
@section('desc_page', '')
@section('content')
<div class="container-fluid">
<div class="row">
 <div class="col-12">
    <div class="card mb-4">
    <div class="card-header">
        <form id="form-add-schedulemanagement">
            <div class="form-group">
                <label for="activityTitle">Event Title</label>
                <input type="hidden" name="repeater[0][event_name]" class="form-control"  value="add_event">
                <input type="hidden" name="repeater[0][new_id]" class="form-control" data-bind-id value="null">
                <input type="text" name="repeater[0][activity]" class="form-control" id="activityTitle" placeholder="Add title" required>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="activityDate">Date</label>
                        <input type="date" name="repeater[0][date_activity]" class="form-control" id="activityDate" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="activityTime">Start Time</label>
                        <input type="time" name="repeater[0][time_start_activity]" class="form-control" id="activityTime" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="activityTime">End Time</label>
                        <input type="time" name="repeater[0][time_end_activity]" class="form-control" id="activityTime" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="activityDescription">Location</label>
                    <textarea class="form-control" name="repeater[0][location]" id="activityDescription" rows="3" placeholder="Add Location" required></textarea>
                </div>
        </form>
        <button type="submit" class="btn btn-primary" form="form-add-schedulemanagement" id="saveActivity">Save</button>
    </div>
    </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
    <script>
        $("#form-add-schedulemanagement").on('submit', function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdateSchedule`;
                const data = new FormData(this);
                
                ajaxDataFile(url, 'POST', data, function(resp) {
                    toast("Data has been saved");
                    setTimeout(function() {
                        window.location.href = "{{ url('schedule.html') }}";  
                    }, 1000);
                }, function(data) {
            
                });
            });
    </script>
@endsection