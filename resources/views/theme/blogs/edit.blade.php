@extends('theme.master')
@section('title', 'Edit Blog')

@section('content')
@include('theme.partials.hero', ['title' => 'Edit Blog => '. $blog->name])
<!-- ================ contact section start ================= -->
<section class="section-margin--small section-margin">
    <div class="container">
        <div class="row">
        <div class="col-12">
            <form action="{{route('blogs.update',['blog' => $blog])}}" class="form-contact contact_form" method="post" id="contactForm" novalidate="novalidate" enctype="multipart/form-data">
                @if(session('success'))
                <div class="alert alert-success text-center mx-auto w-50">{{ session('success') }}</div>
                @endif
                @csrf
                @method('PUT')
            <div class="form-group">
                <input class="form-control border text-primary " name="name" value="{{ $blog->name }}" type="text" placeholder="Enter blog name">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="form-group">
                <input class="form-control border text-primary " name="image" type="file" placeholder="Upload blog image">
                <x-input-error :messages="$errors->get('image')" class="mt-2 text-danger" />
            </div>
            <div class="form-group">
                <select class="form-control border text-primary " name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($blog->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-danger" />
            </div>
            <div class="form-group">
                <textarea class="form-control border text-primary " name="description" placeholder="Enter blog description">{{ $blog->description }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2 text-danger" />
            </div>
            <div class="form-group text-center text-md-right mt-3">
                <button type="submit" class="button button--active button-contactForm">Submit</button>
            </div>
            </form>
        </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->

@endsection
