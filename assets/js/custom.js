$(document).ready(function() {
  $('[repeat]').each(function() {
     var toRepeat = $(this).text();
     var times = parseInt($(this).attr('repeat'));
     var repeated = Array(times+1).join(toRepeat);
     $(this).text(repeated).removeAttr('repeat');
   });
 });