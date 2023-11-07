<!DOCTYPE html>
<html lang="en" data-theme="retro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
      href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css"
      rel="stylesheet"
      type="text/css"
    />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/e480157e34.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.css" integrity="sha512-VSD3lcSci0foeRFRHWdYX4FaLvec89irh5+QAGc00j5AOdow2r5MFPhoPEYBUQdyarXwbzyJEO7Iko7+PnPuBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js" integrity="sha512-MnKz2SbnWiXJ/e0lSfSzjaz9JjJXQNb2iykcZkEY2WOzgJIWVqJBFIIPidlCjak0iTH2bt2u1fHQ4pvKvBYy6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="style.css">
  <title>Post Anything</title>
</head>
<body class="p-10">
  <div class="max-w-sm m-auto flex flex-col w-full border-opacity-50">
    <div class="grid p-4 card bg-transparent rounded-box place-items-center">
      <h1 class="mb-4 text-3xl font-bold">Post Anything</h1>
      <h2 class="mb-2 text-xl font-semibold">Log In</h2>
      <div class="mb-2 form-control w-full">
        <label class="input-group">
          <span class="w-14 justify-center"><i class="fa-solid fa-user"></i></span>
          <input type="text" id="username" class="input input-bordered flex-1" />
        </label>
      </div>
      <div class="form-control w-full">
        <label class="input-group">
          <span class="w-14 justify-center"><i class="fa-solid fa-key"></i></span>
          <input type="password" id="password" class="input input-bordered flex-1" />
        </label>
      </div>
      <button class="btn btn-wide btn-primary mt-4" onclick="login(this)">Log In</button>
    </div>
    <div class="divider">OR</div>
    <div class="grid p-4 card bg-transparent rounded-box place-items-center">
      <h2 class="mb-2 text-xl font-semibold">Register</h2>
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Username</span>
        </label>
        <input type="text" id="reg_username" placeholder="Type here" class="input input-bordered w-full" />
      </div>
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Password</span>
        </label>
        <input type="password" id="reg_password" placeholder="Type here" class="input input-bordered w-full" />
      </div>
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Full name</span>
        </label>
        <input type="text" id="reg_full_name" placeholder="Type here" class="input input-bordered w-full" />
      </div>
      <button class="btn btn-wide btn-secondary mt-4" onclick="register(this)">Register</button>
    </div>
  </div>
  <script>
    let register = (button) => {
      let btnText = button.innerHTML;
      let formdata = new FormData();
      let xml = new XMLHttpRequest();
      formdata.append('username', document.querySelector('#reg_username').value);
      formdata.append('password', document.querySelector('#reg_password').value);
      formdata.append('full_name', document.querySelector('#reg_full_name').value);
      if (!document.querySelector('#reg_username').value) {
        window.alert('Username is blank.');
        button.innerHTML = btnText;
        return;
      }
      if (document.querySelector('#reg_username').value.length < 4) {
        window.alert('Username must be atleast 4 characters.');
        button.innerHTML = btnText;
        return;
      }
      if (document.querySelector('#reg_password').value.length < 4) {
        window.alert('Password must be atleast 4 characters.');
        button.innerHTML = btnText;
        return;
      }
      if (!document.querySelector('#reg_full_name').value) {
        window.alert('Full name is blank.');
        button.innerHTML = btnText;
        return;
      }
      xml.onreadystatechange = () => {
        if (xml.readyState === 4 && xml.status === 200) {
          let res = JSON.parse(xml.responseText);
          if (res.status === 200) {
            window.alert('Registration success! Please login.');
            location.reload();
          }
          if (res.status === 409) window.alert('Username already been used.');
          button.innerHTML = btnText;
        }
      }
      button.innerHTML = '<i class="fa-solid fa-circle-notch spin-cw"></i>';
      xml.open("POST", "/api/register.php", true);
      xml.send(formdata);
    }

    let login = (button) => {
      let btnText = button.innerHTML;
      let formdata = new FormData();
      let xml = new XMLHttpRequest();
      formdata.append('username', document.querySelector('#username').value);
      formdata.append('password', document.querySelector('#password').value);
      xml.onreadystatechange = () => {
        if (xml.readyState === 4 && xml.status === 200) {
          let res = JSON.parse(xml.responseText);
          if (res.status === 200) {
            location.assign('/home.php');
            return;
          }
          if (res.status === 404) window.alert('User not found.');
          button.innerHTML = btnText;
        }
      }
      button.innerHTML = '<i class="fa-solid fa-circle-notch spin-cw"></i>';
      xml.open("POST", "/api/login.php", true);
      xml.send(formdata);
    }
  </script>
</body>
</html>