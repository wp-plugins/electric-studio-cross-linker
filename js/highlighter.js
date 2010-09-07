//console.log("highlighter.js loaded");
$(document).ready(function(){
  //var string = "the";
   $("p").each(function () {
    for ( var i in titles ){
      $(this).html($(this).html().replace(" "+titles[i][0]+" ",' <a href="' + homeurl + '?p=' + titles[i][1] + '">' + titles[i][0] + '</a> '));
    }
  });
});
