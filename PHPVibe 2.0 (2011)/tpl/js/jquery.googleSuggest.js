/**@license
This file uses Google Suggest for jQuery plugin (licensed under GPLv3) by Haochi Chen ( http://ihaochi.com )
 */
$.fn.googleSuggest = function(opts){
  var services = {youtube: 'yt', books: 'bo', products: 'pr', news: 'n', images: 'i'};
  
  opts = $.extend({service: '', secure: false}, opts);
  opts.source = function(request, response){
    $.ajax({
      url: 'http'+(opts.secure?'s':'')+'://clients1.google.com/complete/search',
      dataType: 'jsonp',
      data: {
        q: request.term,
        ds: opts.service in services ? services[opts.service] : '',
        nolabels: 't'
      },
      success: function( data ) {
        response($.map(data[1], function(item){
          return { value: item[0] }
        }));
      }
    });  
  };
  
  return this.each(function(){
    $(this).autocomplete(opts);
  });
}