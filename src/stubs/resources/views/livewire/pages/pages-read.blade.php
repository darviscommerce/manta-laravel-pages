<div>
    <header data-w-id="3339cf5f-7cda-ad45-215e-f8468df53303" class="header wf-section">
        <h1 data-w-id="3339cf5f-7cda-ad45-215e-f8468df53304"
            style="-webkit-transform:translate3d(0, 20px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 20px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 20px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 20px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);opacity:0"
            class="hero-h1">{{ $item->title }}</h1>
        <div class="header-image-wrapper">
            <div class="div-overflow-hidden"><img src="/theme/otterlo/images/hero-image.jpg" alt="Otterlo" sizes="100vw"
                    srcset="/theme/otterlo/images/hero-image-p-500.jpg 500w, /theme/otterlo/images/hero-image-p-800.jpg 800w, /theme/otterlo/images/hero-image-p-1080.jpg 1080w, /theme/otterlo/images/hero-image-p-1600.jpg 1600w, /theme/otterlo/images/hero-image-p-2000.jpg 2000w, /theme/otterlo/images/hero-image.jpg 2500w"
                    class="header-image"></div>
        </div>
    </header>
    <section class="section wf-section">
        <div class="container_1200px">
            <div class="w-richtext">
                {{ $item->excerpt }}

                {!! $item->content !!}
            </div>
        </div>
    </section>
</div>
