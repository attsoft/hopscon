<?php
/**
 *  Dokan Dashboard Template
 *
 *  Dokan Main Dahsboard template for Fron-end
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>
<div class="dokan-dashboard-wrap">
    <?php
        /**
         *  dokan_dashboard_content_before hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
    ?>

    <div class="dokan-dashboard-content">

        <?php
            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked show_seller_dashboard_notice
             *
             *  @since 2.4
             */
            do_action( 'dokan_help_content_inside_before' );
        ?>

        <article class="help-content-area">
        	<h1>Chat Support Queries</h1>
          	<p></p>

        </article><!-- .dashboard-content-area -->
        
        
        
        
        <?php if($_REQUEST['chat_id']) { ?>
        
        <?php
if ( isset( $_POST['Submit'] ) ){
    global $wpdb;

    $chat_id = $_POST['dokan-chat-ticket-number'];
    $message = $_POST['message_reply'];

    $sql = $wpdb->query( "INSERT INTO chat_support (id, chat_id, user_id, vendor_id, topic,message) VALUES ( '','$chat_id','','','','$message' )");
    //$wpdb->query($sql);
}
?>
        
              <div class="chat_window">
    <div class="top_menu">
        <div class="buttons">
            <div class="button close"></div>
            <div class="button minimize"></div>
            <div class="button maximize"></div>
        </div>
        <div class="title">Chat</div>
    </div>
    <ul class="messages">
        
        <?php
        global $wpdb;
        $userid = wp_get_current_user();
        $chater_id = $_REQUEST['chat_id'];
        $results = $wpdb->get_results( "SELECT * FROM `chat_support` WHERE `chat_id` = $chater_id AND `message` != ''");
        //print_r($results);
        if(!empty($results))                       
        {    
            $count = 0;
            foreach($results as $row){ 
            $count++;
             ?>
        <li class="message <?php print ($count % 2 == 1) ? "left" : "right"; ?> appeared"><div class="avatar"></div><div class="text_wrapper"><div class="text"><?php echo $row->message; ?></div></div></li>
         <?php }
                }
                ?>
    </ul>
    <form method="post" action="">
    <div class="bottom_wrapper clearfix">
        <div class="message_input_wrapper">
            <input type="text" class="message_input" name="message_reply" placeholder="Type your message here..." />
        </div>
        
        <input class="dokan-form-control" type="hidden" value="<?php echo $_REQUEST['chat_id']; ?>" name="dokan-chat-ticket-number">
        
        <div class="send_message">
            <div class="icon"></div>
            <div class="text"><input id="support-submit-btn-btn" type="submit" value="Submit" name="Submit"></div>
        </div>
    </div>
    </form>
</div>
<div class="message_template">
    <li class="message">
        <div class="avatar"></div>
        <div class="text_wrapper">
            <div class="text"></div>
        </div>
    </li>
</div>
        
        
            <?php }else { ?>
            
            <table class="dokan-table">
    <thead>
        <tr>
            <th>Chat ID</th>
            <th>User ID</th>
            <th>Topic</th>
            <!---<th>Message</th>-->
            <!--<th>Action</th>-->
        </tr>
    </thead>  

                <tbody>
                <?php
                global $wpdb;
                $author_id = get_current_user_id();
                $results = $wpdb->get_results( "SELECT * FROM `chat_support` WHERE `vendor_id` = '$author_id'");
                //print_r($results);
                if(!empty($results))                       
                {    
                    foreach($results as $row){ ?> 
                    <tr>
                        <td><a href="http://ewt.webdesigntexas.us/hopscan/dashboard/chat/?chat_id=<?php echo $row->chat_id; ?>"><?php echo $row->chat_id; ?></a></td>
                        <td><?php echo $row->user_id; ?></td>
                        <td><?php echo $row->topic; ?></td>
                        <!--<td><?php //echo $row->message; ?></td>!-->
                        <!--<td></td>--->
                    </tr>
                <?php }
                }
                ?>
                    
                
            </tbody></table>
            
            <?php } ?>
            
            
            <style>
#support-submit-btn-btn{
background: #a3d063;
    border: 0px;
}
#support-submit-btn-btn:hover{
background: #fff;
    border: 0px;
    color:#000;
}
.chat_window {
  max-width: 800px;
  height: 500px;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  background-color: #f8f8f8;
  overflow: hidden;
}

.top_menu {
  background-color: #fff;
  width: 100%;
  padding: 20px 0 15px;
  box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
}
.top_menu .buttons {
  margin: 3px 0 0 20px;
  position: absolute;
}
.top_menu .buttons .button {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 10px;
  position: relative;
}
.top_menu .buttons .button.close {
  background-color: #f5886e;
}
.top_menu .buttons .button.minimize {
  background-color: #fdbf68;
}
.top_menu .buttons .button.maximize {
  background-color: #a3d063;
}
.top_menu .title {
  text-align: center;
  color: #323232;
  font-size: 20px;
}

.messages {
  position: relative;
  list-style: none;
  padding: 20px 10px 0 10px;
  margin: 0;
  height: 347px;
  overflow: scroll;
}
.messages .message {
  clear: both;
  overflow: hidden;
  margin-bottom: 20px;
  transition: all 0.5s linear;
  opacity: 0;
}
.messages .message.left .avatar {
  background-color: #f5886e;
  float: left;
}
.messages .message.left .text_wrapper {
  background-color: #ffe6cb;
  margin-left: 20px;
}
.messages .message.left .text_wrapper::after, .messages .message.left .text_wrapper::before {
  right: 100%;
  border-right-color: #ffe6cb;
}
.messages .message.left .text {
  color: #c48843;
}
.messages .message.right .avatar {
  background-color: #fdbf68;
  float: right;
}
.messages .message.right .text_wrapper {
  background-color: #c7eafc;
  margin-right: 20px;
  float: right;
}
.messages .message.right .text_wrapper::after, .messages .message.right .text_wrapper::before {
  left: 100%;
  border-left-color: #c7eafc;
}
.messages .message.right .text {
  color: #45829b;
}
.messages .message.appeared {
  opacity: 1;
  margin-bottom:10px;
}
.messages .message .avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: inline-block;
}
.messages .message .text_wrapper {
  display: inline-block;
  padding: 20px;
  border-radius: 6px;
  width: calc(100% - 85px);
  min-width: 100px;
  position: relative;
}
.messages .message .text_wrapper::after, .messages .message .text_wrapper:before {
  top: 18px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
}
.messages .message .text_wrapper::after {
  border-width: 13px;
  margin-top: 0px;
}
.messages .message .text_wrapper::before {
  border-width: 15px;
  margin-top: -2px;
}
.messages .message .text_wrapper .text {
  font-size: 18px;
  font-weight: 300;
}

.bottom_wrapper {
  position: relative;
  width: 100%;
  background-color: #fff;
  padding: 20px 20px;
  bottom: 0;
}
.bottom_wrapper .message_input_wrapper {
  display: inline-block;
  height: 50px;
  border-radius: 25px;
  border: 1px solid #bcbdc0;
  width: calc(100% - 160px);
  position: relative;
  padding: 0 20px;
}
.bottom_wrapper .message_input_wrapper .message_input {
  border: none;
  height: 100%;
  box-sizing: border-box;
  width: calc(100% - 40px);
  position: absolute;
  outline-width: 0;
  color: gray;
}
.bottom_wrapper .send_message {
  width: 140px;
  height: 50px;
  display: inline-block;
  border-radius: 50px;
  background-color: #a3d063;
  border: 2px solid #a3d063;
  color: #fff;
  cursor: pointer;
  transition: all 0.2s linear;
  text-align: center;
  float: right;
}
.bottom_wrapper .send_message:hover {
  color: #a3d063;
  background-color: #fff;
}
.bottom_wrapper .send_message .text {
  font-size: 18px;
  font-weight: 300;
  display: inline-block;
  line-height: 48px;
}

.message_template {
  display: none;
}
</style>
            
            
         <?php
            /**
             *  dokan_dashboard_content_inside_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_after' );
        ?>


    </div><!-- .dokan-dashboard-content -->

    <?php
        /**
         *  dokan_dashboard_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
    ?>

</div><!-- .dokan-dashboard-wrap -->