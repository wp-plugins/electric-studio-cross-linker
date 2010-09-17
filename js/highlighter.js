$(document).ready(function(){
   $("p").each(function () {
    for ( var i in titles ){

      if((exactMatchesOnly==" ")&&(pluralForms=="s")){

        regex = new RegExp("([('\\s]"+titles[i][0]+"s?[)'\\s])","gi");

      }else if((exactMatchesOnly==" ")&&(pluralForms=="")){

        regex = new RegExp("([('\\s]"+titles[i][0]+"[)'\\s])","gi");

      }else if((exactMatchesOnly=="")&&(pluralForms=="s")){

        regex = new RegExp("("+titles[i][0]+"s?)","gi");

      }else{

        regex = new RegExp("("+titles[i][0]+")","gi");

      }
        $(this).html($(this).html().replace(regex,'<a href="' + homeurl + '?p=' + titles[i][1] + '">' + "$1" + '</a>'));
      
    }
  });
});
