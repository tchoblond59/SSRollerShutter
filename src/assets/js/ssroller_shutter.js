/****************SSRoller Shutter JS Plugin****************/
$(function() {
    e.channel('chan-ssrollershutter')
        .listen('.Tchoblond59\\SSRollerShutter\\Events\\SSRollerShutterEvent', function (e) {
            console.log('SSRollerShutterEvent', e);
            $('input[data-sensor-id='+e.config.sensor_id+']').slider('setValue', e.config.percent);
            $('.roller_shutter_'+e.roller_shutter.id+' h4').text(e.roller_shutter.title);
        })

    $('.roller_shutter_widget button').click(function (e) {
        var data_form = $(this).data('form-type');
        console.log(data_form);
        var form = $(this).siblings('form.'+data_form);
        console.log(form);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
        e.preventDefault();
    });

    if($('#history_roller_shutter').length)
    {
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    }
})