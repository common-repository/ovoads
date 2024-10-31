window.onload = function () {
  var advertises = document.getElementsByClassName("advertisementDiv");
  var siteurl = window.location.protocol + '//' + window.location.host;
  var inx;

  for (inx = 0; inx < advertises.length; inx++) {
    advertises[inx].setAttribute("style", "");
    var getAdSize = advertises[inx].getAttribute('data-adsize');
    var getAd = advertises[inx].getAttribute('data-ad');
    var AdUrl = siteurl + 'ovoads-show?ad_code=' + getAd + '&ad_size=' + getAdSize;
    var xhttp = new XMLHttpRequest();
    xhttp.customdata = advertises[inx];
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        this.customdata.innerHTML = this.responseText;
      }
    };
    xhttp.open('GET', AdUrl, true);
    xhttp.send();
  }
 
  setTimeout(() => {
    var add_inner_icon = document.querySelectorAll('.ad-inner-remove-icon');
    add_inner_icon.forEach((icon) => {
      icon.addEventListener('click', function(){
        icon.parentElement.style.display = "none";
      })
    });
  },2000);
  


  setTimeout(() => {
    var ad_redirect_link = document.querySelectorAll('.ad-redirect-link');

    // Iterate through the ad_redirect_link elements
    ad_redirect_link.forEach((link) => {
      var id = link.getAttribute('data-ad');
      link.addEventListener('click', function () {
        var siteUrl = window.location.protocol + '//' + window.location.host;
        var Ad = siteUrl + 'ovoads-click?ad_code=from_click&ad_id=' + id;

        // Send an XMLHttpRequest with the updated Ad URL
        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', Ad, true);
        xhttp.send();
      });
    });
      
  }, 2000);
  
}