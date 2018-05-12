$(document).ready(function(){

    //Check unwanted symbols
    check_symbols('.myinput');



    $("#icon").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-danger",
        fileType: "any",

    });
    $("#header").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-success",
        fileType: "any",

    });






//                 $("#excel").fileinput({
//                        showUpload: false,
//                        showCaption: false,
//                        browseClass: "btn btn-success",
//                        fileType: "any",
//                        browseLabel:'Import Excel file',
//                        browseIcon:'<i class="glyphicon glyphicon-upload"></i>'
//
//                });

    $('#enable-type').click(function(){
        if($(this).prop('checked')){

            $('#newtype').removeAttr('disabled');
            $('#type').attr('disabled','disabled');

        }else{
            $('#newtype').attr('disabled','disabled');
            $('#type').removeAttr('disabled');
        }

    });


    $('#enable-topic').click(function(){
        if($(this).prop('checked')){

            $('#newtopic').removeAttr('disabled');
            $('#topic').attr('disabled','disabled');

        }else{
            $('#newtopic').attr('disabled','disabled');
            $('#topic').removeAttr('disabled');
        }

    });



    //clear form on dismiss the modal


    $('#newfeed').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('.msg').hide();
        $('.Titlemsg').hide();

        $('#image_alert').hide();
        $('.save').removeAttr('disabled');
        $('.form-group').removeClass('has-error has-feedback').removeClass('has-success has-feedback');
        $('#success').hide();
        $('#title_success').hide();
        $('.link').attr('type','url');



    })



    //switch the input field of feed link to facebook mode
    $('#protocol').on('change', function() {
        $('#success').hide();
        $('#title_success').hide();
        $('.msg').html('');
        $('.link').val('');
        $('#feed_area').removeClass('has-success has-feedback').removeClass('has-error has-feedback');

        if ($(this).val() == 'fb') {

            $('#fb').show();
            $('.link').parent().attr('class','col-md-3');
            $('.link').attr('type','text');


        } else {
            $('#fb').hide();
            $('.link').parent().attr('class','col-md-6');
            $('.link').attr('type','url');
            // $("#facebook").hide();
            // $('#fb_input').attr('disabled','disabled');
            // $('#url').removeAttr('disabled').show();
        }

    });



//clear form
    $('#clear_btn').click(function () {

        $('form').trigger('reset');
        return false;

    });





//parse single feed on click

    $("#feeds_table").on('click',"button[id^='parse_']",function(){
        var button_id=$("button#"+$(this).attr("id"));
        var id=$("tr").has("button#"+$(this).attr("id")).find('td:first').text();
        $.ajax({

            type: "POST",
            url: '../admin/feedparse',
            data:{id:id},
            beforeSend: function(){
                button_id.html('loading');
            },
            success: function(data)
            {

                button_id.html('Parse now');
                alert(data+" News has been added");


            }, error: function(XMLHttpRequest, textStatus, errorThrown) {

            }




        });


        //check feed link availability



    });

    $('.link_website').on('change',function () {


        var link = $('.link_website').val();
        var type=$('.link_website').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkWebsite';
        CheckLink(link,type,load_name,success_name,msg_name,path);
    });
    $('.link_twitter').on('change',function () {


        var link = $('.link_twitter').val();
        var type=$('.link_twitter').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkTwitter';
       CheckLink(link,type,load_name,success_name,msg_name,path);





    });

    $('.link_rss').on('change',function () {


        var link = $('.link_rss').val();
        var type=$('.link_rss').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkRss';

        CheckLink(link,type,load_name,success_name,msg_name,path);


    });

    $('.link_facebook').on('change',function () {


        var link = $('.link_facebook').val();
        var type=$('.link_facebook').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkFB';

        CheckLink(link,type,load_name,success_name,msg_name,path);


    });


    $('.link_youtube').on('change',function () {


        var link = $('.link_youtube').val();
        var type=$('.link_youtube').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkYouTube';
        CheckLink(link,type,load_name,success_name,msg_name,path);
    });


    $('.link_instagram').on('change',function () {


        var link = $('.link_instagram').val();
        var type=$('.link_instagram').data('type');
        var load_name='#load_'+type;
        var success_name='#success_'+type;
        var msg_name='.msg_'+type;
        var path='../admin/checkInstagram';
        CheckLink(link,type,load_name,success_name,msg_name,path);
    });



    //Get Last News
  // $('#last_news').on('click',function () {
  //
  //
  //     var $this = $(this);//detect the button
  //
  //     $this.button('loading');
  //     $.ajax({
  //
  //         type: "GET",
  //         url: '../admin/parseall',
  //         beforeSend: function () {
  //             $this.button('loading');
  //         },
  //         success: function (data) {
  //             $this.button('reset');
  //
  //               alert(data);
  //
  //
  //         }, error: function (XMLHttpRequest, textStatus, errorThrown) {
  //
  //         }
  //
  //
  //     });
  // })





















    // check Accepted Symbols
    function check_symbols(class_name) {

        $(class_name).on('change',function () {

            var val=$.trim($(class_name).val());




                        if(check(val) == false){


                        $('.myinput').parents('.form-group').first().removeClass('has-error has-feedback').addClass('has-success has-feedback');
                            $('.Titlemsg').show().html('');
                            $('.save').removeAttr('disabled');
                            $('#title_success').show();

                        }else{


                              $('.myinput').parents('.form-group').first().removeClass('has-success has-feedback').addClass('has-error has-feedback');
                            $('.Titlemsg').show().html('remove any characters in these group <>@!#$%^&*()+[]{}?:;|\'\"\\,./~`-=');
                            $('.save').attr('disabled','disabled');
                            $('#title_success').hide();
                        }
                        if(val.length == 0)
                        {
                            $('.myinput').parents('.form-group').first().attr('class','form-group');
                            $('#title_success').hide();
                        }




        });

    }



    //Image Validation
    var fileInput = $('#icon');
    var maxSize = fileInput.data('max-size');
    $('#icon').on('change',function(e){
        if(fileInput.get(0).files.length){
            var fileSize = fileInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize){
                $("#logo_alert").show();
                $('.save').attr('disabled','disabled');


            }else{
                $("#logo_alert").hide();
                $('.save').removeAttr('disabled');
            }
        }


    });

    var HeaderInput = $('#header');
    var maxSize = HeaderInput.data('max-size');
    $('#header').on('change',function(e){
        if(HeaderInput.get(0).files.length){
            var fileSize = HeaderInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize){
                $("#header_alert").show();
                $('.save').attr('disabled','disabled');


            }else{
                $("#header_alert").hide();
                $('.save').removeAttr('disabled');
            }
        }


    });

    $('.fileinput-remove').click(function () {
        $('.save').removeAttr('disabled');
        $('#logo_alert').hide();
        $('#header_alert').hide();

    })

    var specialChars = "<>@!#$%^&*()+[]{}?:;|'\"\\,./~`="
    var check = function(string){
        for(i = 0; i < specialChars.length;i++){
            if(string.indexOf(specialChars[i]) > -1){
                return true
            }
        }
        return false;
    }

//check link
    function CheckLink(link,type,load_name,success_name,msg_name,path) {
        if(link.length != 0 ){
            $.ajax({
                type: "POST",
                url:path,
                data: {link:link,type:type},
                beforeSend: function () {
                    $(load_name).show();
                },
                success: function (data) {
                    $(load_name).hide();

                        if(data =='false')
                        {
                            $(msg_name).show().html('Wrong url');

                        }else{
                            if (data > 0) {

                                $(success_name).hide();

                                $(msg_name).show().html('Url Already exist');

                                $('.save').attr('disabled','disabled');
                            } else {
                                $(success_name).show();
                                $(msg_name).show().html('URL Allowed');
                                $('.save').removeAttr('disabled');

                            }

                        }



                }, error: function (XMLHttpRequest, textStatus, errorThrown) {

                }


            });

        }else{

            $(success_name).hide();
            $(msg_name).hide();
        }

    }




});