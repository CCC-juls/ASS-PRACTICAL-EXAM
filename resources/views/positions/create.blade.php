@extends('layouts.app')

@section('content')

<!-- Form Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Add/Edit Position</h2>
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
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $position->id }}">Edit</button>
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

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#positionForm').on('submit', function (e) {
            e.preventDefault();

            // Clear previous error state
            $('#name').removeClass('is-invalid');
            $('#nameError').text('');

            // Gather form data
            let formData = {
                name: $('#name').val(),
            };

            // Laravel expects CSRF even on API sometimes (especially if behind web middleware)
            let token = $('input[name="_token"]').val();

            $.ajax({
                url: '/api/positions-store', // Make sure this is the correct route
                method: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                success: function (response) {
                    alert('Position saved successfully!');
                    $('#positionForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                            $('#nameError').text(errors.name[0]);
                        }
                    } else {
                        alert('Something went wrong. Check console.');
                        console.error(xhr);
                    }
                }
            });
        });
    });
</script>

@endsection
