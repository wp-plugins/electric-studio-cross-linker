$(document).ready(function(){
console.log(exactMatchesOnly);
console.log(pluralForms);
  //var string = "the";
   $("p").each(function () {
    for ( var i in titles ){
      $(this).html($(this).html().replace(exactMatchesOnly+titles[i][0]+pluralForms+exactMatchesOnly,' <a href="' + homeurl + '?p=' + titles[i][1] + '">' + titles[i][0] + '</a> '));
    }
  });
});
