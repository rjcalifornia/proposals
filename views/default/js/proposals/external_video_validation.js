/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");

console.log('9fdf');



$( "#external_video" ).keyup(function() {
    var p = document.getElementById('share');
    var url = $('#external_video').val();
        if (url != undefined || url != '') {
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
            }
            }

});


   
});