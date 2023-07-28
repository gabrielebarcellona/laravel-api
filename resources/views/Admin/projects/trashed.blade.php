@extends('Admin.layouts.base')

@section('contents')

    @if (session('delete_success'))
    @php $project = session('delete_success') @endphp
    <div class="alert alert-danger">
        The project "{{ $project->title }}" has been Deleted
        {{-- <form
            action="{{ route("admin.project.cancel", ['project' => $project]) }}"
                method="post"
                class="d-inline-block"
            >
            @csrf
            <button class="btn btn-warning">Calcel</button>
        </form> --}}
    </div>
    @endif

    @if (session('restore_success'))
        @php $project = session('restore_success') @endphp
        <div class="alert alert-success">
            The project "{{ $project->title }}" has been Restored
        </div>
    @endif

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Creation Date</th>
                <th scope="col">Last Update</th>
                <th scope="col">Collaborators</th>
                <th scope="col">Description</th>
                <th scope="col">Languages</th>
                <th scope="col">Link Github</th>
                <th class="w-25" scope="col">   </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trashedProjects as $project)
                <tr>
                    <th scope="row">{{ $project->title }}</th>
                    <td>{{ $project->author }}</td>
                    <td>{{ $project->creation_date }}</td>
                    <td>{{ $project->last_update }}</td>
                    <td>{{ $project->collaborators }}</td>
                    <td>{{ $project->description }}</td>
                    <td>
                        @foreach ($project->languages as $language)
                            <a href="{{ route('admin.language.show', ['language' => $language])}}">{{ $language->name }}</a>
                        @endforeach
                    </td>
                    <td>{{ $project->link_github }}</td>
                    <td>
                        <form class="d-inline-block" method="POST" action="{{ route('admin.project.restore', ['project' => $project]) }}">
                            @csrf
                            <button class="btn btn-warning">Restore</button>
                        </form>
                        <button type="button" class="btn btn-danger js-delete d-inline-block" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $project->slug }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade text-dark" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form
                        action=""
                        data-template="{{ route('admin.project.harddelete', ['project' => '*****']) }}"
                        method="post"
                        class="d-inline-block"
                        id="confirm-delete"
                    >
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection