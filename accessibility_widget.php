/* ======================================================
   ACCESSIBILITY WIDGET
====================================================== */

add_action('wp_footer', 'tp_accessibility_widget');

function tp_accessibility_widget() {
?>

<div id="tp-accessibility-widget">

    <button type="button" id="tp-accessibility-toggle">
        <i class="fas fa-universal-access"></i>
    </button>

    <div id="tp-accessibility-panel">

        <button type="button" class="tp-a11y-btn" data-action="increase-text">
            <i class="fas fa-search-plus"></i>
            <span>Perbesar Teks</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="decrease-text">
            <i class="fas fa-search-minus"></i>
            <span>Perkecil Teks</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="grayscale">
            <i class="fas fa-adjust"></i>
            <span>Grayscale</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="contrast">
            <i class="fas fa-circle-half-stroke"></i>
            <span>High Contrast</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="highlight-links">
            <i class="fas fa-link"></i>
            <span>Highlight Link</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="readable-font">
            <i class="fas fa-font"></i>
            <span>Readable Font</span>
        </button>

        <button type="button" class="tp-a11y-btn" data-action="reset">
            <i class="fas fa-rotate-left"></i>
            <span>Reset</span>
        </button>

        <!-- FOOTER -->
        <div class="tp-a11y-footer">
            Aksebilitas by 
            <a href="https://www.instagram.com/andikaprasetyawan/" target="_blank">
                Andika P
            </a>
        </div>

    </div>

</div>

<style>

/* ======================================================
   WIDGET
====================================================== */

#tp-accessibility-widget{

    position:fixed !important;

    top:50% !important;
    right:20px !important;

    transform:translateY(-50%) !important;

    z-index:999999999 !important;

}

/* TOGGLE */

#tp-accessibility-toggle{

    width:58px;
    height:58px;

    border:none;
    border-radius:50%;

    background:#c51c00;
    color:#fff;

    font-size:24px;

    cursor:pointer;

    display:flex;
    align-items:center;
    justify-content:center;

    box-shadow:0 10px 25px rgba(0,0,0,.2);

}

/* PANEL */

#tp-accessibility-panel{

    position:absolute;

    top:50%;
    right:70px;

    transform:translateY(-50%);

    width:240px;

    background:#fff;

    border-radius:18px;

    padding:15px;

    display:none;

    flex-direction:column;
    gap:10px;

    box-shadow:0 10px 30px rgba(0,0,0,.15);

}

#tp-accessibility-panel.active{
    display:flex;
}

/* BUTTON */

.tp-a11y-btn{

    width:100%;

    display:flex;
    align-items:center;
    gap:12px;

    border:none;

    background:#f7f7f7;

    padding:12px 14px;

    border-radius:12px;

    cursor:pointer;

    font-size:15px;
    font-weight:600;

    color:#222;

}

.tp-a11y-btn:hover{

    background:#c51c00;
    color:#fff;

}

/* FOOTER */

.tp-a11y-footer{

    margin-top:8px;

    font-size:12px;

    text-align:center;

    color:#777;

}

.tp-a11y-footer a{

    color:#c51c00;

    text-decoration:none;

    font-weight:600;

}

.tp-a11y-footer a:hover{

    text-decoration:underline;

}

/* ======================================================
   ACCESSIBILITY
====================================================== */

.tp-site-wrap.tp-grayscale{
    filter:grayscale(1);
}

.tp-site-wrap.tp-high-contrast{
    filter:contrast(1.35);
}

.tp-readable-font *{
    font-family:Arial,sans-serif !important;
}

.tp-highlight-links a{
    background:yellow !important;
    color:#000 !important;
    text-decoration:underline !important;
}

/* ======================================================
   MOBILE
====================================================== */

@media(max-width:768px){

    #tp-accessibility-widget{
        right:15px !important;
    }

    #tp-accessibility-toggle{

        width:52px;
        height:52px;

        font-size:21px;

    }

    #tp-accessibility-panel{

        width:210px;
        right:62px;

    }

}

</style>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const toggle = document.getElementById("tp-accessibility-toggle");
    const panel  = document.getElementById("tp-accessibility-panel");

    let siteWrap = document.querySelector(".tp-site-wrap");

    if(!siteWrap){

        siteWrap = document.createElement("div");
        siteWrap.className = "tp-site-wrap";

        const children = [...document.body.children];

        children.forEach(el => {

            if(el.id !== "tp-accessibility-widget"){
                siteWrap.appendChild(el);
            }

        });

        document.body.insertBefore(siteWrap, document.body.firstChild);

    }

    /* =========================================
       SIMPAN FONT SIZE ASLI
    ========================================= */

    const textElements = siteWrap.querySelectorAll(
        'p,span,a,li,label,td,th,input,textarea,button,h1,h2,h3,h4,h5,h6'
    );

    textElements.forEach(el => {

        const computed = window.getComputedStyle(el).fontSize;

        el.setAttribute('data-original-font-size', computed);

    });

    let currentScale = 1;

    /* TOGGLE */

    toggle.addEventListener("click", function(e){

        e.preventDefault();
        e.stopPropagation();

        panel.classList.toggle("active");

    });

    /* CLOSE */

    document.addEventListener("click", function(e){

        if(!document.getElementById("tp-accessibility-widget").contains(e.target)){

            panel.classList.remove("active");

        }

    });

    /* ACTIONS */

    document.querySelectorAll(".tp-a11y-btn").forEach(button=>{

        button.addEventListener("click", function(e){

            e.preventDefault();

            const action = this.dataset.action;

            switch(action){

                case "increase-text":

                    currentScale += 0.1;

                    if(currentScale > 1.5){
                        currentScale = 1.5;
                    }

                    applyTextScale();

                break;

                case "decrease-text":

                    currentScale -= 0.1;

                    if(currentScale < 0.8){
                        currentScale = 0.8;
                    }

                    applyTextScale();

                break;

                case "grayscale":

                    siteWrap.classList.toggle("tp-grayscale");

                break;

                case "contrast":

                    siteWrap.classList.toggle("tp-high-contrast");

                break;

                case "highlight-links":

                    siteWrap.classList.toggle("tp-highlight-links");

                break;

                case "readable-font":

                    siteWrap.classList.toggle("tp-readable-font");

                break;

                case "reset":

                    siteWrap.classList.remove(
                        "tp-grayscale",
                        "tp-high-contrast",
                        "tp-highlight-links",
                        "tp-readable-font"
                    );

                    currentScale = 1;

                    applyTextScale();

                break;

            }

        });

    });

    /* =========================================
       APPLY SCALE TANPA MERUSAK LAYOUT
    ========================================= */

    function applyTextScale(){

        textElements.forEach(el => {

            const original = parseFloat(
                el.getAttribute('data-original-font-size')
            );

            if(original){

                el.style.fontSize = (original * currentScale) + 'px';

            }

        });

    }

});

</script>

<?php
}
