@extends('theme.master')
@section('title', 'My Blogs')

@section('content')
@include('theme.partials.hero', ['title' => 'My Blogs'])
<!-- ================ contact section start ================= -->
<section class="section-margin--small section-margin">
    <div class="container">
        <div class="row">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success text-center mx-auto w-50">{{ session('success') }}</div> 
            @elseif(session('error'))
            <div class="alert alert-danger text-center mx-auto w-50">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Blog Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td>{{ $blog->name }}</td>
                        <td>{{ $blog->category->name }}</td>
                        <td class="text-center"><img src="{{ asset('storage/'.$blog->image) }}" width="100px"></td>
                        <td>
                            <a href="{{ route('blogs.edit', ['blog' => $blog]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('blogs.destroy', ['blog' => $blog]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->

@endsection
