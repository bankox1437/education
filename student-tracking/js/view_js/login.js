const [form] = document.getElementsByTagName("form");
form.addEventListener("submit", (e) => {
  e.preventDefault();
  console.log($("#username").val());
  const username = $("#username").val();
  const password = $("#password").val();
  $.ajax({
    type: "POST",
    url: "controllers/login_controller",
    data: {
      login_method: true,
      username: username,
      password: password,
    },
    success: function (data) {
      const json_data = JSON.parse(data);
      alert(json_data.msg);
      if (json_data.status) {
        location.href = "dashboard";
      }
    },
  });
});
