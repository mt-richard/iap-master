$("#btnSave").click(function () {
  send(this);
});
// login for admin
$("#btnaLogin").click(function () {
  console.log("admin login");
});

function send(btn, url) {
  $(btn).attr("disabled", "disabled");
  var form = $("#formLock")[0];
  var formData = new FormData(form);
  $.ajax({
    url: "ajax_pages/user",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function () {
      NProgress.start();
    },
    success: function (res) {
      NProgress.done(true);
      $(btn).removeAttr("disabled");
      $("#error").html();
      try {
        const r = JSON.parse(res);
        if (r.data) {
          //   window.location.href = "home";
          console.log(r);
        } else {
          //   $("#error").addClass("text-danger").html(r.message);
        }
      } catch (error) {
        // $("#error").addClass("text-danger").html(error);
      }
    },
    error: function (err) {
      NProgress.done(true);
    },
  });
}
