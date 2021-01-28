$('.user-index button.img-upload').on('click', function () {
  $('input#upload_' + $(this).attr('data-id')).click()
})

$('.user-index button.img-remove').on('click', function () {
  if (confirm('Are you sure you want to delete this image?')) {
    var b = $(this);
    $.ajax({
      type:'POST',
      url:'/admin/user/image-remove',
      data:{id:b.attr('data-id')},
      error:function () {},
      success:function (data) {
        if(data){
          b.parents('div.image-control').siblings('img').remove();
        }
      }
    })
  }
})