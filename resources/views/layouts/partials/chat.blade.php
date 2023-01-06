<div class="container">
<div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;display:none">
    <div class="col-xs-12 col-md-12">
      <div class="panel panel-default">
            <div class="panel-heading top-bar">
                <div class="col-md-8 col-xs-8">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat -  Auth::user()->first_name</h3>
                </div>
                <div class="col-md-4 col-xs-4" style="text-align: right;">
                    <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                    <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                </div>
            </div>
            <div id="example-1" class="panel-body msg_container_base">
              <div v-for="item in items">
                <div class="row msg_container base_sent" v-if=item.receiver>
                    <div class="col-md-10 col-xs-10">
                        <div class="messages msg_sent">
                          <p>@{{ item.message }}</p>
                          <time datetime="2009-11-13T20:00">@{{ item.name }}</time>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                    </div>
                </div>
                <div class="row msg_container base_receive" v-else=item.receiver>

                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                    </div>
                    <div class="col-md-10 col-xs-10">
                        <div class="messages msg_receive">
                            <p>@{{ item.message }}</p>
                            <time datetime="2009-11-13T20:00">@{{ item.name }} </time>
                            <!-- • 51 min -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" id="btn-chat" onclick="SendMessage()">Send</button>
                    </span>
                </div>
            </div>
    </div>
    </div>
</div>
</div>
