@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                @if (isset($addon))
                Update Add-On
                @else
                Add new Add-On
                @endif
            </h4>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ isset($addon) ? route('addons.update', $addon->id) : route('addons.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($addon))
                    @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="name">Add-On Name</label>
                        <input class="form-control" type="text" required name="name" value="{{ old('name', isset($addon) ? $addon->name : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Add-On Settings Title</label>
                        <input class="form-control" type="text" required name="addon_settings_title" value="{{ old('addon_settings_title', isset($addon) ? $addon->addon_settings_title : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Add-On Description</label>
                        <textarea class="form-control" required name="description">{{ old('description', isset($addon) ? $addon->description : '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="wistia_video_id">Add-On Wistia Video ID</label>
                        <input class="form-control" type="text" required name="wistia_video_id" value="{{ old('wistia_video_id', isset($addon) ? $addon->wistia_video_id : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="cost">Add-On Cost</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input class="form-control" type="number" placeholder="0.00" required name="cost" value="{{ old('cost', isset($addon) ? $addon->cost : '') }}" step="any">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="conversion_rate">Add-On Conversion Rate</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                            </div>
                            <input class="form-control" type="number" placeholder="0.00" required name="conversion_rate" value="{{ old('conversion_rate', isset($addon) ? $addon->conversion_rate : '') }}" step="any">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category">
                            @foreach ([
                                'Cart Maximizers',
                                'Conversion Triggers',
                                'Loyalty Builders',
                                'Shopping Enhancers' ,
                                'Shop Protectors',
                            ] as $category)
                            @php
                            $selected = isset($addon) && $addon->category == $category ? 'selected' : '';
                            @endphp
                            <option value="{{ $category }}" {{ $selected }}>{{$category}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="icon_file">Icon</label>
                        <input class="form-control" type="file" accept="image/*" name="icon_file" value="{{ old('icon_file', isset($addon) ? $addon->icon_file : '') }}">
                        @if(isset($addon) && $addon->icon_url)
                        <br/>
                        <img src="{{ $addon->icon_url }}" width="100" class="rounded img-thumbnail">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
