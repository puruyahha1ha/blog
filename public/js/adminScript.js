$('#category_id').change(function () {
    var product_category_id = $(this).val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'select',
        type: 'POST',
        data: { 'product_category_id': product_category_id },
        datatype: 'json',
    }).done(function (data) {
        $('#subcategory_id option').remove();

        $('#subcategory_id').append($('<option>').text('選択してください').attr('value', 0))

        $.each(data, function (key, value) {
            $('#subcategory_id').append($('<option>').text(value.name).attr('value', value['id']))
        });

    })
})


// 写真１
$('#image_1').change(function () {
    var fileSize = this.files[0].size / 1024 ** 2;
    var fileInput = document.getElementById('image_1');
    if (fileSize > 10) {
        alert('画像サイズを10MB以下にしてください');
        fileInput.value = '';
        return;
    }

    var formData = new FormData();
    formData.append('upload', this.files[0]);

    console.log(formData);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    }).done(function (result) {
        document.getElementById('image_1_preview').src = '/storage/' + result['file_name'];
        document.getElementById('image_1_preview').style = 'width: 250px; height: 250px;';
        document.getElementById('hi_image_1').value = '/storage/' + result['file_name'];
    })
})

// 写真２
$('#image_2').change(function () {
    var fileSize = this.files[0].size / 1024 ** 2;
    var fileInput = document.getElementById('image_2');
    if (fileSize > 10) {
        alert('画像サイズを10MB以下にしてください');
        fileInput.value = '';
        return;
    }

    var formData = new FormData();
    formData.append('upload', this.files[0]);

    console.log(formData);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    }).done(function (result) {
        document.getElementById('image_2_preview').src = '/storage/' + result['file_name'];
        document.getElementById('image_2_preview').style = 'width: 250px; height: 250px;';    
        document.getElementById('hi_image_2').value = '/storage/' + result['file_name'];
    })
})

// 写真３
$('#image_3').change(function () {
    var fileSize = this.files[0].size / 1024 ** 2;
    var fileInput = document.getElementById('image_3');
    if (fileSize > 10) {
        alert('画像サイズを10MB以下にしてください');
        fileInput.value = '';
        return;
    }

    var formData = new FormData();
    formData.append('upload', this.files[0]);

    console.log(formData);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    }).done(function (result) {
        document.getElementById('image_3_preview').src = '/storage/' + result['file_name'];
        document.getElementById('image_3_preview').style = 'width: 250px; height: 250px;';
        document.getElementById('hi_image_3').value = '/storage/' + result['file_name'];
    })
})

// 写真４
$('#image_4').change(function () {
    var fileSize = this.files[0].size / 1024 ** 2;
    var fileInput = document.getElementById('image_4');
    if (fileSize > 10) {
        alert('画像サイズを10MB以下にしてください');
        fileInput.value = '';
        return;
    }

    var formData = new FormData();
    formData.append('upload', this.files[0]);

    console.log(formData);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    }).done(function (result) {
        document.getElementById('image_4_preview').src = '/storage/' + result['file_name'];
        document.getElementById('image_4_preview').style = 'width: 250px; height: 250px;';
        document.getElementById('hi_image_4').value = '/storage/' + result['file_name'];
    })
})

