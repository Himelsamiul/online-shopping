
<!DOCTYPE html>
<html>
<head>
<title>Easy Shop</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="{{url('frontend/assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('frontend/assets/css/plugins.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('frontend/assets/css/style.css')}}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Sd4Y0FNgK0sZzW0Y1qjodYxy0phAJ+hdftOt3IR6aBevG3DPn0/nr+6RPZgk9T5q4oInFP5bmZbV2gb3nkztgA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style type="text/css">
#freecssfooter{display:block;width:100%;padding:120px 0 20px;overflow:hidden;background-color:transparent;z-index:5000;text-align:center;}
#freecssfooter div#fcssholder div{display:none;}
#freecssfooter div#fcssholder div:first-child{display:block;}
#freecssfooter div#fcssholder div:first-child a{float:none;margin:0 auto;}
</style></head>
<body class="main-layout">
<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = '//s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
<div class="loader_bg">
  <div class="loader"><img src="{{url('frontend/assets/images/loading.gif')}}" alt="website template image"></div>
</div>




@include('frontend.partials.header')




@yield('content')



@include('frontend.partials.footer')




<script src="{{url('frontend/assets/js/jquery.min.js')}}"></script>
<script src="{{url('frontend/assets/js/popper.min.js')}}"></script>
<script src="{{url('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('frontend/assets/js/jquery.migrate.min.js')}}"></script>
<script src="{{url('frontend/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{url('frontend/assets/js/custom.js')}}"></script>
@yield('scripts')
<div id="freecssfooter">
  <div id="fcssholder">
    <div id="bsap_2365" class="bsarocks bsap_b893e54e42ad5b76e7b252f59be18e67"></div>
  </div>
</div>
<script type="text/javascript">
var gaProperty = 'UA-120201777-1';var disableStr = 'ga-disable-' + gaProperty;if (document.cookie.indexOf(disableStr + '=true') > -1) {window[disableStr] = true;}
function gaOptout(){document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2045 23:59:59 UTC; path=/';window[disableStr] = true;alert('Google Tracking has been deactivated');}
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-120201777-1', 'auto');ga('set', 'anonymizeIp', true);ga('send', 'pageview');
</script>
</body>
</html>
