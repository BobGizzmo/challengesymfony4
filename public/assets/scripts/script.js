function getInfo(entity, fields, id) {
    $.get('/admin/house/ajax/'+id, {}, function(data) {
        var i = 0;
        data.forEach(function() {
            if(fields[i] == 'city') {
                $('option').removeAttr('selected');
                $('option[value="'+data[i]+'"]').attr('selected', true);
                $('#houseId').val(data[i+1]);
                $('#houseDeleteBtn').attr("href", "/admin/house/delete/"+data[i+1]).css('display', 'inline-block');
            }
            else {
                $('#'+entity+'_'+fields[i]).val(data[i]);
            }
            i++;
        });
        $('#houseTitle').text('Modifier une maison');
    });
}