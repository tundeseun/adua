@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User Report</h2>

    <!-- Search Box -->
    <input type="text" id="searchUsers" class="form-control mb-3" placeholder="Search Users...">

    <!-- Users Table -->
    <table class="table table-bordered table-hover" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            @include('partials.users_table', ['users' => $users])
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center" id="paginationLinks">
        {{ $users->links() }}
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    <div class="form-group">
                        <label for="editUserName">Name</label>
                        <input type="text" class="form-control" id="editUserName" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserEmail">Email</label>
                        <input type="email" class="form-control" id="editUserEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserType">User Type</label>
                        <input type="text" class="form-control" id="editUserType" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteUser">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // AJAX Search
        $('#searchUsers').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('reports.users') }}",
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#userTableBody').html(data.html);
                    $('#paginationLinks').html(data.pagination);
                }
            });
        });

        // Open Edit User Modal and populate with data
        $(document).on('click', '.edit-user', function() {
            $('#editUserId').val($(this).data('id'));
            $('#editUserName').val($(this).data('name'));
            $('#editUserEmail').val($(this).data('email'));
            $('#editUserType').val($(this).data('user_type'));
            $('#editUserModal').modal('show');
        });

        // Update User AJAX
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            let userId = $('#editUserId').val();
            let data = {
                _token: "{{ csrf_token() }}",
                name: $('#editUserName').val(),
                email: $('#editUserEmail').val(),
                user_type: $('#editUserType').val()
            };
            $.ajax({
                url: `/users/update/${userId}`,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#editUserModal').modal('hide');
                    location.reload(); // Reload to reflect updates
                }
            });
        });

        // Open Delete User Modal
        $(document).on('click', '.delete-user', function() {
            let userId = $(this).data('id');
            $('#confirmDeleteUser').data('id', userId);
            $('#deleteUserModal').modal('show');
        });

        // Confirm Delete User AJAX
        $('#confirmDeleteUser').on('click', function() {
            let userId = $(this).data('id');
            $.ajax({
                url: `/users/delete/${userId}`,
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    $('#deleteUserModal').modal('hide');
                    location.reload(); // Reload to reflect deletion
                }
            });
        });
    });
</script>
@endsection
