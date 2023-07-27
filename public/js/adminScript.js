$('#category_id').change(function () {
    var product_category_id = $(this).val();

    var params = (new URL(document.location)).searchParams;
    var id = params.get('id');
    console.log(id);

    console.log(product_category_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'select',
        type: 'GET',
        data: { 'product_category_id': product_category_id, 'id': id},
        datatype: 'json',
    }).done(function (data) {
        $('#subcategory_id option').remove();

        $('#subcategory_id').append($('<option>').text('選択してください').attr('value', 0))

        console.log(data[1]);
        $.each(data, function (key, value) {
            $('#subcategory_id').append($('<option>').text(value.name).attr('value', value['id']))
        });

    })
})
