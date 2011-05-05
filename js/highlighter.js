jQuery(document).ready(function($){
   $("p").each(function () {
    for ( var i in titles ){
      if(pluralForms=="s"){
        regex = new RegExp("([('\\s]"+titles[i][0]+"s?[)'\\s])","gi");
      }else if(pluralForms==""){
        regex = new RegExp("([('\\s]"+titles[i][0]+"[)'\\s])","gi");
      }
      $(this).html($(this).html().replace(regex,'<a href="' + homeurl + '?p=' + titles[i][1] + '">' + "$1" + '</a>'));
    }
  });
});
