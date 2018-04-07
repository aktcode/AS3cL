$(document).ready(function() {
    $('.webdet').hide();
    $('#web').change(function() {
        if(this.checked) {
            $('.webdet').show(400);
        }
        else if(!this.checked){
            $('.webdet').hide(200);
        }
    });

    $('#del_this_account').click(function(){
        $('.show_del').show(500);
       
    });
    $('#close').click(function(){
        $('.show_del').hide(500);
       
    });


});


