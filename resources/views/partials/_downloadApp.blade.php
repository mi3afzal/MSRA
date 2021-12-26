<section class="downloadapp">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-md-12">
                <h2 class="text-uppercase">Download The App</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam possimus eaque magnam eum praesentium unde.</p>
                <ul class="list-unstyled">
                    <?php
                    $apple_store = (!empty($sociallinks->apple_store)) ? $sociallinks->apple_store : "";
                    $google_play = (!empty($sociallinks->google_play)) ? $sociallinks->google_play : "";
                    ?>
                    <a href="<?php echo $apple_store; ?>">
                        <li><img src="{{url('/images/appstore.png')}}" alt="apple"></li>
                    </a>
                    <a href="<?php echo $google_play; ?>">
                        <li><img src="{{url('/images/googleplay.png')}}" alt="google"></li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</section>