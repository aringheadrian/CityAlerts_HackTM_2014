<DOCTYPE html>
<html>
<head>
   <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
   <title>City Alerts</title>
</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '794310247279052',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>

<script>
$(document).load(function(){
console.log("on load");
$('li').each(function(i){if(i>40){$(this).hide()}});
});
</script>
<ul>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>
<li> a </li>
<li> b </li>
<li> c </li>

</ul>
<img src="/cityalerts_dbase.png" alt="database img"/>
</body>
</html>


