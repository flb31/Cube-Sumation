$(window).load(function(){
    
    $("#command").on("keyup", function(event){
        if ( event.which == 13 ){
            var textbox = $("#command");
            var command = textbox.val();
            
            stop_input_command( textbox );
            
            $.ajax(
                {
                    url : 'process.php?command='+command,
                    dataType : 'html',
                    statusCode: {
                        404: function() {
                            __console( "Servidor no encontrado." );
                        },
                        500: function() {
                            __console( "Error en el servidor." );
                        }
                    }
                }
            ).done(function(response) {
                start_input_command( textbox );
                __console( response );
            });
        }
        
    });
    
    function start_input_command(input){
        input.val('');
        input.attr("disabled", false);
        input.focus();
    }
    
    function stop_input_command(input){
        input.attr("disabled", true);
    }

    function __console(message){
        
        //Print response
        var result = $("<div>").addClass("response").html( message );
        $( "#console" ).append( result );
        
        //height console
        var nro = $("#console > .response").length;
        var height = parseFloat ( $("#console > .response").css("height") );
        height = height * nro;
        $( "#console" ).scrollTop(height);
    }
});