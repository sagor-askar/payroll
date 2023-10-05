<script>
    $.ajax({
    url: "https://geolocation-db.com/jsonp",
    jsonpCallback: "callback",
    dataType: "jsonp",
    success: function(location) {
        $('#postal').val(location.postal);
      console.log('location',location);
    }
  });

</script>