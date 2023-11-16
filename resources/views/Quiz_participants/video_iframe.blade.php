<!DOCTYPE html>
<html>
<head>
	<title>Video Conference</title>
	<script src='https://8x8.vc/external_api.js' async></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>html, body, #jaas-container { height: 100%; }</style>
    <script type="text/javascript">
      window.onload = () => {
        var slug=document.getElementById('slug').value;
        const api = new JitsiMeetExternalAPI("8x8.vc", {
          roomName: "vpaas-magic-cookie-fa4fa02f098645fea27f84b4c1c4ced7/"+slug,
          parentNode: document.querySelector('#jaas-container')
        });
      }


    </script>

</head>
<body>

<div id="jaas-container" />

<input type="hidden" name="slug" id="slug" value="{{$slug}}">

</body>
</html>