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
});