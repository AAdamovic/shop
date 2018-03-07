

$(document).ready(function(){
  $("footer a[href='#top']").on('click', function(event) {
  if (this.hash !== "") {
    event.preventDefault();
    var hash = this.hash;
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 900, function(){
      window.location.hash = hash;
      });
    }
  });
  
  
  $('.discount-price').prev('.price').addClass('discount');
 
  
});