

$(document).ready(function () {








    jQuery('#filename').on('change', function() {
        const file = this.files[0];
        var fileName = file.name;

        // بررسی پسوند فایل
        if (fileName.endsWith('.mp4') || fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') || fileName.endsWith('.png')) {
            uploadFile(file);
        } else {
            alert("فرمت های معتبر جهت اپلود فایل : mp4 , png ,jpeg , jpg")
        }
    });
    async function uploadFile(file) {
        const chunkSize = 1 * 1024 * 1024; // 1MB chunks
        let start = 0;
        let tmp_file_name = Date.now()
        let file_type = file.type
        let url = $('input[name="UplodePostMedia"]').val()
        let storage_url = $('input[name="storage_url"]').val()
        $('label[for="filename"]').fadeOut();
        $(".progress").fadeIn();
        $(".publish-button").prop('disabled', true);
        $(".publish-button").css('opacity', 0.4)
        while (start < file.size) {
            const chunk = file.slice(start, start + chunkSize);
            const formData = new FormData();
            formData.append('file', chunk);
            formData.append('start', start);
            formData.append('end', start + chunk.size);
            formData.append('totalSize', file.size);
            formData.append('tmp_file_name', tmp_file_name+"_"+file.name);
            formData.append('file_type', file_type);

            const response = await jQuery.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_csrf_token"]').val()
                },
            });
            pr = Math.floor(((start + chunkSize)/file.size)*100)
            if (pr >= 100) {
                pr=100
            }
            $(".progress-bar").text(pr+" % ");
            $(".progress-bar").css('width',pr+"%");
            if (response.status = 220){
                if (pr == 100){
                    $('input[name="media_file_name"]').val(response.filename)
                    $('input[name="media_file_type"]').val(file_type)
                    $("#ready_to_upload").fadeIn()
                    $("#ready_to_upload").text("فایل انتخابی شما با موفقیت اپلود شد.")
                    $(".publish-button").prop('disabled', false)
                    $(".publish-button").css('opacity', 1)
                }
                start += chunkSize;
            }

        }
    }


    var comment_pid = 0;
    $(".open-popup").click(function (){
        console.log("click popup")
        target=$(this).attr("data-target")
        $("#"+target).show();
    })
    $(".close-video-popup").click(function (){
        $(".video-popup").hide()
    })
    $("#followings-btn").on("click", function (){
        $("#followings_list").show()
    })
    $("#followers-btn").on("click", function (){
        $("#followers_list").show()
    })
    $(".close-list").on("click", function (){
        $(this).parent().hide()
    })
    $(".post-actions-bar").on("click",function (){
        post_id =  $(this).attr("post-id")
        $("#actions-bar-box-"+post_id).toggle()
    })
    $("#check_login_code").on("click", function () {
        let code = $("#code").val();
        let mobile = $("#mobile").val();
        if (code != '' && mobile != '') {
            $(this).text('در حال بررسی ...');
            verify_login_code(code, mobile).then(r => {
                console.log(r.data)
                let result = r.data.result;
                if (result === true) {
                    window.location.href="/home";
                } else {
                    let message = r.data.validate.code[0];
                    $("#custom_alert").text(message);
                    $("#custom_alert").show();
                }
                $(this).text('ورود');
            });
        } else {
            $("#custom_alert").text('کد دریافتی را وارد کنید');
            $("#custom_alert").show();
        }
    });

    $("#check_reg_code").on("click", function () {
        let code = $("#code").val();
        let mobile = $("#mobile").val();
        let username = $("#username").val();
        if (code != '') {
            if (mobile != "" && username != "") {
                $(this).text('در حال بررسی ...');
                verify_reg_code(code, mobile, username).then(r => {
                    console.log(r.data)
                    let result = r.data.result;
                    if (result === true) {
                        window.location.href="/home";
                    } else {
                        let message = r.data.validate.code[0];
                        $("#custom_alert").text(message);
                        $("#custom_alert").show();
                    }
                    $(this).text('ورود');
                });
            } else {
                $("#custom_alert").text('مشکل در ورود اطلاعات');
                $("#custom_alert").show();
            }
        } else {
            $("#custom_alert").text('کد دریافتی را وارد کنید');
            $("#custom_alert").show();
        }
    });

    $(".post_text_expander").on('click', function () {
        let pid = $(this).attr("data-p");
        if ($(this).hasClass('expanded')) {
            $(this).removeClass('expanded');
            $(this).text('بیشتر');
            $("#post_text_" + pid).addClass('vertical_ellipsis_text_3line');

        } else {
            $(this).addClass('expanded');
            $(this).text('کمتر');
            $("#post_text_" + pid).removeClass('vertical_ellipsis_text_3line');
        }
    });

    $(".like_post").on('click', function () {
        let pid = $(this).attr("data-p");
        if ($(this).find('svg').find('path').hasClass('liked')) {
            $(this).find('svg').find('path').removeClass('liked');
            $("#post_like_num_" + pid).text(parseInt($("#post_like_num_" + pid).text()) - 1);
        } else {
            $(this).find('svg').find('path').addClass('liked');
            $("#post_like_num_" + pid).text(parseInt($("#post_like_num_" + pid).text()) + 1);

        }
        like_dislike(pid).then(r => {
            console.log(r.data)
        });
    });

    $(".save_post").on('click', function () {
        let pid = $(this).attr("data-p");
        if ($(this).find('path').hasClass('saved')) {
            $(this).find('path').removeClass('saved');
            $(this).find('svg').removeClass('saved');
        } else {
            $(this).find('path').addClass('saved');
            $(this).find('svg').addClass('saved');
        }
        save_unsave(pid).then(r => {
            console.log(r.data.result)
        })
    });

    $(".comment_post,.see-all-comment").on('click', function () {
        let pid = $(this).data("p");
        $(".send_comment_overlayer").fadeIn(200);
        setTimeout(function () {
            $(".send_comment_container_layer").css('bottom', '0');
        }, 200);
        comment_pid = pid;
        $(".skeleton-tmwinnmwctg").show();
        setTimeout(function () {
            get_comments(pid).then(r => {
                $(".skeleton-tmwinnmwctg").hide();
                $(".all-comments").children().remove();
                for (var key in r.data.result) {
                    console.log()
                    let text = r.data.result[key].text;
                    let username = r.data.result[key].user.username;
                    let profile = user_profile + "/" + r.data.result[key].user.profile;
                    $(".all-comments").append(`
                    <div class="comment-1 comment">
                        <img class="profile" src="${profile}" alt="">
                        <span class="comment_username">${username}</span>
                        <span class="the_comment_text">${text}</span>
                    </div>
                `);
                }
            });
        }, 1500);
    });

    $(".send_comment_box button").on("click", function () {
        let rnd_id = "comment_" + Math.floor(Math.random() * 111111);
        let comment = $("#send_comment_text").val();
        if (comment != '') {
            $("#post_" + comment_pid + " .comment-main").prepend(`
                <div class="comment-1 comment" id="${rnd_id}" style="opacity: 30%;">
                    <img class="profile" src="${current_user_profile}" alt="">
                    <span class="comment_username">${current_user_username}</span>
                    <span class="the_comment_text">${comment}</span>
                </div>
            `);
            $("#post_" + comment_pid + " .comment-main").show();
            $(".send_comment_container_layer").css('bottom', '-100%');
            setTimeout(function () {
                $(".send_comment_overlayer").fadeOut(200);
                $("#send_comment_text").val('');
            }, 200);
            send_comment(comment_pid, comment).then(r => {
                if (r.data.result == true) {
                    setTimeout(function () {
                        $("#" + rnd_id).css('opacity', '100%');
                    }, 2000);
                }
            });
        }
    });

    $(".send_comment_overlayer").on('click', function () {
        $(".send_comment_container_layer").css('bottom', '-100%');
        setTimeout(function () {
            $(".send_comment_overlayer").fadeOut(200);
        }, 200);
    });

    $(".send_comment_overlayer").children().on("click", function (e) {
        e.stopPropagation();
    })


    $(window).on("scroll", trackPostViews);


    $("#upload-form .publish-button").on("click",function (e){
       let file=$("#filename").val();
       let caption=$("#caption-addnew-post").val();
       if(file != "" && caption != ""){

       }else{
           e.preventDefault();
           $("#new_post_alert").show();
           $("#new_post_alert").html(`
                <li>لطفا فرم را تکمیل کنید</li>
           `);
       }
    });



    $(".upload-file").on("change",function (){
        return;
        const file = this.files[0];
        id = $(this).attr("id")
        previewimg = $("[for='"+id+"']").children("img")
        if (file) {
            previewimg.attr("src",URL.createObjectURL(file))
        }
    })

    
    //////////////// video player /////////////////

  function isInView(el) {
        var rect = el.getBoundingClientRect();           // absolute position of video element
        return !(rect.top > $(window).height() || rect.bottom < 0) && el.offsetParent !== null;   // visible?
    }
    $('video').each(function () {
        var video = this;
        video.pause()
    });
    ///زمانی که کاربر دستش رو روی یک ویدئو نگه داره
    $('.scroll-play video').on('touchstart', function(event) {
        var video = this; // Reference to the current video element

        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    });

///زمانی که کاربر دستش رواز روی یک ویدئو بر داره
    $('.scroll-play video').on('touchend', function() {
        this.play();
    });


    $(document).on("scroll", function() {
        $( ".scroll-play video" ).each(function() {
            if (isInView($(this)[0])) {                    // visible?
                if ($(this)[0].paused)
                {
                    $(this)[0].play();
                    setTimeout(function (video = this){
                        $('video').prop('muted', false);
                        console.log(video)
                    },1000)
                };
            }
            else {
                if (!$(this)[0].paused) $(this)[0].pause();  // pause if not paused
            }
        });
    });


    // متغیری برای ذخیره کردن وضعیت پخش (true یا false)
    var isPlaying = false;

    // انتخاب تمام عناصر ویدئو
    var videos = $("video");



    $('video').click(function() {
        vido_tag = $(this).get(0)
        if(vido_tag.paused){
            $(this).css('object-fit','fill')
        }else {
            $(this).css('object-fit','contain')
        }
    });
    $('video').on('fullscreenchange webkitfullscreenchange mozfullscreenchange', function() {
        current_fit = $(this).css('object-fit')
        if ($(this).css('object-fit') == "contain")
        {
            $(this).css('object-fit','fill')
        }else
        {
            $(this).css('object-fit','contain')
        }

    });








/*    var InstaVideo = function (el) {

        this.$video    = $(el);
        this.$wrapper  = $(el).parent().addClass('paused');
        this.$controls = this.$wrapper.find('.video-controls');
        console.log(el)
        // remove native controls
       //this.$video.removeAttr('controls');

        // check if video should autoplay
        if(!!this.$video.attr('autoplay')) {
            this.$wrapper.removeClass('paused').addClass('playing');
        }

        // check if video is muted
        if(this.$video.attr('muted') === 'true' || this.$video[0].volume === 0) {
            this.$video[0].muted = true;
            this.$wrapper.addClass('muted');
        }

        // attach event handlers
        this.attachEvents();
    };



    InstaVideo.prototype.attachEvents = function () {

        var self = this,
            _t; // keep track of timeout for controls

        // attach handlers to data attributes
        this.$wrapper.on('click', '[data-media]', function () {

            var data = $(this).data('media');

            if(data === 'play-pause') {
                self.playPause();
            }
            if(data === 'mute-unmute') {
                self.muteUnmute();
            }
        });

        this.$video.on('click', function () {
            self.playPause();

        });

        this.$video.on('play', function () {
            self.$wrapper.removeClass('paused').addClass('playing');
        });

        this.$video.on('pause', function () {
            self.$wrapper.removeClass('playing').addClass('paused');
        });

        this.$video.on('volumechange', function () {
            if($(this)[0].muted) {
                self.$wrapper.addClass('muted');
            }
            else {
                self.$wrapper.removeClass('muted');
            }
        });

        this.$wrapper.on('mousemove', function () {

            // show controls
            self.$controls.addClass('video-controls--show');

            // clear original timeout
            clearTimeout(_t);

            // start a new one to hide controls after specified time
            _t = setTimeout(function () {
                self.$controls.removeClass('video-controls--show');
            }, 2250);

        }).on('mouseleave', function () {
            self.$controls.removeClass('video-controls--show');
        });
    };

    InstaVideo.prototype.playPause = function (status='') {
        this.$video[0].webkitRequestFullscreen();
        this.$video[0].mozRequestFullscreen();
        this.$video[0].requestFullscreen();
        console.log('clioc')
        if (this.$video[0].paused || status=='play') {
             //this.$video[0].play();



        } else if (status=='' || status=='pause') {
           // this.$video[0].pause();

        }
    };

    InstaVideo.prototype.muteUnmute = function () {
        if(this.$video[0].muted === false) {
            this.$video[0].muted = true;
        } else {
            this.$video[0].muted = false;
        }
    };

    $('video').each(function () {
        new InstaVideo(this);
    });*/




    //////////////profile navbar /////////////////////////////
    jQuery(".profile_navbar_item").click(function (){
        show_id = jQuery(this).attr("data-selected")
        $('video').each(function () {
            var video = this;
            video.pause()
        });
        jQuery(".user-profile-section").hide()
        jQuery("#"+show_id).show()
        jQuery(".profile_navbar_item").css("background","none")
        jQuery(this).css("background","#e7e7e7")

    })




    ///////////////////////// upload profile image ///////////////////////
    function preview_profile_image() {
        var fileObject = document.getElementById('edit-profile-img').files;
        document.getElementById('profile-image').src = URL.createObjectURL(fileObject[0]);
    }
    jQuery("#edit-profile-img").on("change",function (){
        preview_profile_image();
        $("#profileimageUploadForm").submit();
    })


    $('#profileimageUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#profile-image").css("opacity","20%")
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
                $("#profile-image").css("opacity","100%")
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));




    //////////////// open share dialog box ////////////////////
    $(".share_post").click(function (){
        const shareData = {
            title: "Share link",
            text: "Dr.universe",
            url: $(this).attr("data-share-link"),
        };
        try {
             navigator.share(shareData);
            console.log("shared successfully");
        } catch (err) {
            console.log(`Error: ${err}`)
        }
    })


    document.addEventListener('backbutton', function(){
        event.preventDefault()
        navigator.app.exitApp();
    });
});


/////////////////////full screen //////////////////////
/* Get the documentElement (<html>) to display the page in fullscreen */


/* View in fullscreen */
function openFullscreen() {
    var elem = document.documentElement;
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }
}

async function verify_login_code(code, mobile) {
    let res;
    const formData = new FormData();
    formData.append('code', code);
    formData.append('mobile', mobile);
    await axios.post('/verifying', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

async function verify_reg_code(code, mobile, username) {
    let res;
    const formData = new FormData();
    formData.append('code', code);
    formData.append('mobile', mobile);
    formData.append('username', username);
    await axios.post('/reg_verifying', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

function trackPostViews() {
    $(".post-detail[data-viewed|='false']").each(function () {
        var post = $(this);
        var postID = post.data("p");
        var isViewed = post.data("viewed");
        if (isViewed === false && elementIsVisibleInViewport(post[0])) {
            post.data("viewed", true);
            $("#post_view_num_" + postID).text(parseInt($("#post_view_num_" + postID).text()) + 1);
            //send to server
            set_view(postID);
        }
    });
}

const elementIsVisibleInViewport = (el, partiallyVisible = false) => {
    const {top, left, bottom, right} = el.getBoundingClientRect();
    const {innerHeight, innerWidth} = window;
    if (top > 0 && top < innerHeight) {
        return true;
    }
    return false;
};

async function like_dislike(post_id) {
    let res;
    const formData = new FormData();
    formData.append('post_id', post_id);
    await axios.post('/like-dislike', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

async function set_view(post_id) {
    let res;
    const formData = new FormData();
    formData.append('post_id', post_id);
    await axios.post('/set_view_post', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

async function save_unsave(post_id) {
    let res;
    const formData = new FormData();
    formData.append('post_id', post_id);
    await axios.post('/save_unsave', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

async function send_comment(post_id, comment) {
    let res;
    const formData = new FormData();
    formData.append('post_id', post_id);
    formData.append('comment', comment);
    await axios.post('/send_comment', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}

async function get_comments(post_id) {
    let res;
    const formData = new FormData();
    formData.append('post_id', post_id);
    await axios.post('/get_comments', formData)
        .then(response => {
            res = response
        })
        .catch(err => {
            console.warn(err);
        });
    return res;
}
