$(function () {
    // Show form
    $('#addItemBtn').click(function () {
        $('#itemForm')[0].reset();
        $('#itemId').val('');
        $('#itemFormDialog').dialog({
            modal: true,
            width: 500,
            title: 'Add New Item'
        });
    });

    $('#cancelFormBtn').click(function () {
        $('#itemFormDialog').dialog('close');
    });

    // Load models on brand change
    $('select[name="brand_id"]').change(function () {
        let brandId = $(this).val();
        $.get('/models/by-brand/' + brandId, function (data) {
            let modelSelect = $('select[name="model_id"]');
            modelSelect.empty().append('<option value="">Select Model</option>');
            $.each(data, function (i, model) {
                modelSelect.append(`<option value="${model.id}">${model.name}</option>`);
            });
        });
    });

    // Submit form
    $('#itemForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '/items/save',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
    alert('Item saved successfully!');
    location.reload();
            },
            error: function (xhr) {
                alert('Validation error. Please check your form.');
            }
        });
    });

    // Delete item
    $('.deleteItemBtn').click(function () {
        if (!confirm('Are you sure you want to delete this item?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: '/items/' + id,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                location.reload();
            }
        });
    });
});
