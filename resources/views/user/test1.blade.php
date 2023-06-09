<select id="province" name="province">
    <option value="">Chọn Tỉnh/Thành phố</option>
    @foreach ($provinces as $province)
        <option value="{{ $province->id }}">{{ $province->name }}</option>
    @endforeach
</select>

<select id="district" name="district">
    <option value="">Chọn Quận/Huyện</option>
</select>

<select id="ward" name="ward" data-district-id="">
    <option value="">Chọn Phường/Xã</option>
</select>
<p id = "fee">Phí ship:</p>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#province').change(function () {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: "{{url('/get-districts')}}/" + provinceId,
                    type: 'GET',
                    success: function (data) {
                        $('#district').html('<option value="">Chọn Quận/Huyện</option>');
                        $.each(data, function (key, value) {
                            $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#district').html('<option value="">Chọn Quận/Huyện</option>');
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });

        $('#district').change(function () {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: "{{url('/get-wards')}}/" + districtId,
                    type: 'GET',
                    success: function (data) {
                        $('#ward').attr('data-district-id', districtId);
                        $('#ward').html('<option value="">Chọn Phường/Xã</option>');
                        $.each(data, function (key, value) {
                            $('#ward').append('<option value="' + value.id + '"'+'data-district-id="'+districtId+'">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });

        $('#ward').change(function () {
            var wardId = $(this).val();
            var districtId = $(this).find(':selected').data('district-id');
            if (wardId) {
                $.ajax({
                    url: '{{URL::to("/get-fee")}}',
                    method: 'POST',
                    data: {
                    wardid: wardId,
                    districtid: districtId,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (data) {

                        $('#fee').text(data + ' ₫');
                       
                    }
                });
            } else {
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });
    });
</script>