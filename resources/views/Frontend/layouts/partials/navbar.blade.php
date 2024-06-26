<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand white_logo" href="index.html">
            <img src="{{ static_asset('frontend/assets/images/logo.png') }}" class="img-fluid" alt="logo">
        </a>
        <a class="navbar-brand color_logo" href="index.html">
            <img src="{{ static_asset('frontend/assets/images/logo.png') }}" class="img-fluid" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">Find Barber</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.html">Contact</a>
                </li>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        EN
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">English</a>
                        <a class="dropdown-item" href="#">language2</a>
                        <a class="dropdown-item" href="#">language3</a>
                    </div>
                </div>
            </ul>
        </div>
        <div class="header_btn">
            <button class="btn btn-warning mr-2" type="submit">Log In</button>
            <button class="btn btn-light" type="submit">Sign Up</button>
        </div>
    </nav>
</div>
