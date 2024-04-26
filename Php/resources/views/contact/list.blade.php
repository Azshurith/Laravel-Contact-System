@extends('layout')

@section('content')
<div class="container">
    @include('navigation')
    <table id="contacts-table" class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="pagination"></div>
    @include('modal')
</div>
<script>
    $(document).ready(function() {
        const editUrl = '{{ route("contact.edit", ":id") }}';
        const deleteUrl = '{{ route("contact.destroy", ":id") }}';
        let page = 1;
        let limit = 5;
        let typingTimer;
        let doneTypingInterval = 500; // MILLISECONDS

        fetchContacts();

        // SEARCH PRESS
        $('#search').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(fetchContacts, doneTypingInterval);
        });

        // PAGINATION CLICK
        $(document).on('click', '#pagination a.page-link', function(e) {
            e.preventDefault();
            page = $(this).data('page');
            fetchContacts(page);
        });

        // SHOW MODAL
        $(document).on('click', '.delete-contact', function(e) {
            e.preventDefault();
            var contactId = $(this).data('contact-id');
            $('#deleteConfirmationModal').modal('show');
            $('#confirmDelete').data('contact-id', contactId);
        });

        // CONFIRM DELETE
        $('#confirmDelete').click(function() {
            var contactId = $(this).data('contact-id');
            deleteContact(contactId);
            $('#deleteConfirmationModal').modal('hide');
        });

        // FETCH DATA
        function fetchContacts(page = 1) {
            var searchQuery = $('#search').val();
            $.ajax({
                url: '{{ route("contact.retrieve") }}',
                type: 'POST',
                data: {
                    search: searchQuery,
                    page: page,
                    limit: limit,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    let html = "";
                    response.contacts.forEach(function(contact) {
                        html += `<tr>`;
                        html += `<td>` + contact.name + `</td>`;
                        html += `<td>` + contact.company + `</td>`;
                        html += `<td>` + contact.phone + `</td>`;
                        html += `<td>` + contact.email + `</td>`;
                        html += `<td>
                            <a href="${editUrl.replace(":id", contact.id)}">Edit</a> | 
                            <a href="#" class="delete-contact" data-contact-id="${contact.id}">Delete</a>
                        </td>`;
                        html += `</tr>`;
                    });
                    $(`#contacts-table tbody`).html(html);

                    // Update pagination links
                    updatePagination(response.total, page);
                }
            });
        }

        // UPDATE PAGINATION BUTTONS
        function updatePagination(totalContacts, currentPage) {
            let totalPages = Math.ceil(totalContacts / limit); // Assuming 10 contacts per page
            let paginationHtml = "";
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = (i === currentPage) ? 'active' : '';
                paginationHtml += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
            $('#pagination').html(`<ul class="pagination">${paginationHtml}</ul>`);
        }

        // DELETE CONTACT REQUEST
        function deleteContact(contactId) {
            $.ajax({
                url: deleteUrl.replace(":id", contactId),
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Refresh contacts after successful deletion
                    fetchContacts(page);
                }
            });
        }
    });
</script>
@endsection