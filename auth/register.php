<?php require_once 'authHeader.php'; ?>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f5f7fa;
  }

  .img-column {
    background: url('your-smiling-man.jpg') no-repeat center center/cover;
    position: relative;
    height: 100%;
    min-height: 100%;
  }

  .img-column::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 123, 255, 0.6); /* blue overlay */
    z-index: 1;
  }

  .form-column {
    background: #ffffff;
    padding: 30px;
    position: relative;
    z-index: 2;
  }

  .autocomplete-container {
    position: relative;
  }

  #suggestions {
    background: white;
    border: 1px solid #ccc;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 9999;
  }

  #suggestions div {
    padding: 10px;
    cursor: pointer;
  }

  #suggestions div:hover {
    background-color: #f0f0f0;
  }

  .form-label {
    font-weight: 600;
  }

  .heading {
    text-align: center;
    font-weight: bold;
    font-size: 24px;
    width: 100%;
  }
</style>

<body>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-12">
            <div class="heading ">Register / Have an account<a href="Login" class="text-decoration-none mt-1 p-2" style="position: relative; top: -10px;">Login</a></div>
        <form method="POST">
          <div class="row g-0">

            <!-- First Column: Image -->
            <div class="col-md-3 img-column d-none d-md-block" style="overflow: hidden;">
              <img src="../assets/images/f0145627-800px-wm.jpg" style="position:relative; left: -180px;"alt="">
            </div>

            <!-- Second Column -->
            <div class="col-md-4 form-column">
              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>

              <div class="mb-3">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
              </div>

              <div class="mb-3">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              
              <div class="mb-3" >
                <label for="phone" class="form-label">Phone Number:</label>
                <input type="number" class="form-control" id="phone" name="phone" required>
              </div>
            </div>

            <!-- Third Column -->
            <div class="col-md-5 form-column">
              <div class="heading d-md-none">Register</div> <!-- For small screens -->
              <div class="" style="margin-top: 65px;">
                <label for="address" class="form-label">Address:</label>
                <div class="autocomplete-container">
                  <input id="address" name="address" type="text" autocomplete="off" placeholder="21 Road, Lagos">
                  <div id="suggestions"></div>
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <div class="mb-3">
                <label for="rpassword" class="form-label">Repeat Password:</label>
                <input type="password" class="form-control" id="rpassword" name="rpassword" required>
              </div>
            </div>

          </div>

            <button type="submit" style="position: relative; top: -35px; z-index: 1000;" name="reg_submit" class="btn btn-primary w-100 mt-2">Register</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const apiKey = "pk.a6b480b0d745255f1300dcb95684b390";

    document.getElementById("address").addEventListener("input", function () {
      const query = this.value;
      const suggestions = document.getElementById("suggestions");

      if (query.length < 3) {
        suggestions.innerHTML = "";
        return;
      }

      fetch(`https://api.locationiq.com/v1/autocomplete?key=${apiKey}&q=${encodeURIComponent(query)}&limit=5&countrycodes=ng&normalizecity=1`)
        .then(res => res.json())
        .then(data => {
          suggestions.innerHTML = "";
          data.forEach(place => {
            const div = document.createElement("div");
            div.textContent = place.display_name;
            div.onclick = () => {
              document.getElementById("address").value = place.display_name;
              suggestions.innerHTML = "";
            };
            suggestions.appendChild(div);
          });
        })
        .catch(err => {
          console.error("Autocomplete Error:", err);
          suggestions.innerHTML = "";
        });
    });

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".autocomplete-container")) {
        document.getElementById("suggestions").innerHTML = "";
      }
    });
  </script>
</body>
