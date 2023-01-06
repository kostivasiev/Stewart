

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jasny-bootstrap.min.js"></script>
    <script src="/assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="/js/treeview.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.2/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/assets/pivot-table/dist/pivot.js"></script>
    <!-- <script src="https://embed.small.chat/TESKBPVSPGETQ5J7V5.js" async></script> -->
    @yield('js')
    @yield('form-script')

    <script>

    function ChangeCompany(company_id){
      $.ajax({
        url: "{{ route("company.change_company") }} ",
        method: 'post',
        data: {
          name: "new_group",
          company_id: company_id,
          _token: $("input[name=_token]").val()
        },
        success: function (group){
          window.location = "{{ Request::segment(1) }}";
        },
        error: function (xhr){
            alert(xhr);
        }
      });
    }
    function StartChat(){
      $( "#chat_window_1" ).show();
    }
    // var socket = io.connect('http://192.169.142.192:3000');
    // var socket = io('http://127.0.0.1:3000');
    // socket.emit("test-channel", 'test');
    var user = {};
    @if(false)
    user.id= {{ Auth::user()->id }};
    user.name="{{ Auth::user()->first_name }}";
    @endif

    function SendMessage(){
      user.message = $('#btn-input').val();
      var json = JSON.stringify(user);
      socket.emit('chat message', json);
      $('#btn-input').val('');
    }



    //
            var vm = new Vue({
              el: '#example-1',
              data: {
                items: [
                ]
              },
              mounted: function(){
                //COMMENT BACK THIS CODE
                // socket.on('chat message', function(data){
                //   console.log(data);
                //   var json = JSON.parse(data);
                //   if(json.id == user.id){
                //     var newMessage = {message: json.message, name: json.name, receiver: true};
                //     this.items.push(newMessage);
                //   }else{
                //     var newMessage = {message: json.message, name: json.name, receiver: false};
                //     this.items.push(newMessage);
                //   }
                //
                //
                // }.bind(this));
              }
            });


    new Vue({
      el: '#chat-sesrvice',

      data: {
        users: []
      },

      ready: function(){
        console.log("here");
        // alert("vitory");
        // socket.on('test-channel:UserSignedUp', function(data){
        //   // this.users.push(data.username);
        //   console.log(data.username);
        // }.bind(this));
      }

    });



    $(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
    $this.parents('.panel').find('.panel-body').slideUp();
    $this.addClass('panel-collapsed');
    $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
    $this.parents('.panel').find('.panel-body').slideDown();
    $this.removeClass('panel-collapsed');
    $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
    });
    $(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
    $this.parents('.panel').find('.panel-body').slideDown();
    $('#minim_chat_window').removeClass('panel-collapsed');
    $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
    });
    $(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
    size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
    });
    $(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $( "#chat_window_1" ).hide();
    });

    </script>

  </body>
</html>
