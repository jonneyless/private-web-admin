

<div class="popup-image">
    <span class="close-popup">&times;</span>
    <img src="" alt="">
</div>

<script src="{{ asset('vendor/layer-v3.3.0/layer/layer.js') }}"></script>

<script>
  $(function () {
    $(".file_path").click(function () {
      $('.popup-image').children('img').attr('src', this.src);
      $(".popup-image").show();
    })
    $(".close-popup").click(function () {
      $(".popup-image").hide();
    })
    $(".file-message").click(function () {
      let url = $(this).children('a').attr('href')
      window.open(url)
    })
  });
</script>

@yield('child')
