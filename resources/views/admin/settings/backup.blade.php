@extends('admin.layouts.master')
{{-- @section('settings_menu', 'menu-open') --}}
@section('backup', 'active')
@section('title') Admin| Backup @endsection

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Backup') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Backup') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-lg-7 col-xl-6">
                    <div class="row d-flex">
                        <div class="col-xl-6 mb-4 mb-0">
                            <div class="position-relative">
                                <a onclick="return confirm('Are you really sure to proceed ?')" href="{{route('admin.settings.download.database')}}" class="stretched-link d-block py-3 border rounded-lg shadow-sm border-light border-light-subtle p-4 bg-white  w-100">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-export">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                                                <path d="M4 6v6c0 1.657 3.582 3 8 3c1.118 0 2.183 -.086 3.15 -.241" />
                                                <path d="M20 12v-6" />
                                                <path d="M4 12v6c0 1.657 3.582 3 8 3c.157 0 .312 -.002 .466 -.005" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16l3 3l-3 3" /></svg>
                                        </div>
                                        <h5>Download Database</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="position-relative">
                                <a onclick="return confirm('Are you really sure to proceed ?')" href="{{route('admin.settings.download.project')}}" class="stretched-link d-block py-3 border rounded-lg shadow-sm border-light border-light-subtle p-4 bg-white  w-100">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-devices-code">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M13 15.5v-6.5a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v4m0 6a1 1 0 0 1 -1 1" />
                                                <path d="M18 8v-3a1 1 0 0 0 -1 -1h-13a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h7" />
                                                <path d="M20 21l2 -2l-2 -2" />
                                                <path d="M17 17l-2 2l2 2" />
                                                <path d="M16 9h2" /></svg>
                                        </div>
                                        <h5>Download Website</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">Manage Backup</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#backupModal">Add New</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table id="dataTables" class="table table-striped table-hover text-nowrap jsgrid-table">
                                <thead>
                                    <tr>
                                        <th width="15%">Date & Time</th>
                                        <th width="15%">Backup Item</th>
                                        <th width="15%">Remaining</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['rows'] as $key => $row)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($row->date)->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $row->item == 'db' ? 'Database' : ($row->item == 'project' ? 'Project' : '') }}</td>
                                        <td>
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $rowDate = \Carbon\Carbon::parse($row->date);
                                            
                                                if ($rowDate->gt($now)) {
                                                    $diffInHours = $rowDate->diffInHours($now);
                                                    $diffInMinutes = $rowDate->diffInMinutes($now) % 60; // Get remaining minutes after full hours
                                                    $remainingTime = $diffInHours . ' hours ' . $diffInMinutes . ' minutes';
                                                } else {
                                                    $remainingTime = '0 hours 0 minutes';
                                                }
                                            @endphp
                                            {{ $remainingTime }}
                                        </td>
                                        <td>
                                            @if ($row->status != 1)
                                            <span class="badge badge-warning">In Progress</span>
                                            @else
                                            <span class="badge badge-success">Complete</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="4">No Records Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end px-4 py-3">
                                {{ $data['rows']->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="backupModal" tabindex="-1" role="dialog" aria-labelledby="backupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backupModalLabel">Schedule Backup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="backupForm" action="{{route('admin.settings.schedule.backup')}}" method="POST">
                    @csrf
                    <!-- Backup Date & Time Field -->
                    <div class="form-group">
                        <label for="backupDateTime">Backup Date & Time <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="backupDateTime" name="backup_datetime" placeholder="Select date and time" required>
                    </div>

                    <!-- Backup Item Select Field -->
                    <div class="form-group">
                        <label for="backupItem">Backup Item <span class="text-danger">*</span></label>
                        <select class="form-control" id="backupItem" name="backup_item" required>
                            <option value="db">Database</option>
                            <option value="project">Project</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="backupForm">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Flatpicker
        flatpickr("#backupDateTime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    });
</script>
@endpush
