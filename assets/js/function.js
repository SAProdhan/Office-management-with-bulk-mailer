$(document).ready(function () {
    $('.table_name').click(function() {
        $(this).parents().siblings(".column").toggle();        
    }); 

    $('input.table_name:checkbox:checked').each(function () {
        $(this).parents().siblings(".column").show();
    });


    
    var table = $('#mytable').DataTable({
        'scrollY': 500,
        'scrollX': true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength', 'colvis'
        ]
    });
    $('#mytable tbody').on('click', 'tr', function () { 
        if ($(this).hasClass('selected')) 
        { 
            $(this).removeClass('selected'); 
        } else { 
            table.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        } 
    }); 
    $('#button').click(function () { 
        table.row('.selected').remove().draw(false); 
    });
});