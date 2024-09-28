
@php
$row = $data['row']
@endphp
<div class="card-body table-responsive p-0">
    <table class="table">
        <tr>
            <td>Name</td>
            <td>{{ $row->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $row->email }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $row->phone }}</td>
        </tr>
        <tr>
            <td>Reason for Inquiry</td>
            <td>{{ $row->reason }}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{ date('d M Y', strtotime($row->created_at)) }}</td>
        </tr>
        <tr>
            <td>Message</td>
            <td>{{ $row->message }}</td>
        </tr>
    </table>
</div>

