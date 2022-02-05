
$(function() {

$('#contactForm input, #contactForm textarea').jqBootstrapValidation({
    preventSubmit:true,
    submitError:function($form, event, error){
        //Dodatni error log mesg
    },
    submitSuccess:function($form, event){
        event.preventDefault(); // sprecava defaultnu akciju koja se desava na submit
        //skupljam vrednosti iz polja
        var name = $('input#name').val();
        var email = $('input#email').val();
        
        var message = $('textarea#message').val();

        var firstName = name;
        //provera da li u first name postoji ime i prezime
        if(firstName.indexOf(' ')>=0){
            firstName = name.split(' ').slice(0,-1).join(' ');
        }
        // $.ajax({
        //     url:'././mail/contact_me.php',
        //     type:'POST',
        //     data:{
        //         name:name,
               
        //         email:email,
        //         message:message
        //     },
        //     success: function(){},
        //     error: function(){}
        // });
    },
    filter: function(){
        return $(this).is(':visible');
    }

});

});

$('#name').focus(function(){
    $('#success').html('');
})
