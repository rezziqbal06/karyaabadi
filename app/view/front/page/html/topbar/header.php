<style>
    .navbar-brand-logo img {
        width: auto;
        max-height: 49px;
    }
</style>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Brand/logo -->
            <a class="navbar-brand" href="#">
                <div class="navbar-brand-logo"><img src="<?= $this->config->semevar->site_logo->path ?>" alt="$this->config->semevar->site_name"></div>
            </a>

            <!-- Toggler/collapsible Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="height:auto;padding:4px"><i class="fa fa-bars"></i></span>
            </button>

            <!-- Navigation links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>