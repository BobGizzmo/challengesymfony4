function getInfo(entity, fields, id) {
    $.get('/admin/house/ajax/'+id, {}, function(data) {
        var i = 0;
        data.house.forEach(function(e) {
            console.log(e);
            if(fields[i] == 'city') {
                $('option').removeAttr('selected');
                $('option[value="'+e+'"]').attr('selected', true);
                $('#houseId').val(data.house[i+1]);
                $('#houseDeleteBtn').attr("href", "/admin/house/delete/"+data.house[i+1]).css('display', 'inline-block');
            }
            else {
                $('#'+entity+'_'+fields[i]).val(e);
            }
            i++;
        });
        $('#houseTitle').text('Modifier une maison');
    });
}