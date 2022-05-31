<!-- Bootstrap core JavaScript

================================================= -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $('#order_by').on('change', function(){
        var value = $('#order_by').val();
        window.location.href = "/?order_by=" + value;
    });

    $('#order_by_s').on('change', function(){
        var value = $('#order_by_s').val();
        window.location.href = "/?order_by=" + value;
    });

    $( "#subject" ).change(function() {
        $('#suggested').hide();
        var subject = $('#subject').val();
        $.ajax({url: "/suggestion?subject=" + subject, success: function(result){

            if(result.length > 0){
                $('#suggested').show();
                var wrap = "";
                result.forEach(function(item){
                    wrap += '<li><a href="/question/' + item["id"] + '-' + item["slug"] + '/'">' + item["title"]  +  '</a></li>';
                });

                $('#suggested_item').html(wrap);
            }

            
        }});
    });


</script>