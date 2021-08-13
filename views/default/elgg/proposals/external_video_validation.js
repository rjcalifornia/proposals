/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");




$( "#external_video" ).keyup(function() {
    var p = document.getElementById('share');
    var url = document.getElementById("external_video").value;
        if (url != '') {
            var regExp = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            var regVimeo = /(http|https)?:\/\/(www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/;
            
            if(url.match(regExp) || url.match(regVimeo)){

            if(url.match(regExp)){
            document.getElementById("external_video_type").value = "1";
            

            }

            if(url.match(regVimeo)){
            document.getElementById("external_video_type").value = "2";
            }
            p.removeAttribute("hidden");
            }
            else{
            
            p.setAttribute("hidden", true)
           
            document.getElementById("external_video_type").value = "";
         //   document.getElementById("external_video").onblur=videoVerificationAlert;
            }
            }


           
});

 
document.getElementById("external_video").onblur=videoVerificationAlert;

function videoVerificationAlert() {
    var url = document.getElementById("external_video").value;
    var p = document.getElementById('share');
    //console.log(url);
    if (url != '') {
        var regExp = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            var regVimeo = /(http|https)?:\/\/(www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/;
            
            if(url.match(regExp) || url.match(regVimeo)){
                p.removeAttribute("hidden");
            }
            else{
                
                Swal.fire({
                    icon: 'error',
                    title: 'External video URL is not valid. Only YouTube and Vimeo are supported',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    });
                }
    }

    if (url == '') {
        p.removeAttribute("hidden");
    }
}
   
});