

$(document).ready(function(){
    //alert(333)
}) 
//alert("server script");
$(document).on('click','.btn_submit',function()
{ 
    if( !is_there_internet_connection())
    {
        //$(".div_hint").html("<div class='alert alert-danger'><i class='fa xfa-2x fa-lg fa-check'></i> Failed to contact server. Please check your internet connection</div>"); 		
        //return false; //check if there is internet access 
        alert("Check you network (NO NETWORK")
    } 
    
    $(".msg_response").addClass('alert alert-warning')/*.css("border","1px solid red")*///.css({"color":"#fff","font-size":"17px", "background":"tan","border":"0px solid red"})
        
    $('.msg_response2').append($(".msg_response"));
    
    if($(".fullname").val().trim()=="")
    {   
        $(".msg_response").show().html($(".fullname").attr("error_msg"))
        scrollTop_page(0);
        $(".fullname").focus()
        //$('.fullname').parent().append( $(".msg_response"));
        $('.fullname').parent().find(".d-block").append($(".msg_response"));
        //$('.fullname').css("margin","2px").parent().css("border","1px solid navy")
        return false
    }
    else if($(".sex").val().trim()=="")
    {   
        $(".msg_response").show().html($(".sex").attr("error_msg"))
        $('.sex').parent().find(".d-block").append($(".msg_response"));
        //scrollTop_page(0);
        $(".sex").focus()
        return false
    }
    else if($(".phone").val().trim()=="" || $(".phone").val().trim().length < 11 || $(".phone").val().trim().length > 16)
    {   
        $(".msg_response").html($(".phone").attr("error_msg"))
        //scroll_to_top(85);
        $(".phone").focus()
        $('.phone').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if($(".email").val().trim()=="")
    {   
        $(".msg_response").show().html($(".email").attr("error_msg"))
        //scrollTop_page(80);
        $(".email").focus()
        $('.email').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if (($('.email').val().trim() == "") || (!is_valid_email($('.email').val())))//(($('.email').val().trim() == "") || (!is_valid_email($('.email').val())))
    {
        $(".msg_response").html("Please enter a valid email address e.g sample@domain.com")
        //scroll_to_top(80);
        $(".email").focus()
        $('.email').parent().find(".d-block").append($(".msg_response"));
        
        return false
    }
    
    /*
        else if($(".fullname").val().split(" ").length == 1)
        {   
            $(".msg_response").html("Please enter your fullname e.g John Anderson")
            scrollTop_page(0);
            $(".fullname").focus()
            return false
        }
    */
    else if($(".dob").val().trim()=="")
    {   
        $(".msg_response").show().html($(".dob").attr("error_msg"))
        //scrollTop_page(0);
        $(".dob").focus()
        $('.dob').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    
    else if($(".shop_address").val().trim()=="")
    {  
        $(".msg_response").show().html($(".shop_address").attr("error_msg"))
        //scrollTop_page(80);
        $(".shop_address").focus()
        $('.shop_address').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if($(".shop_landmark").val().trim()=="")
    {    
        $(".msg_response").show().html($(".shop_landmark").attr("error_msg"))
        //scrollTop_page(80);
        $(".shop_landmark").focus()
        $('.shop_landmark').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if($(".shop_state").val().trim()=="")
    {    
        $(".msg_response").show().html($(".shop_state").attr("error_msg"))
        //scrollTop_page(80);
        $(".shop_state").focus()
        $('.shop_state').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if($(".shop_lga").val().trim()=="")
    {    
        $(".msg_response").show().html($(".shop_lga").attr("error_msg"))
        $(".shop_lga").focus()
        $('.shop_lga').parent().find(".d-block").append($(".msg_response"));
        return false
    }    
    else if($(".referral-channel").val().trim()=="")
    {    
        $(".msg_response").show().html($(".referral-channel").attr("error_msg"))
        $(".referral-channel").focus()
        $('.referral-channel').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    /*else if(!$(".chk_agree_terms").is(":checked")) //if($(this).prop("checked") == true)
    {    
        $(".msg_response").show().html($(".chk_agree_terms").attr("error_msg"))
        //scrollTop_page(80);
        $(".chk_agree_terms").focus()
        return false
    }*/
    else 
    {

        //Send and Process records to server
        //cbn_parameter='name=' + $('.surname').val().toUpperCase().trim() + " " + $('.othernames').val().toUpperCase().trim() +'&email
        var cbn_parameter='fullname=' + $('.fullname').val().toUpperCase().trim()+'&sex=' + $('.sex').val()+'&phone=' + $('.phone').val()+'&email=' + $('.email').val().toLowerCase().trim() +
        '&dob=' + $('.dob').val()+'&shop_address=' + $('.shop_address').val()+'&shop_landmark=' + $('.shop_landmark').val() +'&shop_state=' + $('.shop_state').val() +'&shop_lga=' + $('.shop_lga').val()+'&refferer=' + $('.refferer').val(); //var mypath='mode=add_category&category=' + $('#category').val();
         
        var button_text =  $(this).html()// 'Register';
        var button_btn = $(this);
        $.ajax({
            type:'POST',
            url:'processor_page.php?operation_type=insert&action=register_member',
            data:cbn_parameter, //datatype:'json', //datatype:JSON,,
            cache:false,
            context: this,
            beforeSend: function(jqXHR, settings) 
            {   jqXHR.url = settings.url;
                admin_error="";
                /*$(".msg_response").html(''); $(".msg_response2").html(''); 
                clear_alert(".msg_response"); clear_alert(".msg_response2")
                */
                $(".btn_submit").html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Saving Record")//.css("color","#fff")
                $(".btn_submit").attr('disabled', true);
                //button_btn.html(button_text).attr('disabled', false);

                $(".msg_response").hide(); 

                //$(".footer_developer").css({"position":"absolute","bottom":"0px"})
                //alert(cbn_parameter)
                //return false; // use this to pause the page and see what you want                        
            },
            success:function(server_response_raw)
            {   var server_response=server_response_raw.trim(); 
                ///$(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"17px", "background":"tan","border":"0px solid red"})
    
                //alert(response ? Object.inspect(json) : "no JSON object");
                //alert(response);
                //$(".btn-finish").html(button_text).css("color","#fff"); 
                button_btn.html(button_text).attr('disabled', false);

                //alert($(".msg_response").attr('class'))
                //$(".msg_response").removeAttr('style') // revert to default style

                alert(server_response);                      
                try
                {
                    var response_code = JSON.parse(server_response) //$.parseJSON(response); //  //response = json_decode(response);
                    if(response_code.status == 1)  
                    {   //record saved
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-danger');
                        $(".registration_success").html("<b>[RECORD SAVED]</b><br><b>Account Created Successfully</b> <i class='fa xfa-2x fa-lg fa-check'></i><br><br>Your Agent No.:" + response_code.agent_number).addClass('alert alert-success').show()
                        $(".registration_success").css({"margin-top":"5px"})
                        $(".registration_panel").hide();
                        $(".reset_btn").click() 

                        setTimeout(function ()
                        {
                            $(".registration_success").hide()
                            $(".registration_panel").show()
                            $('.fullname').focus();
                            //$(".msg_response ").slideUp();// $(".msg_response2").slideUp();
                        }, 9000);  
                        scrollTop_page(0); 
                    }
                    else if(response_code.status == 2) // no entry point
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [RECORD EXIST]<br>An account with this " + response_code.error +" already exist</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning')//.css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $("." + response_code.text_field).focus()  
                        /*$(".msg_response").fadeTo(15000, 5000).slideUp(5000, function(){
                          $(".msg_response").slideUp(500);
                        });*/
                    } 
                    else 
                    {
                        if(response_code.status == 100) // no entry point
                        { 
                            var error = "Sorry we could not process your request, Reason: No Entry Point. Refer to Your Admin; ErrCode:001";
                            $('html, body').animate({ scrollTop: 10 }, 'slow')
                            show_server_error("[ NULL ENTRY ]<br><br>", error, response_code)
                            return false;
                        }
                        else if(response_code.mysql_error != "")
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ SQL ERROR ]", "the error msg", server_response)
                            show_server_error("[ SQL ERROR ]", server_response + " ErrCode:sql-004", server_response)
                            
                        }
                        else
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ ERROR ]", "the error msg", server_response)
                            show_server_error("[ ERROR ]", server_response + " ErrCode:002", server_response)
                        }
                    }
                }
                catch (e) 
                {                        
                    var error = "Sorry we could not process your request,<br>Reason: There was little issue. Refer to your Admin; ErrCode:003";
                    //alert(error)
                    show_server_error("[ SERVER-ERROR ]<br><br>", error, server_response)
                    return false; 
                }
                
            },
            error: function(jqXHR, exception)
            {   alert("cbn is here for the error " + jqXHR.url + " " + exception.url)
            alert(this.url);
                /*$('#modalprocessing').hide();
                $('#modalsubmit').show();
                alert("Something Went Wrong");*/
            }
        });return false;
        
    }
    
});

$(document).on('click','.btn_submit_contact',function()
{ 
    if( !is_there_internet_connection())
    {
        //$(".div_hint").html("<div class='alert alert-danger'><i class='fa xfa-2x fa-lg fa-check'></i> Failed to contact server. Please check your internet connection</div>"); 		
        //return false; //check if there is internet access 
        alert("Check you network (NO NETWORK")
    } 
    
    $(".msg_response").addClass('alert alert-warning')/*.css("border","1px solid red")*///.css({"color":"#fff","font-size":"17px", "background":"tan","border":"0px solid red"})
        
    $('.msg_response2').append($(".msg_response"));
    
    if($(".fullname").val().trim()=="")
    {   
        $(".msg_response").show().html($(".fullname").attr("error_msg"))
        scrollTop_page(0);
        $(".fullname").focus()
        //$('.fullname').parent().append( $(".msg_response"));
        $('.fullname').parent().find(".d-block").append($(".msg_response"));
        //$('.fullname').css("margin","2px").parent().css("border","1px solid navy")
        return false
    }    
    else if($(".email").val().trim()=="")
    {   
        $(".msg_response").show().html($(".email").attr("error_msg"))
        //scrollTop_page(80);
        $(".email").focus()
        $('.email').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else if (($('.email').val().trim() == "") || (!is_valid_email($('.email').val())))//(($('.email').val().trim() == "") || (!is_valid_email($('.email').val())))
    {
        $(".msg_response").html("Please enter a valid email address e.g sample@domain.com")
        //scroll_to_top(80);
        $(".email").focus()
        $('.email').parent().find(".d-block").append($(".msg_response"));
        
        return false
    }
    else if($(".phone").val().trim()=="" || $(".phone").val().trim().length < 11 || $(".phone").val().trim().length > 16)
    {   
        $(".msg_response").html($(".phone").attr("error_msg"))
        //scroll_to_top(85);
        $(".phone").focus()
        $('.phone').parent().find(".d-block").append($(".msg_response"));
        return false
    }    
    else if($(".message").val().trim()=="")
    {    
        $(".msg_response").show().html($(".message").attr("error_msg"))
        //scrollTop_page(80);
        $(".message").focus()
        $('.message').parent().find(".d-block").append($(".msg_response"));
        return false
    }
    else 
    {

        //Send and Process records to server
        //cbn_parameter='name=' + $('.surname').val().toUpperCase().trim() + " " + $('.othernames').val().toUpperCase().trim() +'&email
        var cbn_parameter='fullname=' + $('.fullname').val().toUpperCase().trim()+'&phone=' + $('.phone').val()+'&email=' + $('.email').val().toLowerCase().trim() +
        '&message=' + $('.message').val();
         
        var button_text =  $(this).html()// 'Register';
        var button_btn = $(this);
        $.ajax({
            type:'POST',
            url:'processor_page.php?action=send_email_message',
            data:cbn_parameter, //datatype:'json', //datatype:JSON,,
            cache:false,
            context: this,
            beforeSend: function(jqXHR, settings) 
            {   jqXHR.url = settings.url;
                admin_error="";
                /*$(".msg_response").html(''); $(".msg_response2").html(''); 
                clear_alert(".msg_response"); clear_alert(".msg_response2")
                */
                $(".btn_submit").html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Saving Record")//.css("color","#fff")
                $(".btn_submit").attr('disabled', true);
                //button_btn.html(button_text).attr('disabled', false);

                $(".msg_response").hide(); 

                //$(".footer_developer").css({"position":"absolute","bottom":"0px"})
                //alert(cbn_parameter)
                //return false; // use this to pause the page and see what you want                        
            },
            success:function(server_response_raw)
            {   var server_response=server_response_raw.trim(); 
                ///$(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"17px", "background":"tan","border":"0px solid red"})
    
                //alert(response ? Object.inspect(json) : "no JSON object");
                //alert(response);
                //$(".btn-finish").html(button_text).css("color","#fff"); 
                button_btn.html(button_text).attr('disabled', false);

                //alert($(".msg_response").attr('class'))
                //$(".msg_response").removeAttr('style') // revert to default style

                alert(server_response);                      
                try
                {
                    var response_code = JSON.parse(server_response) //$.parseJSON(response); //  //response = json_decode(response);
                    if(response_code.status == 1)  
                    {   //record saved
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-danger');
                        $(".msg_success").html("<b>Message Sent Successfully</b> <i class='fa xfa-2x fa-lg fa-check'></i>").addClass('alert alert-success').show()
                        $(".msg_success").css({"margin-top":"5px"})
                        $(".msg_post").hide();
                        $(".reset_btn").click() 

                        setTimeout(function ()
                        {
                            $(".msg_success").hide()
                            $(".msg_post").show()
                            $('.fullname').focus();
                            //$(".msg_response ").slideUp();// $(".msg_response2").slideUp();
                        }, 8000);  
                        scrollTop_page(0); 
                    }
                    else if(response_code.status == 2) // no entry point
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [ERROR]<br>Your message could not be sent, Try again later</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning')//.css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $("." + response_code.text_field).focus()  
                        /*$(".msg_response").fadeTo(15000, 5000).slideUp(5000, function(){
                          $(".msg_response").slideUp(500);
                        });*/
                    } 
                    else 
                    {
                        if(response_code.status == 100) // no entry point
                        { 
                            var error = "Sorry we could not process your request, Reason: No Entry Point. Refer to Your Admin; ErrCode:001";
                            $('html, body').animate({ scrollTop: 10 }, 'slow')
                            show_server_error("[ NULL ENTRY ]<br><br>", error, response_code)
                            return false;
                        }
                        else if(response_code.mysql_error != "")
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ SQL ERROR ]", "the error msg", server_response)
                            show_server_error("[ SQL ERROR ]", server_response + " ErrCode:sql-004", server_response)
                            
                        }
                        else
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ ERROR ]", "the error msg", server_response)
                            show_server_error("[ ERROR ]", server_response + " ErrCode:002", server_response)
                        }
                    }
                }
                catch (e) 
                {                        
                    var error = "Sorry we could not process your request,<br>Reason: There was little issue. Refer to your Admin; ErrCode:003";
                    //alert(error)
                    show_server_error("[ SERVER-ERROR ]<br><br>", error, server_response)
                    return false; 
                }
                
            },
            error: function(jqXHR, exception)
            {   alert("cbn is here for the error " + jqXHR.url + " " + exception.url)
            alert(this.url);
                /*$('#modalprocessing').hide();
                $('#modalsubmit').show();
                alert("Something Went Wrong");*/
            }
        });return false;
        
    }
    
});

//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW REGISTER INTERNET BANKING WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
$(document).on('click','.btn_internet_banking_register',function()
{
    $(".msg_response").hide()
})
$(document).on('submit','.form_internet_banking_register',function()
{   
    $(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"20px", "background":"tomato","border":"0px solid red"})
    // $(".parent_class").find(".sub or child").attr("page_no", response.page_no - 2)  // note this line is for setting the attr not reading  
    
    if($(".debitaccount").val().trim()=="")
    {   
        $(".msg_response").show().html($(".debitaccount").attr("error_msg"))
        scrollTop_page(0);
        $(".debitaccount").focus()
        return false
    }
    else if($(".cardlast").val().trim()=="")
    {   
        $(".msg_response").show().html("Please enter the 6 last digits of your phone number")
        scrollTop_page(0);
        $(".cardlast").focus()
        return false
    }
    else if($(".username").val().trim()=="")
    {   
        $(".msg_response").show().html($(".username").attr("error_msg"))
        scrollTop_page(0);
        $(".username").focus()
        return false
    }
    else if($(".password").val().trim()=="")
    {   
        $(".msg_response").html($(".password").attr("error_msg"))
        scrollTop_page(0);
        $(".password").focus()
        return false
    }
    else
    {
        //Send and Process records to server
        var cbn_parameter='account_no=' + $('.debitaccount').val()+'&cardlast=' + $('.cardlast').val() + '&username=' + $('.username').val()+'&password=' + $('.password').val();

        var button_text = 'Submit';
        $.ajax({
            type:'POST',
            url:'../hash_file/processor_page.php?action=internet_banking_registration', //ENTRY POINTER
            data:cbn_parameter, //datatype:'json', //datatype:JSON,
            cache:false,//processData:false,contentType: false, /* this on comment is for picture */
            beforeSend: function() 
            {   admin_error=""; 
                $(".btn_internet_banking_register").html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Processing")//.css("color","navy")
                $(".btn_internet_banking_register").attr('disabled', true);
                $(".msg_response").hide(); 
                                
                //alert(cbn_parameter)
                //return false; // use this to pause the page and see what you want                        
            },
            success:function(server_response_raw)
            {   var server_response=server_response_raw.trim(); 
                $(".btn_internet_banking_register").html('<i class="fa fa-arrow-right"></i>' + button_text)//.css("color","#fff"); 
                $(".btn_internet_banking_register").attr('disabled', false);

                //alert($(".msg_response").attr('class'))
                $(".msg_response").removeAttr('style') // revert to default style

                //alert(server_response);                      
                try
                {
                    var response_code = JSON.parse(server_response) //$.parseJSON(response); //  //response = json_decode(response);
                    if(response_code.status == 1)  
                    {   //record saved
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-danger');
                        $(".msg_response ").html("[RECORD SAVED]<br><br><b>Your Internet Banking Account Created Successfully</b> <i class='fa xfa-2x fa-lg fa-check'></i>").addClass('alert alert-success').show()
                        $(".reset_btn").click()

                        setTimeout(function ()
                        {
                            $(".msg_response ").slideUp();// $(".msg_response2").slideUp();
                        }, 5000);   
                    }
                    else if(response_code.status == 2) // no entry point
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [RECORD EXIST]<br><br>This " + response_code.error +" already exist</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $("." + response_code.text_field).focus()  
                        /*$(".msg_response").fadeTo(15000, 5000).slideUp(5000, function(){
                          $(".msg_response").slideUp(500);
                        });*/
                    }
                    else if(response_code.status == 3) // INVALID account number
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [RECORD NOT FOUND]<br><br> Account Number Not Found or the last 6 digits of your phone number is not correct</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $("." + response_code.text_field).focus()  
                        /*$(".msg_response").fadeTo(15000, 5000).slideUp(5000, function(){
                          $(".msg_response").slideUp(500);
                        });*/
                    }
                    else if(response_code.status == 4) // Already Registered on interbanking
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [RECORD EXIST]<br><br> You have registered for Internet Banking Before, you can reset you password if you can't login</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                         
                    }
                    else if(response_code.status == 5) // INVALID account number
                    {   
                        //record exist
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> [RECORD NOT FOUND]<br><br> The last 6 digits of your phone number is not correct</b> ").show(); 
                        $(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                         
                    }
                    else 
                    {
                        if(response_code.status == 100) // no entry point
                        { 
                            var error = "Sorry we could not process your request, Reason: No Entry Point. Refer to Your Admin; ErrCode:001";
                            
                            $('html, body').animate({ scrollTop: 10 }, 'slow')
                            show_server_error("[ NULL ENTRY ]<br><br>", error, response_code)
                            return false;
                        }
                        else
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ ERROR ]", "the error msg", server_response)
                            show_server_error("[ ERROR ]", server_response + " ErrCode:002", server_response)
                        }
                    }
                }
                catch (e) 
                {                        
                    var error = "Sorry we could not process your request,<br>Reason: There was little issue. Refer to your Admin; ErrCode:003";
                    //alert(error)
                    show_server_error("[ SERVER-ERROR ]<br><br>", error, server_response)
                    return false; 
                }
                
            },
            error: function(data)
            {   alert("cbn is here for the error")
                /*$('#modalprocessing').hide();
                $('#modalsubmit').show();
                alert("Something Went Wrong");*/
            }
        });return false;
    }
    //return false
})

//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW INTERNET BANKING login WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
$(document).on('click','.btn_internet_banking_login',function()
{  
    $(".msg_response").addClass('alert alert-danger')//.css({"color":"#fff","font-size":"20px", "background":"tomato","border":"0px solid red"})
                
    if($(".username").val().trim()=="")
    {   
        $(".msg_response").show().html($(".username").attr("error_msg"))
        //scrollTop_page(0);
        $(".username").focus()
        return false
    }
    else if($(".password").val().trim()=="")
    {   
        $(".msg_response").show().html($(".password").attr("error_msg"))
        //scrollTop_page(0);
        $(".password").focus()
        return false
    }
    else
    {
        //Send and Process records to server
        var cbn_parameter='username=' + $('.username').val()+'&password=' + $('.password').val();

        var button_text = '<i class="si si-login mr-10"></i> Sign In';
        $.ajax({
            type:'POST',
            url:'../hash_file/processor_page.php?action=user_login', //ENTRY POINTER
            data:cbn_parameter, //datatype:'json', //datatype:JSON,
            cache:false,//processData:false,contentType: false, /* this on comment is for picture */
            beforeSend: function() 
            {   admin_error=""; 
                $(".btn_internet_banking_login").html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Processing")//.css("color","navy")
                $(".btn_internet_banking_login").attr('disabled', true);
                $(".msg_response").hide(); 
                                
                //alert(cbn_parameter)
                //return false; // use this to pause the page and see what you want                        
            },
            success:function(server_response_raw)
            {   var server_response=server_response_raw.trim(); 
                $(".btn_internet_banking_login").html(button_text)//.css("color","#fff"); 
                $(".btn_internet_banking_login").attr('disabled', false);

                //alert($(".msg_response").attr('class'))
                $(".msg_response").removeAttr('style') // revert to default style

                //alert(server_response);                      
                try
                {
                    var response_code = JSON.parse(server_response) //$.parseJSON(response); //  //response = json_decode(response);
                    if(response_code.status == 1)  
                    {   //record exist
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-danger');
                        $(".msg_response ").html("<b>Login Succedded, Redirecting ....</b> <i class='fa xfa-2x fa-lg fa-check'></i>").addClass('alert alert-success').show();
                        $(".btn_internet_banking_login").attr('disabled', true);
                        $(".username").val("")
                        $(".password").val("")
                        location.href="dashboard.php";
                        scrollTop_page(0); 
                        return false;
                    }
                    else if(response_code.status == 0) // no entry point
                    {   alert
                        //record exist [RECORD NOT FOUND]<br><br>
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> Invalid Login Details</b> ").show(); 
                        //$(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $(".username").focus()
                        $(".username").select()
                    } 
                    else 
                    {
                        if(response_code.status == 100) // no entry point
                        { 
                            var error = "Sorry we could not process your request, Reason: No Entry Point. Refer to Your Admin; ErrCode:001";
                            
                            $('html, body').animate({ scrollTop: 10 }, 'slow')
                            show_server_error("[ NULL ENTRY ]<br><br>", error, response_code)
                            return false;
                        }
                        else
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ ERROR ]", "the error msg", server_response)
                            show_server_error("[ ERROR ]", server_response + " ErrCode:002", server_response)
                        }
                    }
                }
                catch (e) 
                {                        
                    var error = "Sorry we could not process your request,<br>Reason: There was little issue. Refer to your Admin; ErrCode:003";
                    //alert(error)
                    show_server_error("[ SERVER-ERROR ]<br><br>", error, server_response)
                    return false; 
                }
                
            },
            error: function(data)
            {   alert("cbn is here for the error")
                /*$('#modalprocessing').hide();
                $('#modalsubmit').show();
                alert("Something Went Wrong");*/
            }
        });return false;
    } 
    return false
})

//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW INTERNET BANKING Dashboard WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
$(document).on('click','.Logout',function()
{ 
    location.href="../hash_file/dashboard.php?action=logout";
})
//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW INTERNET BANKING TRANSFER WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
//
/*$('#element').on('keyup keypress blur change', function(e) {
{});*/
//$(document).on('keyup','.beneficiary_acc_no',function()
$(document).on('keyup blur','.beneficiary_acc_no', function(e)
{   // e.type is the type of event fired // alert(e.type); // keyup OR keypress OR blur OR change
    if($(this).val().length==11)
    {
        $(".beneficiary_name").val("Processing...")
        $(".beneficiary_bank").val("").attr("placeholder","")

        $.ajax({
            type : "POST",
            url:'../hash_file/processor_page.php?action=get_Beneficiary_for_transfer', //ENTRY POINTER
            data : "account_no=" + $('.beneficiary_acc_no').val().trim(),
            success : function(server_response) 
            {   //alert(server_response)
                var response_code = JSON.parse(server_response) 
                if(response_code.status == 1)
                {
                    $(".beneficiary_name").val(response_code['name'])
                    $(".beneficiary_bank").val(response_code.bank + " Bank").attr("placeholder","Bank Name") 
                    $(".beneficiary_bank")
                }
                else
                {
                    $(".beneficiary_name").val("Unable to Retrieve Beneficiary")
                    //alert("Could not find the beneficiary, if you are sure of the account details you may continue")
                    $(".msg_response").show().addClass('alert alert-danger').html("Could not find the beneficiary, if you are sure of the account details you may continue")
                }
            },
            error: function(data)
            {
                alert("OOPS!, Something Went Wrong");
            }
        }) 
    }
    else
    {
        $(".msg_response").hide()
    }
    
})

$(document).on('click','.btn_transfer_fund', function(e)
{  //alert(eval($('.amount').val().trim().replace(",","")))
    $(".msg_response").addClass('alert alert-danger')//.css({"color":"#fff","font-size":"20px", "background":"tomato","border":"0px solid red"})
                
    if($(".currency").val().trim()=="")
    {   
        $(".msg_response").show().html($(".currency").attr("error_msg"))
        //scrollTop_page(0);
        $(".currency").focus()
        return false
    }
    else if($(".beneficiary_acc_no").val().trim()=="")
    {   
        $(".msg_response").show().html($(".beneficiary_acc_no").attr("error_msg"))
        //scrollTop_page(0);
        $(".beneficiary_acc_no").focus()
        return false
    }
    else if($(".beneficiary_acc_no").val().trim().length < 11)
    {   
        $(".msg_response").show().html("Please enter Beneficiary Account Number")
        //scrollTop_page(0);
        $(".beneficiary_acc_no").focus()
        return false
    }
    else if($(".country").val().trim()=="")
    {   
        $(".msg_response").show().html($(".country").attr("error_msg"))
        //scrollTop_page(0);
        $(".country").focus()
        return false
    }
    else if($(".amount").val().trim()=="")
    {   
        $(".msg_response").show().html($(".amount").attr("error_msg"))
        //scrollTop_page(0);
        $(".amount").focus()
        return false
    }
    else if(eval($('.amount').val().trim().replace(",","")) < 10 )
    {   
        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-success');
        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> Minimum Amount To Transfer is $10<b> ").addClass('alert alert-danger').show();
        //$(".msg_response").show().html("Insufficient Balance")
        //scrollTop_page(0);
        $(".amount").focus()
        return false
    }//    else if(eval($('.amount').val().trim().replace(",","")) > eval($('.available_balance').val().trim().replace(",","")))
    else if(eval($('.amount').val().trim().replace(",","")) > eval($('.available_balance').val().trim().replace(",","")))
    {   
        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-success');
        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> Insuficient Balance<b> ").addClass('alert alert-danger').show();
        //$(".msg_response").show().html("Insufficient Balance")
        //scrollTop_page(0);
        $(".amount").focus()
        return false
    }
    else
    {
        //Send and Process records to server
        var cbn_parameter='entity_guid=' + $('.entity_guid').val()+'&currency=' + $('.currency').val() + '&beneficiary_acc_no=' + $('.beneficiary_acc_no').val()+'&beneficiary_name=' + $('.beneficiary_name').val() + 
        '&beneficiary_bank=' + $('.beneficiary_bank').val()+'&swift_code=' + $('.swift_code').val() +'&country=' + $('.country').val() +'&amount=' + eval($('.amount').val().trim().replace(",",""));

        var button_text = $(this).html();// '<i class="si si-login mr-10"></i> Sign In';
        $.ajax({
            type:'POST',
            url:'../hash_file/processor_page.php?action=transfer_fund', //ENTRY POINTER
            data:cbn_parameter, //datatype:'json', //datatype:JSON,
            cache:false,//processData:false,contentType: false, /* this on comment is for picture */
            beforeSend: function() 
            {   admin_error=""; 
                $(".btn_transfer_fund").html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Processing")//.css("color","navy")
                $(".btn_transfer_fund").attr('disabled', true);
                $(".msg_response").hide();                                 
                //alert(cbn_parameter)
                //return false; // use this to pause the page and see what you want                        
            },
            success:function(server_response_raw)
            {   var server_response=server_response_raw.trim(); 
                $(".btn_transfer_fund").html(button_text)//.css("color","#fff"); 
                $(".btn_transfer_fund").attr('disabled', false);

                //alert($(".msg_response").attr('class'))
                $(".msg_response").removeAttr('style') // revert to default style

                //alert(server_response);                      
                try
                {
                    var response_code = JSON.parse(server_response) //$.parseJSON(response); //  //response = json_decode(response);
                    if(response_code.status == 1)  
                    {   //record exist
                        var amount = eval($('.amount').val().trim().replace(",",""))
                        var available_balance = eval($('.available_balance').val().trim().replace(",",""))
                        $('.available_balance').val(eval(available_balance) - eval(amount))
                        $('.available_balance_update').html(response_code.available_balance_update)

                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-danger');
                        $(".msg_response ").html("<b>Transfer Successful </b> <i class='fa xfa-2x fa-lg fa-check'></i>").addClass('alert alert-success').show();
                        $(".btn_internet_banking_login").attr('disabled', true);
                        $(".btn_reset").click() 
                        $(".perform_transfer ").hide()
                        
                        
                        setTimeout(function ()
                        {
                            //location.href="dashboard.php";
                        }, 1000);
                        
                        scrollTop_page(0); 
                        return false;
                    }
                    else if(response_code.status == 2)  
                    {   //record exist
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-success');
                        $(".msg_response").html("<b>Insuficient Balance<b> <i class='fa xfa-2x fa-lg fa-warning'></i>").addClass('alert alert-danger').show();
                        
                        scrollTop_page(0); 
                        return false;
                    }
                    else if(response_code.status == 5)  
                    {   
                        $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-warning').removeClass('alert alert-success');
                        $(".msg_response").html("<i class='fa xfa-2x fa-lg fa-warning'></i> <b>Sorry, We could not complete your Fund Transfer request, Please contact your Bank<b>").addClass('alert alert-danger').show().css("font-size:12px");
                        
                        scrollTop_page(0); 
                        return false;
                    }
                    else if(response_code.status == 0) // no entry point
                    {   alert
                        //record exist [RECORD NOT FOUND]<br><br>
                        $(".msg_response").html("<b><i class='fa xfa-2x fa-lg fa-warning'></i> Invalid Login Details</b> ").show(); 
                        //$(".msg_response").addClass('alert alert-warning').css({"color":"#fff","font-size":"14px", "background":"tomato","border":"0px solid red"})
                        scrollTop_page(0);
                        $(".username").focus()
                        $(".username").select()
                    } 
                    else 
                    {
                        if(response_code.status == 100) // no entry point
                        { 
                            var error = "Sorry we could not process your request, Reason: No Entry Point. Refer to Your Admin; ErrCode:001";
                            
                            $('html, body').animate({ scrollTop: 10 }, 'slow')
                            show_server_error("[ NULL ENTRY ]<br><br>", error, response_code)
                            return false;
                        }
                        else
                        {   
                            //when you no use  json_encode($arr_Response)
                            //show_server_error("[ ERROR ]", "the error msg", server_response)
                            show_server_error("[ ERROR ]", server_response + " ErrCode:002", server_response)
                        }
                    }
                }
                catch (e) 
                {                        
                    var error = "Sorry we could not process your request,<br>Reason: There was little issue. Refer to your Admin; ErrCode:003";
                    //alert(error)
                    show_server_error("[ SERVER-ERROR ]<br><br>", error, server_response)
                    return false; 
                }
                
            },
            error: function(data)
            {   alert("cbn is here for the error")
                /*$('#modalprocessing').hide();
                $('#modalsubmit').show();
                alert("Something Went Wrong");*/
            }
        });return false;
    } 
    return false
})

$(document).on('click','.transfer_proc', function(e)
{
    //alert($(this).attr("id"))
    var acc_no = $(".customer_account_no").val()
    if(acc_no.trim()=="")
    {   
        alert("Please Enter the Account Number of the customer you want to work on in the above textbox")
        $(".customer_account_no").focus()
        return false
    } 
    if(!confirm("Are you sure you want to Take this ACTION?"))
    {   
        return false;
    }
    $(".show_processing").show().html("<i class='fa fa-spinner fa-spin xfa-2x xfa-fw'></i> Processing").css("color","navy")
                
    $.ajax({
        type : "POST",
        url:'../hash_file/processor_page.php?action=block_transfer', //ENTRY POINTER
        data : "account_no=" + $('.customer_account_no').val().trim() + "&action=" + $(this).attr("id"),
        success : function(server_response) 
        {   //alert(server_response)
            var response_code = JSON.parse(server_response) 
            if(response_code.status == 1)
            {
                $(".show_processing").html("Successful <i class='fa fa-check xfa-2x xfa-fw'></i>").css("color","green").fadeOut(7000)

                alert("Operation was succssful")
                $(".customer_account_no").focus()
                $(".customer_account_no").select()
            }
            else
            {   
                $(".show_processing").hide()
                alert("Unable to match the Account Number you entered with any Customer, Try Again")
                $(".customer_account_no").focus()
            }
        },
        error: function(data)
        {
            alert("OOPS!, Something Went Wrong");
        }
    }) 
})


//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW HANDLING ONLY NUMBERS WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
$(document).on('keydown','.numbers_only',function(e)
{   
    var k = e.which; /* numeric inputs can come from the keypad or the numeric row at the top */
    //alert(k)
    if ( k==8 || k==9 || k==13 || (k>=37 && k<=40) || k==46 || k==116) return true;
    if ((k < 48 || k > 57 ) && (k < 96 || k > 105)) 
    {
        e.preventDefault();
        return false;
    } 
    else return true 
})

/*var phone = document.getElementById('beneficiary_acc_no');
phone.onkeydown = function(e)
{   alert(5)
    var k = e.which; /* numeric inputs can come from the keypad or the numeric row at the top */
    //alert(k)
    /*if ( k==8 || k==9 || k==13 || (k>=37 && k<=40) || k==46 || k==116) return true;
    if ((k < 48 || k > 57 ) && (k < 96 || k > 105)) 
    {
        e.preventDefault();
        return false;
    } 
    else return true
}*/

//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW HANDLING ERRORS WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW
//Display error message SQL
var admin_error="";
function show_server_error(error_title, error_msg, server_response)
{
    admin_error = server_response
    console.log('The error is: ' + server_response)
    $(".msg_response").html("<i class='fa xfa-2x fa-lg fa-warning'></i> " + error_title + " " + error_msg); 
    $(".msg_response").removeClass('alert alert-info').removeClass('alert alert-success');
    $(".msg_response").addClass('alert alert-danger').show();
    //$(".send_msg_btn").html(button_text); 
    //$('html, body').animate({ scrollTop: 10 }, 'slow')
}
//WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW


//FILE / IMAGE - PICTURE UPLOAD
var show_upload_hint = $(".image_hint");
$(document).on('change','#upload_file',function()
{
    var upload_file = document.getElementById('upload_file').files[0];
    var image_name = upload_file.name;
    var image_extension = image_name.split('.').pop().toLowerCase();

    //clear_alert(".msg_response2");
    //if(jQuery.inArray(image_extension,['doc','docx','']) == -1)
    if(jQuery.inArray(image_extension,['gif','jpg','jpeg','png','']) == -1)
    {  
        //$(".msg_response").show().html('The selected file format is NOT supported, upload only {.jpg, .jpeg, .gif or .png} <i class="fa fa-lg fa-upload"></i>').addClass('alert alert-danger');
        show_upload_hint.show().html('The selected file format is NOT supported, upload only {.jpg, .jpeg, .gif or .png} <i class="fa fa-lg fa-upload"></i>').addClass('alert alert-danger');

        //alert("Invalid File Type ==> " + image_extension);
        //alert("Invalid image file ==> " + image_extension);
        $(this).val("")//$(".upload_file").val("")
        //$(".disply_image_div").hide();
    }
    else
    {   
        //$(".msg_response").show().html('File format supported <i class="fa xfa-2x fa-lg fa-check"></i>').removeClass('alert alert-danger').addClass('alert alert-success');
        show_upload_hint.show().html('File format supported <i class="fa xfa-2x fa-lg fa-check"></i>').removeClass('alert alert-danger').addClass('alert alert-success');
         
        //Display the image
        readURL(this,".disply_image")
        //$(".disply_image_div").show();
         
        setTimeout(function ()
        {
            show_upload_hint.slideUp();// $(".msg_response2").slideUp();
        }, 5000);         
    }
})


//to show image that is from browse button
function readURL(image_name,where_to_PicturePreview_on) // browse and upload image
{
	if (image_name.files && image_name.files[0])
	{
		var reader = new FileReader();
		reader.onload = function (e) {
			$(where_to_PicturePreview_on)
				.attr('src', e.target.result)//.fadeIn('slow');
				/*.width(150)
				.height(200)*/;											
		};

		reader.readAsDataURL(image_name.files[0]);		
	}
}
// wwwwwwwwwwwwwwwwww


