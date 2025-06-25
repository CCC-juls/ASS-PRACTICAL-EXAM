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
                    <input type="text" class="form-control" id="position_id" name="position_id" value="{{ $position->id }}"
                        hidden />
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ $position->name }}" />
                    <div class="invalid-feedback" id="nameError"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="reports_to">Reports to:</label>
                    @php
                        $selectedId = $position->reports_to ?? old('reports_to');
                    @endphp

                    <select class="form-control" id="reports_to" name="reports_to">
                        <option value="">-- Select Supervisor --</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}" @if ($selectedId == $position->id) selected @endif>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="reportsToError"></div>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>


    </div>

    <!-- JavaScript for handling form submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#positionForm').on('submit', function(e) {
            e.preventDefault();

            let positionId = $('#position_id').val();

            $.ajax({
                url: '/api/positions/' + positionId,
                type: 'PUT',
                data: {
                    name: $('#name').val(),
                    reports_to: $('#reports_to').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Position updated successfully!');

                    window.location.href = '/positions';

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors || xhr.responseJSON;
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
@endsection
