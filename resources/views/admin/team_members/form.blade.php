@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="row">
    <div class="col">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="card">
            <h4 class="card-header">
                @if (isset($team_member))
                Update Team Member
                @else
                Add new Team Member
                @endif
            </h4>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ isset($team_member) ? route('team-members.update', $team_member->id) : route('team-members.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($team_member))
                    @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="version">Name</label>
                        <input class="form-control" type="text" required name="name" value="{{ old('name', isset($team_member) ? $team_member->name : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Position</label>
                        <input class="form-control" type="text" required name="position" value="{{ old('position', isset($team_member) ? $team_member->position : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Quote</label>
                        <textarea class="form-control" required name="quote_body">{{ old('quote_body', isset($team_member) ? $team_member->quote_body : '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="version">Quote by</label>
                        <input class="form-control" type="text" required name="quote_by" value="{{ old('quote_by', isset($team_member) ? $team_member->quote_by : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="team_id">Team</label>
                        <select class="form-control" name="team_id">
                            @foreach ($teams as $team)
                            @php
                            $selected = isset($team_member) && $team_member->team_id == $team->id ? 'selected' : '';
                            @endphp
                            <option value="{{ $team->id }}" {{ $selected }}>{{$team->name}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="version">Hierarchy</label>
                        <input class="form-control" type="number" step="0.01" required name="hierarchy" value="{{ old('hierarchy', isset($team_member) ? $team_member->hierarchy : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="image_file">Image</label>
                        <input class="form-control" type="file" accept="image/*" name="image_file" value="{{ old('image_file', isset($team_member) ? $team_member->image_file : '') }}">
                        @if(isset($team_member) && $team_member->image_url)
                        <br/>
                        <img src="{{ $team_member->image_url }}" width="100" class="rounded img-thumbnail">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
@endsection 