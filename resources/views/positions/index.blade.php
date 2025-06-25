@extends('layouts.app')

@section('content')
<div class="container">



     <div class="d-flex justify-content-center mb-5">

         <h1>Organizational Chart Management</h1>

    </div>
    <!-- Form Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Create/Assign Position</h2>
        </div>
        <div class="card-body">
            <form id="positionForm">
                @csrf
                <input type="hidden" id="positionId">

                <div class="form-group mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback" id="nameError"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="reports_to">Reports to:</label>
                    <select class="form-control" id="reports_to" name="reports_to">
                        <option value="">-- Select Supervisor --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="reportsToError"></div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>



    <!-- Table Section -->
    <div class="card">
        <div class="card-header">
            <h2>Positions</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="positionsTable">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Reports To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $position)
                            <tr data-id="{{ $position->id }}">
                                <td>{{ $position->name }}</td>
                                <td>{{ $position->parent->name ?? '' }}</td>
                                <td>
                                    <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $position->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for handling form submission -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#positionForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: '/api/positions',
        type: 'POST',
        data: {
            name: $('#name').val(),
            reports_to: $('#reports_to').val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Position created successfully!');
            console.log(response);
            $('#positionForm')[0].reset(); // optional reset
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON;
                let message = '';
                for (let field in errors) {
                    message += errors[field] + '\n';
                }
                alert(message);
            } else {
                alert('An unexpected error occurred.');
            }
        }
    });
});
</script>


<script>
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();

    if (!confirm('Are you sure you want to delete this position?')) return;

    let positionId = $(this).data('id');

    $.ajax({
        url: '/api/positions/' + positionId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Needed if CSRF protection is enabled
        },
        success: function(response) {
            alert('Position deleted successfully.');
            // You can either remove the DOM element or reload the page
            location.reload(); // or $(this).closest('tr').remove() for table rows
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON?.error) {
                alert(xhr.responseJSON.error);
            } else {
                alert('An error occurred while deleting the position.');
            }
        }
    });
});
</script>



@endsection
